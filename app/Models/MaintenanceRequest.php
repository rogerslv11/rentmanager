<?php

namespace App\Models;

use App\Enums\MaintenanceCategory;
use App\Enums\MaintenancePriority;
use App\Enums\MaintenanceStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'property_id',
        'tenant_id',
        'vendor_id',
        'user_id',
        'title',
        'description',
        'category',
        'priority',
        'status',
        'scheduled_for',
        'started_at',
        'completed_at',
        'estimated_cost',
        'final_cost',
        'resolution_notes',
        'notes',
    ];

    protected $casts = [
        'category' => MaintenanceCategory::class,
        'priority' => MaintenancePriority::class,
        'status' => MaintenanceStatus::class,
        'scheduled_for' => 'date',
        'started_at' => 'date',
        'completed_at' => 'date',
        'estimated_cost' => 'decimal:2',
        'final_cost' => 'decimal:2',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(MaintenanceItem::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(MaintenanceQuote::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(MaintenancePhoto::class);
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'related');
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereNotIn('status', [
            MaintenanceStatus::Completed->value,
            MaintenanceStatus::Cancelled->value,
        ]);
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }
}
