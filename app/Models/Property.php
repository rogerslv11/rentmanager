<?php

namespace App\Models;

use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'owner_id',
        'code',
        'slug',
        'name',
        'type',
        'description',
        'area_total',
        'area_built',
        'bedrooms',
        'bathrooms',
        'parking_spaces',
        'floor',
        'address',
        'address_number',
        'address_complement',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'latitude',
        'longitude',
        'rent_amount',
        'condo_fee',
        'property_tax',
        'insurance_amount',
        'status',
        'is_furnished',
        'is_published',
        'pets_allowed',
        'features',
        'settings',
        'acquisition_date',
        'acquisition_value',
    ];

    protected $casts = [
        'status' => PropertyStatus::class,
        'type' => PropertyType::class,
        'features' => 'array',
        'settings' => 'array',
        'is_furnished' => 'boolean',
        'is_published' => 'boolean',
        'pets_allowed' => 'boolean',
        'area_total' => 'decimal:2',
        'area_built' => 'decimal:2',
        'rent_amount' => 'decimal:2',
        'condo_fee' => 'decimal:2',
        'property_tax' => 'decimal:2',
        'insurance_amount' => 'decimal:2',
        'acquisition_value' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'acquisition_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function (Property $property) {
            if (empty($property->slug)) {
                $property->slug = Str::slug($property->name).'-'.Str::lower(Str::random(6));
            }
            if (empty($property->code)) {
                $property->code = 'IMV-'.str_pad((string) random_int(1000, 999999), 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function owners(): BelongsToMany
    {
        return $this->belongsToMany(Owner::class)->withPivot('ownership_percent')->withTimestamps();
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PropertyPhoto::class)->orderBy('sort_order');
    }

    public function coverPhoto()
    {
        return $this->hasOne(PropertyPhoto::class)->where('is_cover', true);
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

    public function insurancePolicies(): HasMany
    {
        return $this->hasMany(InsurancePolicy::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'related');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function currentTenant()
    {
        return $this->hasOneThrough(
            Tenant::class,
            Contract::class,
            'property_id',
            'id',
            'id',
            'tenant_id'
        )->where('contracts.status', 'active');
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', PropertyStatus::Available->value);
    }

    public function scopeRented(Builder $query): Builder
    {
        return $query->where('status', PropertyStatus::Rented->value);
    }

    public function scopeForOrganization(Builder $query, int $organizationId): Builder
    {
        return $query->where('organization_id', $organizationId);
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function totalMonthlyIncome(): float
    {
        return (float) ($this->rent_amount ?? 0)
            + (float) ($this->condo_fee ?? 0)
            + (float) ($this->property_tax ?? 0)
            + (float) ($this->insurance_amount ?? 0);
    }

    public function coverUrl(): string
    {
        $cover = $this->coverPhoto ?? $this->photos()->first();
        if ($cover) {
            return asset('storage/'.$cover->path);
        }

        return 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800';
    }

    public function fullAddress(): string
    {
        return collect([
            $this->address,
            $this->address_number,
            $this->address_complement,
            $this->neighborhood,
            $this->city,
            $this->state,
            $this->zip_code,
        ])->filter()->implode(', ');
    }

    public function occupancyRate(): float
    {
        if ($this->status === PropertyStatus::Rented) {
            return 100.0;
        }
        if ($this->status === PropertyStatus::Available) {
            return 0.0;
        }

        return 0.0;
    }
}
