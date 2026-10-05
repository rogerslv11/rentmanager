<?php

namespace App\Livewire\Portals;

use App\Models\Owner;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.portal')]
#[Title('Portal do Proprietário')]
class OwnerDashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $owner = Owner::where('user_id', $user->id)->first();

        $stats = [
            'properties' => $owner ? $owner->properties->count() : 0,
            'monthly_revenue' => $owner ? $owner->monthlyRevenue() : 0,
            'pending_payouts' => $owner ? $owner->pendingPayoutsAmount() : 0,
            'total_received' => $owner ? $owner->totalReceived() : 0,
        ];

        return view('livewire.portals.owner-dashboard', compact('owner', 'stats'));
    }
}
