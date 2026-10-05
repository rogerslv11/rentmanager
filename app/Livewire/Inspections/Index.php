<?php

namespace App\Livewire\Inspections;

use App\Enums\InspectionType;
use App\Models\Inspection;
use App\Models\Property;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Vistorias')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public string $typeFilter = '';

    public bool $showForm = false;

    public ?int $property_id = null;

    public string $type = 'periodic';

    public string $title = '';

    public string $scheduled_for = '';

    public string $notes = '';

    public function save()
    {
        $this->validate([
            'property_id' => 'required|exists:properties,id',
            'type' => 'required|string',
            'scheduled_for' => 'required|date',
            'title' => 'required|string',
        ]);
        Inspection::create([
            'organization_id' => auth()->user()->organization_id,
            'property_id' => $this->property_id,
            'type' => $this->type,
            'title' => $this->title,
            'scheduled_for' => $this->scheduled_for,
            'notes' => $this->notes,
            'inspector_id' => auth()->id(),
            'status' => 'scheduled',
        ]);
        $this->reset(['property_id', 'type', 'title', 'scheduled_for', 'notes', 'showForm']);
        $this->dispatch('toast', type: 'success', message: 'Vistoria agendada!');
    }

    #[Computed]
    public function inspections()
    {
        return Inspection::query()
            ->with('property')
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhereHas('property', fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'));
            }))
            ->when($this->typeFilter, fn ($q) => $q->where('type', $this->typeFilter))
            ->latest('scheduled_for')
            ->paginate(15);
    }

    #[Computed]
    public function stats(): array
    {
        $base = Inspection::query();
        $org = auth()->user()?->organization_id;
        if ($org) {
            $base->where('organization_id', $org);
        }

        $now = now();

        return [
            'total' => (clone $base)->count(),
            'scheduled' => (clone $base)->where('status', 'scheduled')->count(),
            'completed' => (clone $base)->where('status', 'completed')->count(),
            'upcoming' => (clone $base)->where('status', 'scheduled')->where('scheduled_for', '>=', $now)->where('scheduled_for', '<=', $now->copy()->addDays(30))->count(),
        ];
    }

    #[Computed]
    public function typeBreakdown(): array
    {
        $base = Inspection::query();
        $org = auth()->user()?->organization_id;
        if ($org) {
            $base->where('organization_id', $org);
        }

        $types = InspectionType::cases();
        $result = [];
        foreach ($types as $t) {
            $count = (clone $base)->where('type', $t->value)->count();
            if ($count > 0) {
                $result[] = [
                    'type' => $t->value,
                    'label' => $t->label(),
                    'value' => $count,
                ];
            }
        }

        return $result;
    }

    public function render()
    {
        $properties = Property::where('organization_id', auth()->user()->organization_id)->orderBy('name')->get();

        return view('livewire.inspections.index', compact('properties'));
    }
}
