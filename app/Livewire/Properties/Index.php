<?php

namespace App\Livewire\Properties;

use App\Enums\PropertyStatus;
use App\Models\Property;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Imóveis')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'type')]
    public string $typeFilter = '';

    #[Url(as: 'status')]
    public string $statusFilter = '';

    public int $perPage = 12;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedTypeFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    #[Computed]
    public function properties()
    {
        return Property::query()
            ->with(['owner', 'photos', 'activeContract.tenant'])
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('code', 'like', '%'.$this->search.'%')
                    ->orWhere('address', 'like', '%'.$this->search.'%')
                    ->orWhere('city', 'like', '%'.$this->search.'%');
            }))
            ->when($this->typeFilter, fn ($q) => $q->where('type', $this->typeFilter))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate($this->perPage);
    }

    #[Computed]
    public function stats(): array
    {
        $org = auth()->user()?->organization_id;
        $base = Property::query()->when($org, fn ($q) => $q->where('organization_id', $org));

        $total = (clone $base)->count();
        $available = (clone $base)->where('status', PropertyStatus::Available->value)->count();
        $rented = (clone $base)->where('status', PropertyStatus::Rented->value)->count();
        $maintenance = (clone $base)->where('status', PropertyStatus::Maintenance->value)->count();
        $reserved = (clone $base)->where('status', PropertyStatus::Reserved->value)->count();
        $inactive = (clone $base)->where('status', PropertyStatus::Inactive->value)->count();
        $monthlyRevenue = (clone $base)->where('status', PropertyStatus::Rented->value)->sum('rent_amount');
        $avgRent = $total > 0 ? (clone $base)->avg('rent_amount') : 0;
        $occupancy = $total > 0 ? round(($rented / $total) * 100, 1) : 0;

        return compact('total', 'available', 'rented', 'maintenance', 'reserved', 'inactive', 'monthlyRevenue', 'avgRent', 'occupancy');
    }

    #[Computed]
    public function statusBreakdown(): array
    {
        return [
            ['label' => 'Disponíveis', 'value' => $this->stats['available'], 'color' => 'green', 'icon' => 'home', 'status' => 'available'],
            ['label' => 'Alugados', 'value' => $this->stats['rented'], 'color' => 'blue', 'icon' => 'key', 'status' => 'rented'],
            ['label' => 'Manutenção', 'value' => $this->stats['maintenance'], 'color' => 'yellow', 'icon' => 'wrench', 'status' => 'maintenance'],
            ['label' => 'Reservados', 'value' => $this->stats['reserved'], 'color' => 'purple', 'icon' => 'bookmark', 'status' => 'reserved'],
            ['label' => 'Inativos', 'value' => $this->stats['inactive'], 'color' => 'gray', 'icon' => 'archive', 'status' => 'inactive'],
        ];
    }

    public function delete(int $id)
    {
        $property = Property::find($id);
        if ($property) {
            $property->delete();
            $this->dispatch('toast', type: 'success', message: 'Imóvel excluído com sucesso.');
        }
    }

    public function render()
    {
        return view('livewire.properties.index');
    }
}
