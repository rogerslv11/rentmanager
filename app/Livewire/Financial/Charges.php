<?php

namespace App\Livewire\Financial;

use App\Enums\ChargeStatus;
use App\Models\Charge;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Cobranças')]
class Charges extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'status')]
    public string $statusFilter = '';

    #[Url(as: 'property_id')]
    public string $propertyId = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function markPaid(int $id)
    {
        $charge = Charge::find($id);
        if ($charge) {
            $charge->update(['status' => ChargeStatus::Paid->value, 'paid_at' => now(), 'paid_amount' => $charge->total_amount]);
            $this->dispatch('toast', type: 'success', message: 'Cobrança marcada como paga.');
        }
    }

    #[Computed]
    public function charges()
    {
        return Charge::query()
            ->with(['tenant', 'property', 'contract'])
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('reference', 'like', '%'.$this->search.'%')
                    ->orWhereHas('tenant', fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
                    ->orWhereHas('property', fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'));
            }))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->propertyId, fn ($q) => $q->where('property_id', $this->propertyId))
            ->latest('due_date')
            ->paginate(20);
    }

    #[Computed]
    public function stats()
    {
        $base = Charge::query();
        $org = auth()->user()?->organization_id;
        if ($org) {
            $base->where('organization_id', $org);
        }

        return [
            'pending' => (clone $base)->whereIn('status', ['pending', 'partially_paid'])->sum('total_amount'),
            'paid' => (clone $base)->where('status', 'paid')->sum('paid_amount'),
            'overdue' => (clone $base)->where('status', 'overdue')->sum('total_amount'),
            'count_overdue' => (clone $base)->where('status', 'overdue')->count(),
            'count_pending' => (clone $base)->whereIn('status', ['pending', 'partially_paid'])->count(),
            'count_paid' => (clone $base)->where('status', 'paid')->count(),
            'total' => (clone $base)->count(),
        ];
    }

    #[Computed]
    public function statusBreakdown(): array
    {
        $base = Charge::query();
        $org = auth()->user()?->organization_id;
        if ($org) {
            $base->where('organization_id', $org);
        }

        return [
            ['label' => 'Pendentes', 'value' => $this->stats['count_pending'], 'amount' => $this->stats['pending'], 'status' => 'pending,partially_paid', 'color' => 'yellow', 'icon' => 'clock'],
            ['label' => 'Pagas', 'value' => $this->stats['count_paid'], 'amount' => $this->stats['paid'], 'status' => 'paid', 'color' => 'green', 'icon' => 'check-circle-2'],
            ['label' => 'Em atraso', 'value' => $this->stats['count_overdue'], 'amount' => $this->stats['overdue'], 'status' => 'overdue', 'color' => 'red', 'icon' => 'alert-circle'],
        ];
    }

    #[Computed]
    public function collectionRate(): float
    {
        $stats = $this->stats;
        $total = (float) $stats['paid'] + (float) $stats['pending'] + (float) $stats['overdue'];

        return $total > 0 ? round(((float) $stats['paid'] / $total) * 100, 1) : 0;
    }

    public function render()
    {
        return view('livewire.financial.charges');
    }
}
