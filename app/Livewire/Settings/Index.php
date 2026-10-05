<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Configurações')]
class Index extends Component
{
    public string $name;

    public string $legal_name;

    public string $tax_id;

    public string $email;

    public string $phone;

    public string $address;

    public string $city;

    public string $state;

    public string $zip_code;

    public float $default_admin_fee_percent = 8.0;

    public float $default_admin_fee_fixed = 0;

    public function mount()
    {
        $org = auth()->user()->organization;
        $this->name = $org->name;
        $this->legal_name = $org->legal_name ?? '';
        $this->tax_id = $org->tax_id ?? '';
        $this->email = $org->email ?? '';
        $this->phone = $org->phone ?? '';
        $this->address = $org->address ?? '';
        $this->city = $org->city ?? '';
        $this->state = $org->state ?? '';
        $this->zip_code = $org->zip_code ?? '';
        $this->default_admin_fee_percent = (float) $org->default_admin_fee_percent;
        $this->default_admin_fee_fixed = (float) $org->default_admin_fee_fixed;
    }

    public function save()
    {
        $org = auth()->user()->organization;
        $org->update([
            'name' => $this->name,
            'legal_name' => $this->legal_name,
            'tax_id' => $this->tax_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'default_admin_fee_percent' => $this->default_admin_fee_percent,
            'default_admin_fee_fixed' => $this->default_admin_fee_fixed,
        ]);

        $this->dispatch('toast', type: 'success', message: 'Configurações salvas!');
    }

    public function render()
    {
        return view('livewire.settings.index');
    }
}
