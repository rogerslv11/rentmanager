<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'user_id',
        'action',
        'changes',
        'notes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
