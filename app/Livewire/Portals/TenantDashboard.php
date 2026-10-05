<?php

namespace App\Livewire\Portals;

use App\Models\Tenant;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.portal')]
#[Title('Portal do Inquilino')]
class TenantDashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $tenant = Tenant::where('user_id', $user->id)->first();

        $stats = [
            'active_contract' => $tenant?->activeContract,
            'pending' => $tenant ? $tenant->totalPending() : 0,
            'overdue' => $tenant ? $tenant->totalOverdue() : 0,
            'maintenance' => $tenant ? $tenant->maintenanceRequests()->whereNotIn('status', ['completed', 'cancelled'])->count() : 0,
        ];

        return view('livewire.portals.tenant-dashboard', compact('tenant', 'stats'));
    }
}
