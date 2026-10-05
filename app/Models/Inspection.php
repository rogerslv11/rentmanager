<?php

namespace App\Models;

use App\Enums\InspectionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'property_id',
        'contract_id',
        'tenant_id',
        'inspector_id',
        'type',
        'title',
        'scheduled_for',
        'completed_at',
        'notes',
        'summary',
        'checklist',
        'status',
    ];

    protected $casts = [
        'type' => InspectionType::class,
        'scheduled_for' => 'date',
        'completed_at' => 'date',
        'checklist' => 'array',
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

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InspectionItem::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(InspectionPhoto::class);
    }
}
