<?php

namespace App\Livewire\Tenants;

use App\Enums\UserRole;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Novo inquilino')]
class Create extends Component
{
    public string $name = '';

    public string $tax_id = '';

    public string $email = '';

    public string $phone = '';

    public string $mobile = '';

    public ?string $birth_date = null;

    public string $nationality = 'Brasileira';

    public string $marital_status = '';

    public string $profession = '';

    public float $monthly_income = 0;

    public string $address = '';

    public string $city = '';

    public string $state = '';

    public string $zip_code = '';

    public string $emergency_contact_name = '';

    public string $emergency_contact_phone = '';

    public string $notes = '';

    public bool $create_portal_access = true;

    public string $password = '';

    public function save()
    {
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'tax_id' => 'nullable|string|max:32',
            'email' => 'nullable|email|max:255',
            'monthly_income' => 'nullable|numeric|min:0',
        ];
        if ($this->create_portal_access && $this->email) {
            $rules['password'] = 'required|string|min:8';
        }
        $this->validate($rules);

        $user = null;
        if ($this->create_portal_access && $this->email) {
            $user = User::firstOrCreate(
                ['email' => $this->email],
                [
                    'organization_id' => auth()->user()->organization_id,
                    'name' => $this->name,
                    'password' => Hash::make($this->password),
                ],
            );
            if (! $user->hasRole(UserRole::Tenant->value)) {
                $user->assignRole(UserRole::Tenant->value);
            }
        }

        Tenant::create([
            'organization_id' => auth()->user()->organization_id,
            'user_id' => $user?->id,
            'name' => $this->name,
            'tax_id' => $this->tax_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'birth_date' => $this->birth_date,
            'nationality' => $this->nationality,
            'marital_status' => $this->marital_status,
            'profession' => $this->profession,
            'monthly_income' => $this->monthly_income,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'emergency_contact_name' => $this->emergency_contact_name,
            'emergency_contact_phone' => $this->emergency_contact_phone,
            'notes' => $this->notes,
        ]);

        $this->dispatch('toast', type: 'success', message: 'Inquilino criado!');

        return redirect()->route('tenants.index');
    }

    public function render()
    {
        return view('livewire.tenants.create');
    }
}
