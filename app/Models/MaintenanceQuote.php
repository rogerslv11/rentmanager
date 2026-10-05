<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceQuote extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_request_id',
        'vendor_id',
        'amount',
        'description',
        'status',
        'valid_until',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'valid_until' => 'date',
    ];

    public function maintenanceRequest(): BelongsTo
    {
        return $this->belongsTo(MaintenanceRequest::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
