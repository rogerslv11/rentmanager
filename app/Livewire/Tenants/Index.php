<?php

namespace App\Livewire\Tenants;

use App\Models\Tenant;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Inquilinos')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete(int $id)
    {
        Tenant::find($id)?->delete();
        $this->dispatch('toast', type: 'success', message: 'Inquilino excluído.');
    }

    #[Computed]
    public function tenants()
    {
        return Tenant::query()
            ->with(['activeContract.property', 'user'])
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('tax_id', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%');
            }))
            ->latest()
            ->paginate(15);
    }

    #[Computed]
    public function stats(): array
    {
        $org = auth()->user()?->organization_id;
        $base = Tenant::query()->when($org, fn ($q) => $q->where('organization_id', $org));

        $total = (clone $base)->count();
        $active = (clone $base)->whereHas('activeContract')->count();
        $withPortal = (clone $base)->whereNotNull('user_id')->count();
        $withDebt = $base->get()->filter(fn ($t) => $t->totalPending() > 0)->count();
        $totalDebt = $base->get()->sum(fn ($t) => $t->totalPending());

        return compact('total', 'active', 'withPortal', 'withDebt', 'totalDebt');
    }

    public function render()
    {
        return view('livewire.tenants.index');
    }
}
