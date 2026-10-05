<?php

namespace App\Livewire\Contracts;

use App\Actions\Contract\CreateContractAction;
use App\Models\Property;
use App\Models\Tenant;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Novo contrato')]
class Create extends Component
{
    public ?int $property_id = null;

    public ?int $tenant_id = null;

    public string $number = '';

    public string $start_date = '';

    public string $end_date = '';

    public float $rent_amount = 0;

    public float $condo_fee = 0;

    public float $property_tax = 0;

    public float $insurance_amount = 0;

    public int $due_day = 5;

    public string $adjustment_index = 'IGPM';

    public string $adjustment_periodicity = 'yearly';

    public float $deposit_amount = 0;

    public float $late_fee_percent = 2.00;

    public float $interest_percent = 1.00;

    public float $admin_fee_percent = 8.00;

    public float $admin_fee_fixed = 0;

    public float $discount_amount = 0;

    public bool $auto_renew = false;

    public string $notes = '';

    public function mount()
    {
        if (request()->has('property_id')) {
            $this->property_id = (int) request('property_id');
            $property = Property::find($this->property_id);
            if ($property) {
                $this->rent_amount = (float) $property->rent_amount;
                $this->condo_fee = (float) $property->condo_fee;
                $this->property_tax = (float) $property->property_tax;
                $this->insurance_amount = (float) $property->insurance_amount;
            }
        }
    }

    public function updatedPropertyId()
    {
        $property = Property::find($this->property_id);
        if ($property) {
            $this->rent_amount = (float) $property->rent_amount;
            $this->condo_fee = (float) $property->condo_fee;
            $this->property_tax = (float) $property->property_tax;
            $this->insurance_amount = (float) $property->insurance_amount;
        }
    }

    public function save()
    {
        $this->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'required|exists:tenants,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rent_amount' => 'required|numeric|min:0',
            'due_day' => 'required|integer|min:1|max:31',
        ]);

        $property = Property::find($this->property_id);
        $tenant = Tenant::find($this->tenant_id);

        $contract = app(CreateContractAction::class)->execute([
            'organization_id' => auth()->user()->organization_id,
            'property_id' => $property->id,
            'owner_id' => $property->owner_id,
            'tenant_id' => $tenant->id,
            'number' => $this->number ?: null,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'rent_amount' => $this->rent_amount,
            'condo_fee' => $this->condo_fee,
            'property_tax' => $this->property_tax,
            'insurance_amount' => $this->insurance_amount,
            'due_day' => $this->due_day,
            'adjustment_index' => $this->adjustment_index,
            'adjustment_periodicity' => $this->adjustment_periodicity,
            'deposit_amount' => $this->deposit_amount,
            'late_fee_percent' => $this->late_fee_percent,
            'interest_percent' => $this->interest_percent,
            'admin_fee_percent' => $this->admin_fee_percent,
            'admin_fee_fixed' => $this->admin_fee_fixed,
            'discount_amount' => $this->discount_amount,
            'auto_renew' => $this->auto_renew,
            'status' => 'active',
            'notes' => $this->notes,
        ]);

        $this->dispatch('toast', type: 'success', message: 'Contrato criado!');

        return redirect()->route('contracts.show', $contract);
    }

    public function render()
    {
        $properties = Property::where('organization_id', auth()->user()->organization_id)->orderBy('name')->get();
        $tenants = Tenant::where('organization_id', auth()->user()->organization_id)->orderBy('name')->get();

        return view('livewire.contracts.create', compact('properties', 'tenants'));
    }
}
