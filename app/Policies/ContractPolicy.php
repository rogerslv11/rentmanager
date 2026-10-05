<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;

class ContractPolicy
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
        return $user->can('view contracts');
    }

    public function view(User $user, Contract $contract): bool
    {
        return $user->can('view contracts') && $user->organization_id === $contract->organization_id;
    }

    public function create(User $user): bool
    {
        return $user->can('create contracts');
    }

    public function update(User $user, Contract $contract): bool
    {
        return $user->can('edit contracts') && $user->organization_id === $contract->organization_id;
    }

    public function delete(User $user, Contract $contract): bool
    {
        return $user->can('delete contracts') && $user->organization_id === $contract->organization_id;
    }

    public function renew(User $user, Contract $contract): bool
    {
        return $this->update($user, $contract);
    }

    public function terminate(User $user, Contract $contract): bool
    {
        return $this->update($user, $contract);
    }
}
