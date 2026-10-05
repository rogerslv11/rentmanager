<?php

namespace App\Livewire\Owners;

use App\Models\Owner;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Proprietários')]
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
        Owner::find($id)?->delete();
        $this->dispatch('toast', type: 'success', message: 'Proprietário excluído.');
    }

    #[Computed]
    public function owners()
    {
        return Owner::query()
            ->withCount(['properties', 'payouts'])
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
        $base = Owner::query()->when($org, fn ($q) => $q->where('organization_id', $org));

        $total = (clone $base)->count();
        $withPix = (clone $base)->whereNotNull('pix_key')->count();
        $withBank = (clone $base)->whereNotNull('bank_name')->count();
        $totalRevenue = (clone $base)->get()->sum(fn ($o) => $o->monthlyRevenue());

        return compact('total', 'withPix', 'withBank', 'totalRevenue');
    }

    public function render()
    {
        return view('livewire.owners.index');
    }
}
