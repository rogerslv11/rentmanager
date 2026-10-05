<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'name',
        'path',
        'mime_type',
        'size',
        'version',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function url(): string
    {
        return asset('storage/'.$this->path);
    }
}
