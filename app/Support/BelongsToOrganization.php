<?php

namespace App\Support;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToOrganization
{
    public static function bootBelongsToOrganization(): void
    {
        static::creating(function ($model) {
            if (! $model->organization_id && app()->has('organization')) {
                $model->organization_id = app('organization')->id;
            }
        });

        static::addGlobalScope('organization', function (Builder $builder) {
            if (app()->has('organization')) {
                $builder->where(
                    $builder->getModel()->getTable().'.organization_id',
                    app('organization')->id
                );
            }
        });
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function scopeForOrganization(Builder $query, int $organizationId): Builder
    {
        return $query->where($this->getTable().'.organization_id', $organizationId);
    }
}
