<?php

namespace App\Livewire\Insurance;

use App\Models\InsurancePolicy;
use App\Models\Property;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Seguros')]
class Index extends Component
{
    public bool $showForm = false;

    public ?int $property_id = null;

    public string $type = 'fire';

    public string $provider = '';

    public string $policy_number = '';

    public float $coverage_amount = 0;

    public float $premium_amount = 0;

    public string $start_date = '';

    public string $end_date = '';

    public function save()
    {
        $this->validate([
            'property_id' => 'required|exists:properties,id',
            'type' => 'required|string',
            'provider' => 'required|string',
            'policy_number' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        InsurancePolicy::create([
            'organization_id' => auth()->user()->organization_id,
            'property_id' => $this->property_id,
            'type' => $this->type,
            'provider' => $this->provider,
            'policy_number' => $this->policy_number,
            'coverage_amount' => $this->coverage_amount,
            'premium_amount' => $this->premium_amount,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
        $this->reset(['property_id', 'type', 'provider', 'policy_number', 'coverage_amount', 'premium_amount', 'start_date', 'end_date', 'showForm']);
        $this->dispatch('toast', type: 'success', message: 'Apólice cadastrada!');
    }

    #[Computed]
    public function policies()
    {
        return InsurancePolicy::with('property')->latest('end_date')->get();
    }

    #[Computed]
    public function stats(): array
    {
        $base = InsurancePolicy::query();
        $now = now();

        return [
            'total' => (clone $base)->count(),
            'active' => (clone $base)->where('start_date', '<=', $now)->where('end_date', '>=', $now)->count(),
            'expiring_30' => (clone $base)->where('end_date', '>=', $now)->where('end_date', '<=', $now->copy()->addDays(30))->count(),
            'expired' => (clone $base)->where('end_date', '<', $now)->count(),
            'total_coverage' => (float) (clone $base)->sum('coverage_amount'),
            'total_premium' => (float) (clone $base)->sum('premium_amount'),
            'avg_premium' => (clone $base)->avg('premium_amount') ?? 0,
        ];
    }

    public function render()
    {
        $properties = Property::where('organization_id', auth()->user()->organization_id)->orderBy('name')->get();

        return view('livewire.insurance.index', compact('properties'));
    }
}
