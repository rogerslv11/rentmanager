<?php

namespace App\Models;

use App\Enums\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'property_id',
        'owner_id',
        'contract_id',
        'maintenance_request_id',
        'category',
        'description',
        'amount',
        'expense_date',
        'vendor_name',
        'document_path',
        'status',
        'notes',
    ];

    protected $casts = [
        'category' => ExpenseCategory::class,
        'expense_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function maintenanceRequest(): BelongsTo
    {
        return $this->belongsTo(MaintenanceRequest::class);
    }
}
