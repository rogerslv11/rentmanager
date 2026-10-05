<?php

namespace App\Models;

use App\Enums\InsuranceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsurancePolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'property_id',
        'contract_id',
        'type',
        'provider',
        'policy_number',
        'coverage_amount',
        'premium_amount',
        'start_date',
        'end_date',
        'document_path',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'type' => InsuranceType::class,
        'start_date' => 'date',
        'end_date' => 'date',
        'coverage_amount' => 'decimal:2',
        'premium_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function daysUntilExpiration(): int
    {
        return (int) now()->diffInDays($this->end_date, false);
    }

    public function isExpiring(int $days = 30): bool
    {
        return $this->daysUntilExpiration() > 0 && $this->daysUntilExpiration() <= $days;
    }
}
