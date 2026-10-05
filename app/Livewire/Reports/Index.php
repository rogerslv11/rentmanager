<?php

namespace App\Livewire\Reports;

use App\Enums\ChargeStatus;
use App\Enums\ContractStatus;
use App\Enums\MaintenanceStatus;
use App\Enums\PropertyStatus;
use App\Models\Charge;
use App\Models\Contract;
use App\Models\Expense;
use App\Models\MaintenanceRequest;
use App\Models\Owner;
use App\Models\Property;
use App\Models\Tenant;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Relatórios')]
class Index extends Component
{
    public string $period = '12';

    public function render()
    {
        $orgId = auth()->user()->organization_id;
        $months = (int) $this->period;
        $startDate = now()->subMonths($months);

        // Receita por mês
        $revenueByMonth = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $ref = $month->format('Y-m');
            $revenueByMonth[] = [
                'label' => $month->translatedFormat('M/y'),
                'received' => Charge::when($orgId, fn ($q) => $q->where('organization_id', $orgId))
                    ->where('reference', $ref)
                    ->where('status', ChargeStatus::Paid->value)
                    ->sum('total_amount'),
                'expenses' => Expense::when($orgId, fn ($q) => $q->where('organization_id', $orgId))
                    ->whereMonth('expense_date', $month->month)
                    ->whereYear('expense_date', $month->year)
                    ->sum('amount'),
            ];
        }

        // Stats gerais
        $stats = [
            'total_properties' => Property::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->count(),
            'rented' => Property::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->where('status', PropertyStatus::Rented->value)->count(),
            'available' => Property::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->where('status', PropertyStatus::Available->value)->count(),
            'avg_rent' => Property::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->avg('rent_amount'),
            'occupancy_rate' => 0,
            'total_owners' => Owner::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->count(),
            'total_tenants' => Tenant::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->count(),
            'active_contracts' => Contract::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->where('status', ContractStatus::Active->value)->count(),
            'expiring_contracts' => Contract::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->where('status', ContractStatus::Active->value)->whereBetween('end_date', [now(), now()->addDays(60)])->count(),
            'overdue_amount' => Charge::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->where('status', ChargeStatus::Overdue->value)->sum('total_amount'),
            'total_received' => Charge::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->where('status', ChargeStatus::Paid->value)->sum('total_amount'),
            'total_expenses' => Expense::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->sum('amount'),
            'open_maintenance' => MaintenanceRequest::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->whereNotIn('status', [MaintenanceStatus::Completed->value, MaintenanceStatus::Cancelled->value])->count(),
            'maintenance_cost' => MaintenanceRequest::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->whereNotNull('final_cost')->sum('final_cost'),
            'collection_rate' => 0,
        ];

        if ($stats['total_properties'] > 0) {
            $stats['occupancy_rate'] = round(($stats['rented'] / $stats['total_properties']) * 100, 1);
        }

        // Collection rate (paid / total)
        $totalChargesAmount = (float) Charge::when($orgId, fn ($q) => $q->where('organization_id', $orgId))->sum('total_amount');
        $totalPaid = (float) $stats['total_received'];
        $stats['collection_rate'] = $totalChargesAmount > 0 ? round(($totalPaid / $totalChargesAmount) * 100, 1) : 0;
        $stats['profit'] = $stats['total_received'] - $stats['total_expenses'];

        // Top properties by revenue
        $topProperties = Property::withCount(['charges as paid_count' => fn ($q) => $q->where('status', ChargeStatus::Paid->value)])
            ->when($orgId, fn ($q) => $q->where('organization_id', $orgId))
            ->get()
            ->map(function ($p) {
                $p->revenue = Charge::when(true, fn ($q) => $q->where('property_id', $p->id))->where('status', ChargeStatus::Paid->value)->sum('total_amount');

                return $p;
            })
            ->sortByDesc('revenue')
            ->take(5)
            ->values();

        return view('livewire.reports.index', compact('revenueByMonth', 'stats', 'topProperties'));
    }
}
