<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'user_id',
        'name',
        'tax_id',
        'email',
        'phone',
        'mobile',
        'birth_date',
        'nationality',
        'marital_status',
        'profession',
        'monthly_income',
        'address',
        'city',
        'state',
        'zip_code',
        'emergency_contact_name',
        'emergency_contact_phone',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'monthly_income' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function activeContract()
    {
        return $this->hasOne(Contract::class)->where('status', 'active')->latestOfMany('start_date');
    }

    public function charges(): HasMany
    {
        return $this->hasMany(Charge::class);
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    public function documents()
    {
        return $this->morphMany(File::class, 'related');
    }

    public function initials(): string
    {
        $parts = explode(' ', $this->name);
        $first = mb_substr($parts[0] ?? '', 0, 1);
        $last = mb_substr($parts[count($parts) - 1] ?? '', 0, 1);

        return mb_strtoupper($first.$last);
    }

    public function pendingCharges(): HasMany
    {
        return $this->charges()->whereIn('status', ['pending', 'partially_paid', 'overdue']);
    }

    public function totalPending(): float
    {
        return (float) $this->pendingCharges()->sum('total_amount');
    }

    public function totalOverdue(): float
    {
        return (float) $this->charges()
            ->where('status', 'overdue')
            ->sum('total_amount');
    }
}
