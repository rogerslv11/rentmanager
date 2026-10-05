<?php

namespace App\Livewire\Financial;

use App\Enums\ExpenseCategory;
use App\Models\Expense;
use App\Models\Property;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Despesas')]
class Expenses extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'category')]
    public string $categoryFilter = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter()
    {
        $this->resetPage();
    }

    public function delete(int $id)
    {
        Expense::find($id)?->delete();
        $this->dispatch('toast', type: 'success', message: 'Despesa excluída.');
    }

    public function save()
    {
        $this->validate([
            'description' => 'required|string|max:255',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        Expense::create([
            'organization_id' => auth()->user()->organization_id,
            'property_id' => $this->property_id,
            'category' => $this->category,
            'description' => $this->description,
            'amount' => $this->amount,
            'expense_date' => $this->expense_date,
            'vendor_name' => $this->vendor_name,
            'notes' => $this->notes,
            'status' => 'paid',
        ]);

        $this->reset(['description', 'category', 'amount', 'expense_date', 'vendor_name', 'notes', 'property_id', 'showForm']);
        $this->dispatch('toast', type: 'success', message: 'Despesa registrada!');
    }

    public bool $showForm = false;

    public ?int $property_id = null;

    public string $description = '';

    public string $category = 'maintenance';

    public float $amount = 0;

    public string $expense_date = '';

    public string $vendor_name = '';

    public string $notes = '';

    #[Computed]
    public function expenses()
    {
        return Expense::query()
            ->with('property')
            ->when($this->search, fn ($q) => $q->where('description', 'like', '%'.$this->search.'%'))
            ->when($this->categoryFilter, fn ($q) => $q->where('category', $this->categoryFilter))
            ->latest('expense_date')
            ->paginate(20);
    }

    #[Computed]
    public function stats()
    {
        $base = Expense::query();
        $now = now();
        $lastMonth = $now->copy()->subMonth();

        return [
            'total_month' => (clone $base)->whereMonth('expense_date', $now->month)->whereYear('expense_date', $now->year)->sum('amount'),
            'total_last_month' => (clone $base)->whereMonth('expense_date', $lastMonth->month)->whereYear('expense_date', $lastMonth->year)->sum('amount'),
            'total_year' => (clone $base)->whereYear('expense_date', $now->year)->sum('amount'),
            'count' => (clone $base)->count(),
            'count_month' => (clone $base)->whereMonth('expense_date', $now->month)->whereYear('expense_date', $now->year)->count(),
            'avg_month' => (clone $base)->whereMonth('expense_date', $now->month)->whereYear('expense_date', $now->year)->avg('amount') ?? 0,
        ];
    }

    #[Computed]
    public function categoryBreakdown(): array
    {
        $base = Expense::query();
        $now = now();

        $result = (clone $base)
            ->whereMonth('expense_date', $now->month)
            ->whereYear('expense_date', $now->year)
            ->selectRaw('category, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        return $result->map(function ($r) {
            $cat = $r->category instanceof ExpenseCategory ? $r->category : ExpenseCategory::tryFrom($r->category);

            return [
                'category' => $cat?->value ?? (string) $r->category,
                'label' => $cat?->label() ?? (string) $r->category,
                'amount' => (float) $r->total,
                'count' => $r->count,
            ];
        })->all();
    }

    public function render()
    {
        $properties = Property::where('organization_id', auth()->user()->organization_id)->orderBy('name')->get();

        return view('livewire.financial.expenses', compact('properties'));
    }
}
