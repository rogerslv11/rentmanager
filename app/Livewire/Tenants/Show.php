<?php

namespace App\Livewire\Tenants;

use App\Models\Tenant;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Inquilino')]
class Show extends Component
{
    public Tenant $tenant;

    public function mount(Tenant $tenant)
    {
        $this->tenant = $tenant->load([
            'activeContract.property', 'charges', 'maintenanceRequests', 'documents',
        ]);
    }

    public function render()
    {
        return view('livewire.tenants.show');
    }
}
