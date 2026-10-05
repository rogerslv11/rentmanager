<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'charge_id',
        'amount',
        'paid_at',
        'method',
        'transaction_id',
        'receipt_path',
        'notes',
        'received_by',
    ];

    protected $casts = [
        'method' => PaymentMethod::class,
        'paid_at' => 'date',
        'amount' => 'decimal:2',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function charge(): BelongsTo
    {
        return $this->belongsTo(Charge::class);
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    public function receiptUrl(): ?string
    {
        return $this->receipt_path ? asset('storage/'.$this->receipt_path) : null;
    }
}
