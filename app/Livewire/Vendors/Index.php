<?php

namespace App\Livewire\Vendors;

use App\Models\Vendor;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Fornecedores')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public string $categoryFilter = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter()
    {
        $this->resetPage();
    }

    public bool $showForm = false;

    public string $name = '';

    public string $company_name = '';

    public string $tax_id = '';

    public string $email = '';

    public string $phone = '';

    public string $category = '';

    public string $specialty = '';

    public float $hourly_rate = 0;

    public string $notes = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|min:3',
            'category' => 'required|string',
        ]);
        Vendor::create([
            'organization_id' => auth()->user()->organization_id,
            'name' => $this->name,
            'company_name' => $this->company_name,
            'tax_id' => $this->tax_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'category' => $this->category,
            'specialty' => $this->specialty,
            'hourly_rate' => $this->hourly_rate,
            'notes' => $this->notes,
        ]);
        $this->reset(['name', 'company_name', 'tax_id', 'email', 'phone', 'category', 'specialty', 'hourly_rate', 'notes', 'showForm']);
        $this->dispatch('toast', type: 'success', message: 'Fornecedor criado!');
    }

    public function delete(int $id)
    {
        Vendor::find($id)?->delete();
        $this->dispatch('toast', type: 'success', message: 'Fornecedor excluído.');
    }

    #[Computed]
    public function vendors()
    {
        return Vendor::query()
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('company_name', 'like', '%'.$this->search.'%');
            }))
            ->when($this->categoryFilter, fn ($q) => $q->where('category', $this->categoryFilter))
            ->withCount('maintenanceRequests')
            ->latest()
            ->paginate(15);
    }

    #[Computed]
    public function stats(): array
    {
        $base = Vendor::query();
        $org = auth()->user()?->organization_id;
        if ($org) {
            $base->where('organization_id', $org);
        }

        return [
            'total' => (clone $base)->count(),
            'categories' => (clone $base)->whereNotNull('category')->distinct()->count('category'),
            'total_jobs' => (clone $base)->withCount('maintenanceRequests')->get()->sum('maintenance_requests_count'),
            'avg_rate' => (clone $base)->avg('hourly_rate') ?? 0,
        ];
    }

    public function render()
    {
        $categories = Vendor::where('organization_id', auth()->user()->organization_id)
            ->whereNotNull('category')->distinct()->pluck('category')->filter()->values();

        return view('livewire.vendors.index', compact('categories'));
    }
}
