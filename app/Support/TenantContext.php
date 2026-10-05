<?php

namespace App\Support;

use App\Models\Organization;
use Illuminate\Support\Facades\Session;

class TenantContext
{
    public static function set(Organization $organization): void
    {
        Session::put('current_organization_id', $organization->id);
        app()->instance('organization', $organization);
    }

    public static function get(): ?Organization
    {
        if (app()->has('organization')) {
            return app('organization');
        }

        $organizationId = Session::get('current_organization_id');
        if (! $organizationId) {
            return null;
        }

        $org = Organization::find($organizationId);
        if ($org) {
            app()->instance('organization', $org);
        }

        return $org;
    }

    public static function id(): ?int
    {
        return static::get()?->id;
    }

    public static function clear(): void
    {
        Session::forget('current_organization_id');
        app()->forgetInstance('organization');
    }
}
