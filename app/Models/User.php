<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'name',
        'email',
        'password',
        'avatar_path',
        'phone',
        'locale',
        'preferences',
        'is_active',
        'is_super_admin',
        'last_login_at',
        'last_login_ip',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_super_admin' => 'boolean',
            'preferences' => 'array',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function tenant(): HasOne
    {
        return $this->hasOne(Tenant::class);
    }

    public function owner(): HasOne
    {
        return $this->hasOne(Owner::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin === true;
    }

    public function hasPortalAccess(): bool
    {
        return $this->hasAnyRole([UserRole::Owner->value, UserRole::Tenant->value]);
    }

    public function initials(): string
    {
        $parts = explode(' ', $this->name);
        $first = mb_substr($parts[0] ?? '', 0, 1);
        $last = mb_substr($parts[count($parts) - 1] ?? '', 0, 1);

        return mb_strtoupper($first.$last);
    }

    public function avatarUrl(): string
    {
        if ($this->avatar_path) {
            return asset('storage/'.$this->avatar_path);
        }
        $hash = md5(strtolower(trim($this->email)));

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=22C55E&color=052E16&bold=true';
    }

    protected static function booted(): void
    {
        static::created(function (User $user) {
            if (! $user->is_super_admin && ! $user->organization_id) {
                // Will be assigned to organization later by admin
            }
        });
    }
}
