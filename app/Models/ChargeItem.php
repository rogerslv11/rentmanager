<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChargeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'charge_id',
        'description',
        'type',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function charge(): BelongsTo
    {
        return $this->belongsTo(Charge::class);
    }
}
