<?php

namespace App\Models;

use App\Enums\PayoutStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OwnerPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'owner_id',
        'contract_id',
        'reference',
        'gross_amount',
        'admin_fee',
        'maintenance_amount',
        'other_deductions',
        'net_amount',
        'period_start',
        'period_end',
        'paid_at',
        'scheduled_for',
        'status',
        'payment_method',
        'transaction_id',
        'notes',
    ];

    protected $casts = [
        'status' => PayoutStatus::class,
        'period_start' => 'date',
        'period_end' => 'date',
        'paid_at' => 'date',
        'scheduled_for' => 'date',
        'gross_amount' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'maintenance_amount' => 'decimal:2',
        'other_deductions' => 'decimal:2',
        'net_amount' => 'decimal:2',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}
