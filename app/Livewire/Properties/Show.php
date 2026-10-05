<?php

namespace App\Livewire\Properties;

use App\Models\Charge;
use App\Models\Property;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Imóvel')]
class Show extends Component
{
    public Property $property;

    public function mount(Property $property)
    {
        $this->property = $property->load([
            'owner', 'owners', 'photos', 'activeContract.tenant',
            'contracts.tenant', 'maintenanceRequests', 'inspections',
            'insurancePolicies', 'expenses', 'files',
        ]);
    }

    public function render()
    {
        $stats = [
            'total_contracts' => $this->property->contracts->count(),
            'active_contracts' => $this->property->contracts->where('status', 'active')->count(),
            'total_charges' => Charge::where('property_id', $this->property->id)->sum('total_amount'),
            'total_paid' => Charge::where('property_id', $this->property->id)->where('status', 'paid')->sum('total_amount'),
            'open_maintenance' => $this->property->maintenanceRequests->whereNotIn('status', ['completed', 'cancelled'])->count(),
        ];

        return view('livewire.properties.show', compact('stats'));
    }
}
