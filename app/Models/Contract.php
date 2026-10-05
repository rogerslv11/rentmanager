<?php

namespace App\Models;

use App\Enums\ContractStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'property_id',
        'owner_id',
        'tenant_id',
        'number',
        'start_date',
        'end_date',
        'signed_at',
        'rent_amount',
        'condo_fee',
        'property_tax',
        'insurance_amount',
        'due_day',
        'adjustment_index',
        'adjustment_periodicity',
        'deposit_amount',
        'late_fee_percent',
        'interest_percent',
        'admin_fee_percent',
        'admin_fee_fixed',
        'discount_amount',
        'auto_renew',
        'status',
        'notes',
        'terms',
        'terminated_at',
        'termination_reason',
        'parent_contract_id',
    ];

    protected $casts = [
        'status' => ContractStatus::class,
        'start_date' => 'date',
        'end_date' => 'date',
        'signed_at' => 'date',
        'terminated_at' => 'date',
        'rent_amount' => 'decimal:2',
        'condo_fee' => 'decimal:2',
        'property_tax' => 'decimal:2',
        'insurance_amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'admin_fee_percent' => 'decimal:2',
        'admin_fee_fixed' => 'decimal:2',
        'late_fee_percent' => 'decimal:2',
        'interest_percent' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'auto_renew' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Contract $contract) {
            if (empty($contract->number)) {
                $contract->number = 'CT-'.date('Y').'-'.str_pad((string) random_int(1000, 999999), 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function charges(): HasMany
    {
        return $this->hasMany(Charge::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ContractDocument::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(ContractHistory::class)->orderBy('created_at', 'desc');
    }

    public function parentContract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'parent_contract_id');
    }

    public function renewals(): HasMany
    {
        return $this->hasMany(Contract::class, 'parent_contract_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', ContractStatus::Active->value);
    }

    public function scopeExpiring(Builder $query, int $days = 90): Builder
    {
        return $query->where('status', ContractStatus::Active->value)
            ->whereBetween('end_date', [now(), now()->addDays($days)]);
    }

    public function scopeForOrganization(Builder $query, int $organizationId): Builder
    {
        return $query->where('organization_id', $organizationId);
    }

    public function daysUntilExpiration(): int
    {
        return (int) now()->diffInDays($this->end_date, false);
    }

    public function isExpiring(int $days = 30): bool
    {
        return $this->daysUntilExpiration() > 0 && $this->daysUntilExpiration() <= $days;
    }

    public function isExpired(): bool
    {
        return $this->end_date->lt(now());
    }

    public function totalMonthlyAmount(): float
    {
        return (float) $this->rent_amount
            + (float) $this->condo_fee
            + (float) $this->property_tax
            + (float) $this->insurance_amount;
    }

    public function adminFeeAmount(): float
    {
        $percent = (float) ($this->admin_fee_percent ?? 0);
        $fixed = (float) ($this->admin_fee_fixed ?? 0);

        return ($this->rent_amount * ($percent / 100)) + $fixed;
    }

    public function netOwnerAmount(): float
    {
        return $this->rent_amount - $this->adminFeeAmount();
    }

    public function durationInMonths(): int
    {
        return (int) $this->start_date->diffInMonths($this->end_date);
    }

    public function updateStatus(): void
    {
        if ($this->end_date->lt(now())) {
            $this->status = ContractStatus::Expired;
        } elseif ($this->isExpiring(30)) {
            $this->status = ContractStatus::Expiring;
        } elseif (! $this->status instanceof ContractStatus) {
            $this->status = ContractStatus::Active;
        }
        $this->save();
    }
}
