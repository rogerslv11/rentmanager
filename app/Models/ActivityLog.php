<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function icon(): string
    {
        return match (true) {
            str_contains($this->action, 'create') => 'plus-circle',
            str_contains($this->action, 'update') || str_contains($this->action, 'edit') => 'edit',
            str_contains($this->action, 'delete') || str_contains($this->action, 'destroy') => 'trash-2',
            str_contains($this->action, 'payment') || str_contains($this->action, 'paid') => 'check-circle',
            str_contains($this->action, 'login') => 'log-in',
            str_contains($this->action, 'logout') => 'log-out',
            str_contains($this->action, 'upload') => 'upload',
            default => 'activity',
        };
    }
}
