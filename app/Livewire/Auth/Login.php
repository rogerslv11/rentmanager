<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Login · RentManager')]
class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public function mount()
    {
        // No auto-redirect here, middleware handles it
    }

    public function loginAsDemo()
    {
        $demoEmail = config('app.demo_email', env('RENTMANAGER_DEMO_EMAIL', 'demo@rentmanager.test'));
        $demoPassword = config('app.demo_password', env('RENTMANAGER_DEMO_PASSWORD', 'password'));

        $this->email = $demoEmail;
        $this->password = $demoPassword;

        return $this->authenticate();
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        return $this->authenticate();
    }

    protected function authenticate()
    {
        $throttleKey = 'login:'.strtolower($this->email).'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Muitas tentativas. Tente novamente em '.RateLimiter::availableIn($throttleKey).' segundos.',
            ]);
        }

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($throttleKey);
            throw ValidationException::withMessages([
                'email' => 'Credenciais inválidas.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        $user = Auth::user();
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);

        request()->session()->regenerate();

        if ($user->hasRole('tenant')) {
            return redirect()->route('tenant-portal.dashboard');
        }

        if ($user->hasRole('owner')) {
            return redirect()->route('owner-portal.dashboard');
        }

        return redirect()->intended(route('dashboard'));
    }

    public function render()
    {
        return view('pages.auth.login');
    }
}
