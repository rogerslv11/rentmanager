<?php

namespace App\Providers;

use App\Models\Tenant;
use App\Services\ActivityLogger;
use App\Services\ChargeGenerationService;
use App\Services\PaymentService;
use App\Services\PayoutCalculationService;
use App\Support\TenantContext;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ActivityLogger::class);
        $this->app->singleton(ChargeGenerationService::class);
        $this->app->singleton(PaymentService::class);
        $this->app->singleton(PayoutCalculationService::class);
    }

    public function boot(): void
    {
        Paginator::useTailwind();
        Vite::prefetch(concurrency: 3);

        Schema::defaultStringLength(191);

        // Default gates
        Gate::before(function ($user, $ability) {
            return $user->is_super_admin ?? false;
        });

        // Auto-detect organization for tenant context on first auth
        $this->app->booted(function () {
            if (auth()->check() && ! app()->has('organization')) {
                TenantContext::get();
            }
        });

        $this->registerLivewireComponents();
    }

    protected function registerLivewireComponents(): void
    {
        // Components are auto-discovered by Livewire in app/Livewire
    }
}
