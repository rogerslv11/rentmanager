<?php

namespace App\Livewire\Financial;

use App\Enums\PayoutStatus;
use App\Models\OwnerPayout;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Repasses')]
class Payouts extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'status')]
    public string $statusFilter = '';

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
        $p = OwnerPayout::find($id);
        if ($p) {
            $p->update(['status' => PayoutStatus::Paid->value, 'paid_at' => now()]);
            $this->dispatch('toast', type: 'success', message: 'Repasse marcado como pago.');
        }
    }

    #[Computed]
    public function payouts()
    {
        return OwnerPayout::query()
            ->with(['owner', 'contract.property'])
            ->when($this->search, fn ($q) => $q->whereHas('owner', fn ($q) => $q->where('name', 'like', '%'.$this->search.'%')))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(20);
    }

    #[Computed]
    public function stats()
    {
        $base = OwnerPayout::query();

        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();

        return [
            'pending' => (clone $base)->whereIn('status', ['pending', 'scheduled'])->sum('net_amount'),
            'paid' => (clone $base)->where('status', 'paid')->sum('net_amount'),
            'paid_month' => (clone $base)->where('status', 'paid')->where('paid_at', '>=', $startOfMonth)->sum('net_amount'),
            'count_pending' => (clone $base)->whereIn('status', ['pending', 'scheduled'])->count(),
            'count_paid' => (clone $base)->where('status', 'paid')->count(),
            'count_total' => (clone $base)->count(),
            'total_fees' => (clone $base)->sum('admin_fee'),
            'total_gross' => (clone $base)->sum('gross_amount'),
        ];
    }

    #[Computed]
    public function statusBreakdown(): array
    {
        return collect(PayoutStatus::cases())->map(function ($s) {
            $base = OwnerPayout::query();

            return [
                'label' => $s->label(),
                'value' => (clone $base)->where('status', $s->value)->count(),
                'status' => $s->value,
            ];
        })->all();
    }

    public function render()
    {
        return view('livewire.financial.payouts');
    }
}
