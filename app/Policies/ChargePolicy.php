<?php

namespace App\Policies;

use App\Models\Charge;
use App\Models\User;

class ChargePolicy
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
        return $user->can('view charges');
    }

    public function view(User $user, Charge $charge): bool
    {
        return $user->can('view charges') && $user->organization_id === $charge->organization_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create charges');
    }

    public function update(User $user, Charge $charge): bool
    {
        return $user->can('edit charges') && $user->organization_id === $charge->organization_id;
    }

    public function delete(User $user, Charge $charge): bool
    {
        return $user->can('delete charges') && $user->organization_id === $charge->organization_id;
    }

    public function pay(User $user, Charge $charge): bool
    {
        return $user->can('record payments') && $user->organization_id === $charge->organization_id;
    }
}
