<?php

namespace App\Models;

use App\Enums\ChargeStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Charge extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'contract_id',
        'property_id',
        'tenant_id',
        'reference',
        'description',
        'rent_amount',
        'condo_fee',
        'property_tax',
        'insurance_amount',
        'late_fee',
        'interest',
        'discount',
        'other_amount',
        'total_amount',
        'paid_amount',
        'due_date',
        'paid_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => ChargeStatus::class,
        'due_date' => 'date',
        'paid_at' => 'date',
        'rent_amount' => 'decimal:2',
        'condo_fee' => 'decimal:2',
        'property_tax' => 'decimal:2',
        'insurance_amount' => 'decimal:2',
        'late_fee' => 'decimal:2',
        'interest' => 'decimal:2',
        'discount' => 'decimal:2',
        'other_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ChargeItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    public function daysOverdue(): int
    {
        if (! $this->due_date) {
            return 0;
        }
        $diff = now()->diffInDays($this->due_date, false);

        return $diff < 0 ? abs($diff) : 0;
    }

    public function isOverdue(): bool
    {
        return in_array($this->status, [ChargeStatus::Pending, ChargeStatus::PartiallyPaid])
            && $this->due_date && $this->due_date->lt(now());
    }

    public function remainingAmount(): float
    {
        return (float) ($this->total_amount - $this->paid_amount);
    }

    public function refreshStatus(): void
    {
        if ($this->paid_amount >= $this->total_amount && $this->total_amount > 0) {
            $this->status = ChargeStatus::Paid;
            $this->paid_at = $this->paid_at ?? now();
        } elseif ($this->paid_amount > 0) {
            $this->status = ChargeStatus::PartiallyPaid;
        } elseif ($this->isOverdue()) {
            $this->status = ChargeStatus::Overdue;
        } else {
            $this->status = ChargeStatus::Pending;
        }
        $this->save();
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->whereIn('status', [ChargeStatus::Pending->value, ChargeStatus::PartiallyPaid->value]);
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('status', ChargeStatus::Overdue->value)
            ->orWhere(function ($q) {
                $q->whereIn('status', [ChargeStatus::Pending->value, ChargeStatus::PartiallyPaid->value])
                    ->where('due_date', '<', now());
            });
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', ChargeStatus::Paid->value);
    }

    public function scopeForOrganization(Builder $query, int $organizationId): Builder
    {
        return $query->where('organization_id', $organizationId);
    }
}
