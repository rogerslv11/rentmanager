<?php

namespace App\Livewire\Contracts;

use App\Actions\Contract\TerminateContractAction;
use App\Enums\ContractStatus;
use App\Models\Contract;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Contratos')]
class Index extends Component
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

    public function terminate(int $id)
    {
        $contract = Contract::find($id);
        if ($contract) {
            app(TerminateContractAction::class)->execute($contract, 'Encerrado manualmente');
            $this->dispatch('toast', type: 'success', message: 'Contrato encerrado.');
        }
    }

    #[Computed]
    public function contracts()
    {
        return Contract::query()
            ->with(['property', 'tenant', 'owner'])
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('number', 'like', '%'.$this->search.'%')
                    ->orWhereHas('property', fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
                    ->orWhereHas('tenant', fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'));
            }))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest('start_date')
            ->paginate(15);
    }

    #[Computed]
    public function stats(): array
    {
        $org = auth()->user()?->organization_id;
        $base = Contract::query()->when($org, fn ($q) => $q->where('organization_id', $org));

        $total = (clone $base)->count();
        $active = (clone $base)->where('status', ContractStatus::Active->value)->count();
        $expiring = (clone $base)->where('status', ContractStatus::Active->value)
            ->whereBetween('end_date', [now(), now()->addDays(60)])->count();
        $totalRent = (clone $base)->where('status', ContractStatus::Active->value)->sum('rent_amount');

        return compact('total', 'active', 'expiring', 'totalRent');
    }

    #[Computed]
    public function statusBreakdown(): array
    {
        $org = auth()->user()?->organization_id;
        $base = Contract::query()->when($org, fn ($q) => $q->where('organization_id', $org));

        return collect(ContractStatus::cases())->map(function ($s) use ($base) {
            $count = (clone $base)->where('status', $s->value)->count();
            $color = match ($s->value) {
                'active' => 'green',
                'expired' => 'yellow',
                'terminated' => 'red',
                'pending' => 'gray',
                'draft' => 'gray',
                default => 'blue',
            };

            return ['label' => $s->label(), 'value' => $count, 'status' => $s->value, 'color' => $color];
        })->all();
    }

    public function render()
    {
        return view('livewire.contracts.index');
    }
}
