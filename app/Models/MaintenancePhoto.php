<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenancePhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_request_id',
        'path',
        'caption',
        'stage',
    ];

    public function maintenanceRequest(): BelongsTo
    {
        return $this->belongsTo(MaintenanceRequest::class);
    }

    public function url(): string
    {
        return asset('storage/'.$this->path);
    }
}
