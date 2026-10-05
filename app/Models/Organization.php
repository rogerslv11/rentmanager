<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'legal_name',
        'tax_id',
        'email',
        'phone',
        'logo_path',
        'website',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'settings',
        'default_admin_fee_percent',
        'default_admin_fee_fixed',
        'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'default_admin_fee_percent' => 'decimal:2',
        'default_admin_fee_fixed' => 'decimal:2',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function owners(): HasMany
    {
        return $this->hasMany(Owner::class);
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function charges(): HasMany
    {
        return $this->hasMany(Charge::class);
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function logoUrl(): string
    {
        if ($this->logo_path) {
            return asset('storage/'.$this->logo_path);
        }

        return '';
    }

    public function adminFeePercent(): float
    {
        return (float) ($this->default_admin_fee_percent ?? 8.00);
    }

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (Organization $org) {
            if (empty($org->slug)) {
                $org->slug = Str::slug($org->name).'-'.Str::lower(Str::random(4));
            }
        });
    }
}
