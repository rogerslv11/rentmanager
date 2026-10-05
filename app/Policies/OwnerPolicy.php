<?php

namespace App\Policies;

use App\Models\Owner;
use App\Models\User;

class OwnerPolicy
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
        return $user->can('view owners');
    }

    public function view(User $user, Owner $owner): bool
    {
        return $user->can('view owners') && $user->organization_id === $owner->organization_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create owners');
    }

    public function update(User $user, Owner $owner): bool
    {
        return $user->can('edit owners') && $user->organization_id === $owner->organization_id;
    }

    public function delete(User $user, Owner $owner): bool
    {
        return $user->can('delete owners') && $user->organization_id === $owner->organization_id;
    }
}
