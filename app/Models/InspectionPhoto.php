<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspectionPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'inspection_id',
        'path',
        'caption',
    ];

    public function inspection(): BelongsTo
    {
        return $this->belongsTo(Inspection::class);
    }

    public function url(): string
    {
        return asset('storage/'.$this->path);
    }
}
