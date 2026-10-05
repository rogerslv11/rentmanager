<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'payment_id',
        'charge_id',
        'number',
        'issued_at',
        'amount',
        'pdf_path',
    ];

    protected $casts = [
        'issued_at' => 'date',
        'amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Receipt $receipt) {
            if (empty($receipt->number)) {
                $receipt->number = 'REC-'.date('Y').'-'.str_pad((string) random_int(10000, 999999), 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function charge(): BelongsTo
    {
        return $this->belongsTo(Charge::class);
    }

    public function pdfUrl(): ?string
    {
        return $this->pdf_path ? asset('storage/'.$this->pdf_path) : null;
    }
}
