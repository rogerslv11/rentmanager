<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Meu perfil')]
class Profile extends Component
{
    public string $name;

    public string $email;

    public string $phone;

    public string $current_password = '';

    public string $new_password = '';

    public string $new_password_confirmation = '';

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
    }

    public function updateProfile()
    {
        $user = auth()->user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
        $this->dispatch('toast', type: 'success', message: 'Perfil atualizado!');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        auth()->user()->update(['password' => Hash::make($this->new_password)]);
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->dispatch('toast', type: 'success', message: 'Senha alterada!');
    }

    public function render()
    {
        $user = auth()->user();
        $stats = [
            'role' => $user->roles->first()?->name ?? 'Usuário',
            'created_at' => $user->created_at,
            'last_login' => $user->last_login_at ?? $user->updated_at,
            'organization' => $user->organization?->name ?? '—',
        ];

        return view('livewire.settings.profile', compact('stats'));
    }
}
