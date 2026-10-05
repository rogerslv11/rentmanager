<?php

namespace App\Policies;

use App\Models\MaintenanceRequest;
use App\Models\User;

class MaintenancePolicy
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
        return $user->can('view maintenance');
    }

    public function view(User $user, MaintenanceRequest $maintenance): bool
    {
        return $user->can('view maintenance') && $user->organization_id === $maintenance->organization_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create maintenance');
    }

    public function update(User $user, MaintenanceRequest $maintenance): bool
    {
        return $user->can('edit maintenance') && $user->organization_id === $maintenance->organization_id;
    }

    public function delete(User $user, MaintenanceRequest $maintenance): bool
    {
        return $user->can('delete maintenance') && $user->organization_id === $maintenance->organization_id;
    }
}
