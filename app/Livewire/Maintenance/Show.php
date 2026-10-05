<?php

namespace App\Livewire\Maintenance;

use App\Models\MaintenanceRequest;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Solicitação')]
class Show extends Component
{
    public MaintenanceRequest $maintenance;

    public function mount(MaintenanceRequest $maintenance)
    {
        $this->maintenance = $maintenance->load(['property', 'tenant', 'vendor', 'quotes.vendor', 'items', 'photos']);
    }

    public function changeStatus(string $status)
    {
        $data = ['status' => $status];
        if ($status === 'completed') {
            $data['completed_at'] = now();
        }
        $this->maintenance->update($data);
        $this->dispatch('toast', type: 'success', message: 'Status atualizado.');
    }

    public function render()
    {
        return view('livewire.maintenance.show');
    }
}
