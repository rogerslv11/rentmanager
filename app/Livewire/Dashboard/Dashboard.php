<?php

namespace App\Livewire\Dashboard;

use App\Enums\ChargeStatus;
use App\Enums\ContractStatus;
use App\Enums\MaintenanceStatus;
use App\Enums\PropertyStatus;
use App\Models\ActivityLog;
use App\Models\Charge;
use App\Models\Contract;
use App\Models\MaintenanceRequest;
use App\Models\Property;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $organizationId = $user->organization_id;

        $properties = Property::query();
        $contracts = Contract::query();
        $charges = Charge::query();
        $maintenance = MaintenanceRequest::query();

        if ($organizationId) {
            $properties->where('organization_id', $organizationId);
            $contracts->where('organization_id', $organizationId);
            $charges->where('organization_id', $organizationId);
            $maintenance->where('organization_id', $organizationId);
        }

        // Properties stats
        $totalProperties = (clone $properties)->count();
        $availableProperties = (clone $properties)->where('status', PropertyStatus::Available->value)->count();
        $rentedProperties = (clone $properties)->where('status', PropertyStatus::Rented->value)->count();
        $occupancyRate = $totalProperties > 0 ? round(($rentedProperties / $totalProperties) * 100, 1) : 0;

        // Contracts
        $activeContracts = (clone $contracts)->where('status', ContractStatus::Active->value)->count();
        $expiringContracts = (clone $contracts)->expiring(60)->count();

        // Financial
        $currentMonth = now()->format('Y-m');
        $lastMonth = now()->subMonth()->format('Y-m');

        $revenueThisMonth = (clone $charges)
            ->where('reference', $currentMonth)
            ->where('status', ChargeStatus::Paid->value)
            ->sum('total_amount');

        $revenueLastMonth = (clone $charges)
            ->where('reference', $lastMonth)
            ->where('status', ChargeStatus::Paid->value)
            ->sum('total_amount');

        $pendingAmount = (clone $charges)
            ->whereIn('status', [ChargeStatus::Pending->value, ChargeStatus::PartiallyPaid->value])
            ->sum('total_amount');

        $overdueAmount = (clone $charges)
            ->where('status', ChargeStatus::Overdue->value)
            ->sum('total_amount');

        // Maintenance
        $openMaintenance = (clone $maintenance)
            ->whereNotIn('status', [MaintenanceStatus::Completed->value, MaintenanceStatus::Cancelled->value])
            ->count();

        // Chart data: revenue last 12 months
        $revenueChart = $this->getRevenueChart($charges);

        // Occupancy chart
        $propertyStatusChart = [
            'available' => $availableProperties,
            'rented' => $rentedProperties,
            'maintenance' => (clone $properties)->where('status', PropertyStatus::Maintenance->value)->count(),
            'reserved' => (clone $properties)->where('status', PropertyStatus::Reserved->value)->count(),
            'inactive' => (clone $properties)->where('status', PropertyStatus::Inactive->value)->count(),
        ];

        // Recent activity
        $activities = ActivityLog::with('user')
            ->when($organizationId, fn ($q) => $q->where('organization_id', $organizationId))
            ->latest()
            ->limit(10)
            ->get();

        // Upcoming events
        $upcomingContracts = (clone $contracts)
            ->with(['property', 'tenant'])
            ->where('status', ContractStatus::Active->value)
            ->whereBetween('end_date', [now(), now()->addDays(90)])
            ->orderBy('end_date')
            ->limit(5)
            ->get();

        // Recent payments
        $recentPayments = (clone $charges)
            ->with(['tenant', 'property', 'payments'])
            ->where('status', ChargeStatus::Paid->value)
            ->latest('paid_at')
            ->limit(5)
            ->get();

        $stats = [
            'total_properties' => $totalProperties,
            'available_properties' => $availableProperties,
            'rented_properties' => $rentedProperties,
            'occupancy_rate' => $occupancyRate,
            'active_contracts' => $activeContracts,
            'expiring_contracts' => $expiringContracts,
            'revenue_this_month' => (float) $revenueThisMonth,
            'revenue_last_month' => (float) $revenueLastMonth,
            'pending_amount' => (float) $pendingAmount,
            'overdue_amount' => (float) $overdueAmount,
            'open_maintenance' => $openMaintenance,
        ];

        return view('livewire.dashboard.dashboard', compact(
            'stats',
            'revenueChart',
            'propertyStatusChart',
            'activities',
            'upcomingContracts',
            'recentPayments',
        ));
    }

    protected function getRevenueChart($charges): array
    {
        $data = [];
        $paid = [];
        $overdue = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $ref = $month->format('Y-m');
            $data[] = $month->translatedFormat('M/y');

            $paid[] = (float) (clone $charges)
                ->where('reference', $ref)
                ->where('status', ChargeStatus::Paid->value)
                ->sum('total_amount');

            $overdue[] = (float) (clone $charges)
                ->where('reference', $ref)
                ->where('status', ChargeStatus::Overdue->value)
                ->sum('total_amount');
        }

        return [
            'labels' => $data,
            'paid' => $paid,
            'overdue' => $overdue,
        ];
    }
}
