<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'name',
        'company_name',
        'tax_id',
        'email',
        'phone',
        'category',
        'specialty',
        'hourly_rate',
        'address',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(MaintenanceQuote::class);
    }

    public function initials(): string
    {
        $parts = explode(' ', $this->name);
        $first = mb_substr($parts[0] ?? '', 0, 1);
        $last = mb_substr($parts[count($parts) - 1] ?? '', 0, 1);

        return mb_strtoupper($first.$last);
    }
}
