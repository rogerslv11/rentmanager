<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'name',
        'tax_id',
        'email',
        'phone',
        'mobile',
        'address',
        'city',
        'state',
        'zip_code',
        'bank_name',
        'bank_agency',
        'bank_account',
        'bank_account_type',
        'pix_key',
        'notes',
        'is_active',
    ];

    protected $casts = [
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

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(OwnerPayout::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
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

    public function monthlyRevenue(): float
    {
        return (float) $this->properties()
            ->where('status', 'rented')
            ->sum('rent_amount');
    }

    public function pendingPayoutsAmount(): float
    {
        return (float) $this->payouts()
            ->whereIn('status', ['pending', 'scheduled'])
            ->sum('net_amount');
    }

    public function totalReceived(): float
    {
        return (float) $this->payouts()
            ->where('status', 'paid')
            ->sum('net_amount');
    }
}
