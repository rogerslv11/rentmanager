<?php

namespace App\Livewire\Maintenance;

use App\Enums\MaintenanceStatus;
use App\Models\MaintenanceRequest;
use App\Models\Property;
use App\Models\Vendor;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Manutenção')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'status')]
    public string $statusFilter = '';

    #[Url(as: 'view')]
    public string $view = 'list';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function changeStatus(int $id, string $status)
    {
        $r = MaintenanceRequest::find($id);
        if ($r) {
            $data = ['status' => $status];
            if ($status === MaintenanceStatus::Completed->value) {
                $data['completed_at'] = now();
            }
            $r->update($data);
            $this->dispatch('toast', type: 'success', message: 'Status atualizado.');
        }
    }

    public function delete(int $id)
    {
        MaintenanceRequest::find($id)?->delete();
        $this->dispatch('toast', type: 'success', message: 'Solicitação excluída.');
    }

    public bool $showForm = false;

    public ?int $property_id = null;

    public string $title = '';

    public string $description = '';

    public string $category = 'other';

    public string $priority = 'medium';

    public ?int $vendor_id = null;

    public function save()
    {
        $this->validate([
            'property_id' => 'required|exists:properties,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'priority' => 'required|string',
        ]);

        MaintenanceRequest::create([
            'organization_id' => auth()->user()->organization_id,
            'property_id' => $this->property_id,
            'tenant_id' => Property::find($this->property_id)?->activeContract?->tenant_id,
            'user_id' => auth()->id(),
            'vendor_id' => $this->vendor_id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'priority' => $this->priority,
            'status' => MaintenanceStatus::Requested->value,
        ]);

        $this->reset(['property_id', 'title', 'description', 'category', 'priority', 'vendor_id', 'showForm']);
        $this->dispatch('toast', type: 'success', message: 'Solicitação criada!');
    }

    #[Computed]
    public function requests()
    {
        return MaintenanceRequest::query()
            ->with(['property', 'vendor', 'tenant'])
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhereHas('property', fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'));
            }))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(15);
    }

    #[Computed]
    public function kanbanData()
    {
        $requests = MaintenanceRequest::with(['property', 'vendor'])
            ->when($this->search, fn ($q) => $q->where('title', 'like', '%'.$this->search.'%'))
            ->get();

        return collect(MaintenanceStatus::cases())->mapWithKeys(function ($status) use ($requests) {
            return [
                $status->value => [
                    'label' => $status->label(),
                    'color' => $status->color(),
                    'items' => $requests->where('status', $status->value)->values(),
                ],
            ];
        })->toArray();
    }

    #[Computed]
    public function stats(): array
    {
        $base = MaintenanceRequest::query();
        $org = auth()->user()?->organization_id;
        if ($org) {
            $base->where('organization_id', $org);
        }

        return [
            'open' => (clone $base)->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'urgent' => (clone $base)->where('priority', 'urgent')->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'completed_month' => (clone $base)->where('status', 'completed')->whereMonth('completed_at', now()->month)->count(),
            'total_cost' => (float) (clone $base)->whereNotNull('final_cost')->sum('final_cost'),
            'avg_completion_days' => 0,
        ];
    }

    #[Computed]
    public function priorityBreakdown(): array
    {
        $base = MaintenanceRequest::query();
        $org = auth()->user()?->organization_id;
        if ($org) {
            $base->where('organization_id', $org);
        }

        $statuses = [
            'requested' => ['label' => 'Solicitada', 'color' => 'gray', 'icon' => 'inbox'],
            'approved' => ['label' => 'Aprovada', 'color' => 'blue', 'icon' => 'check'],
            'scheduled' => ['label' => 'Agendada', 'color' => 'purple', 'icon' => 'calendar'],
            'in_progress' => ['label' => 'Em andamento', 'color' => 'yellow', 'icon' => 'loader'],
            'completed' => ['label' => 'Concluída', 'color' => 'green', 'icon' => 'check-check'],
            'cancelled' => ['label' => 'Cancelada', 'color' => 'red', 'icon' => 'x-circle'],
        ];

        $result = [];
        foreach ($statuses as $key => $meta) {
            $count = (clone $base)->where('status', $key)->count();
            $result[] = [
                'status' => $key,
                'label' => $meta['label'],
                'color' => $meta['color'],
                'icon' => $meta['icon'],
                'value' => $count,
            ];
        }

        return $result;
    }

    public function render()
    {
        $properties = Property::where('organization_id', auth()->user()->organization_id)->orderBy('name')->get();
        $vendors = Vendor::where('organization_id', auth()->user()->organization_id)->orderBy('name')->get();

        return view('livewire.maintenance.index', compact('properties', 'vendors'));
    }
}
