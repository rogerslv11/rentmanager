<?php

namespace App\Livewire\Auth;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Cadastro · RentManager')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $organization_name = '';

    public function register()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'organization_name' => 'required|string|min:2|max:255',
        ]);

        $org = Organization::create([
            'name' => $this->organization_name,
        ]);

        $user = User::create([
            'organization_id' => $org->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->assignRole('organization_owner');

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('pages.auth.register');
    }
}
