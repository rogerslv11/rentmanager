<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
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
        return $user->can('view properties');
    }

    public function view(User $user, Property $property): bool
    {
        return $user->can('view properties') && $user->organization_id === $property->organization_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create properties');
    }

    public function update(User $user, Property $property): bool
    {
        return $user->can('edit properties') && $user->organization_id === $property->organization_id;
    }

    public function delete(User $user, Property $property): bool
    {
        return $user->can('delete properties') && $user->organization_id === $property->organization_id;
    }
}
