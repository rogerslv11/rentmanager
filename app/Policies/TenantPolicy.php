<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;

class TenantPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->is_super_admin) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view tenants');
    }

    public function view(User $user, Tenant $tenant): bool
    {
        return $user->can('view tenants') && $user->organization_id === $tenant->organization_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create tenants');
    }

    public function update(User $user, Tenant $tenant): bool
    {
        return $user->can('edit tenants') && $user->organization_id === $tenant->organization_id;
    }

    public function delete(User $user, Tenant $tenant): bool
    {
        return $user->can('delete tenants') && $user->organization_id === $tenant->organization_id;
    }
}
