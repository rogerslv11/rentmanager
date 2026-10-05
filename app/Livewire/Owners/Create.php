<?php

namespace App\Livewire\Owners;

use App\Models\Owner;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Novo proprietário')]
class Create extends Component
{
    public string $name = '';

    public string $tax_id = '';

    public string $email = '';

    public string $phone = '';

    public string $mobile = '';

    public string $address = '';

    public string $city = '';

    public string $state = '';

    public string $zip_code = '';

    public string $bank_name = '';

    public string $bank_agency = '';

    public string $bank_account = '';

    public string $bank_account_type = '';

    public string $pix_key = '';

    public string $notes = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:255',
            'tax_id' => 'nullable|string|max:32',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:32',
            'mobile' => 'nullable|string|max:32',
        ]);

        Owner::create([
            'organization_id' => auth()->user()->organization_id,
            'name' => $this->name,
            'tax_id' => $this->tax_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'bank_name' => $this->bank_name,
            'bank_agency' => $this->bank_agency,
            'bank_account' => $this->bank_account,
            'bank_account_type' => $this->bank_account_type,
            'pix_key' => $this->pix_key,
            'notes' => $this->notes,
        ]);

        $this->dispatch('toast', type: 'success', message: 'Proprietário criado!');

        return redirect()->route('owners.index');
    }

    public function render()
    {
        return view('livewire.owners.create');
    }
}
