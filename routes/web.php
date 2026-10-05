<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Calendar\Index as CalendarIndex;
use App\Livewire\Common\GlobalSearch;
use App\Livewire\Contracts\Create as ContractCreate;
use App\Livewire\Contracts\Index as ContractIndex;
use App\Livewire\Contracts\Renew as ContractRenew;
use App\Livewire\Contracts\Show as ContractShow;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Financial\Charges;
use App\Livewire\Financial\Expenses;
use App\Livewire\Financial\Payments;
use App\Livewire\Financial\Payouts;
use App\Livewire\Inspections\Index as InspectionIndex;
use App\Livewire\Insurance\Index as InsuranceIndex;
use App\Livewire\Maintenance\Index as MaintenanceIndex;
use App\Livewire\Maintenance\Show as MaintenanceShow;
use App\Livewire\Notifications\Index as NotificationsIndex;
use App\Livewire\Owners\Create as OwnerCreate;
use App\Livewire\Owners\Index as OwnerIndex;
use App\Livewire\Owners\Show as OwnerShow;
use App\Livewire\Portals\OwnerDashboard;
use App\Livewire\Portals\TenantDashboard;
use App\Livewire\Properties\Create as PropertyCreate;
use App\Livewire\Properties\Edit as PropertyEdit;
use App\Livewire\Properties\Index as PropertyIndex;
use App\Livewire\Properties\Show as PropertyShow;
use App\Livewire\Public\PropertyPage;
use App\Livewire\Reports\Index as ReportIndex;
use App\Livewire\Settings\Index as SettingsIndex;
use App\Livewire\Settings\Profile;
use App\Livewire\Tenants\Create as TenantCreate;
use App\Livewire\Tenants\Index as TenantIndex;
use App\Livewire\Tenants\Show as TenantShow;
use App\Livewire\Vendors\Index as VendorIndex;
use Illuminate\Support\Facades\Route;

// Public welcome
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->hasRole('tenant')) {
            return redirect()->route('tenant-portal.dashboard');
        }
        if (auth()->user()->hasRole('owner')) {
            return redirect()->route('owner-portal.dashboard');
        }

        return redirect()->route('dashboard');
    }

    return view('pages.welcome');
});

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    })->name('logout');

    // Global search
    Route::get('/global-search', GlobalSearch::class)->name('global-search');
});

// Main app
Route::middleware(['auth', 'org.context'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Properties
    Route::prefix('properties')->name('properties.')->group(function () {
        Route::get('/', PropertyIndex::class)->name('index');
        Route::get('/create', PropertyCreate::class)->name('create');
        Route::get('/{property}', PropertyShow::class)->name('show');
        Route::get('/{property}/edit', PropertyEdit::class)->name('edit');
    });

    // Owners
    Route::prefix('owners')->name('owners.')->group(function () {
        Route::get('/', OwnerIndex::class)->name('index');
        Route::get('/create', OwnerCreate::class)->name('create');
        Route::get('/{owner}', OwnerShow::class)->name('show');
    });

    // Tenants
    Route::prefix('tenants')->name('tenants.')->group(function () {
        Route::get('/', TenantIndex::class)->name('index');
        Route::get('/create', TenantCreate::class)->name('create');
        Route::get('/{tenant}', TenantShow::class)->name('show');
    });

    // Contracts
    Route::prefix('contracts')->name('contracts.')->group(function () {
        Route::get('/', ContractIndex::class)->name('index');
        Route::get('/create', ContractCreate::class)->name('create');
        Route::get('/{contract}', ContractShow::class)->name('show');
        Route::get('/{contract}/renew', ContractRenew::class)->name('renew');
    });

    // Financial
    Route::prefix('charges')->name('charges.')->group(function () {
        Route::get('/', Charges::class)->name('index');
    });
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', Payments::class)->name('index');
    });
    Route::prefix('payouts')->name('payouts.')->group(function () {
        Route::get('/', Payouts::class)->name('index');
    });
    Route::prefix('expenses')->name('expenses.')->group(function () {
        Route::get('/', Expenses::class)->name('index');
    });

    // Maintenance
    Route::prefix('maintenance')->name('maintenance.')->group(function () {
        Route::get('/', MaintenanceIndex::class)->name('index');
        Route::get('/{maintenance}', MaintenanceShow::class)->name('show');
    });

    // Vendors
    Route::prefix('vendors')->name('vendors.')->group(function () {
        Route::get('/', VendorIndex::class)->name('index');
    });

    // Inspections
    Route::prefix('inspections')->name('inspections.')->group(function () {
        Route::get('/', InspectionIndex::class)->name('index');
    });

    // Insurance
    Route::prefix('insurance')->name('insurance.')->group(function () {
        Route::get('/', InsuranceIndex::class)->name('index');
    });

    // Documents (stub)
    Route::get('/documents', function () {
        return view('pages.placeholder', ['title' => 'Documentos', 'icon' => 'folder-open']);
    })->name('documents.index');

    // Calendar
    Route::get('/calendar', CalendarIndex::class)->name('calendar.index');

    // Reports
    Route::get('/reports', ReportIndex::class)->name('reports.index');

    // Settings & Profile
    Route::get('/settings', SettingsIndex::class)->name('settings.index');
    Route::get('/profile', Profile::class)->name('profile.edit');

    // Notifications
    Route::get('/notifications', NotificationsIndex::class)->name('notifications.index');
});

// Portals
Route::middleware(['auth', 'portal:tenant'])->prefix('tenant-portal')->name('tenant-portal.')->group(function () {
    Route::get('/dashboard', TenantDashboard::class)->name('dashboard');
});

Route::middleware(['auth', 'portal:owner'])->prefix('owner-portal')->name('owner-portal.')->group(function () {
    Route::get('/dashboard', OwnerDashboard::class)->name('dashboard');
});

// Public property page
Route::get('/imovel/{property:slug}', PropertyPage::class)->name('public.property');
