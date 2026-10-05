<?php

namespace App\Livewire\Properties;

use App\Models\Owner;
use App\Models\Property;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
#[Title('Editar imóvel')]
class Edit extends Component
{
    use WithFileUploads;

    public Property $property;

    public array $data = [];

    public array $photos = [];

    public function mount(Property $property)
    {
        $this->property = $property;
        $this->data = $property->toArray();
        $this->data['features'] = $property->features ?? [];
    }

    public function rules(): array
    {
        return [
            'data.name' => 'required|string|min:2|max:255',
            'data.type' => 'required|string',
            'data.status' => 'required|string',
            'data.address' => 'required|string|max:255',
            'data.neighborhood' => 'required|string|max:128',
            'data.city' => 'required|string|max:128',
            'data.state' => 'required|string|max:64',
            'data.zip_code' => 'required|string|max:16',
            'data.rent_amount' => 'required|numeric|min:0',
            'data.condo_fee' => 'nullable|numeric|min:0',
            'data.property_tax' => 'nullable|numeric|min:0',
            'data.insurance_amount' => 'nullable|numeric|min:0',
            'data.bedrooms' => 'integer|min:0',
            'data.bathrooms' => 'integer|min:0',
            'data.parking_spaces' => 'integer|min:0',
            'data.owner_id' => 'nullable|exists:owners,id',
            'photos.*' => 'nullable|image|max:5120',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->property->update($this->data);

        if ($this->photos) {
            $existingCount = $this->property->photos()->count();
            foreach ($this->photos as $i => $photo) {
                $path = $photo->store('properties/'.$this->property->id, 'public');
                $this->property->photos()->create([
                    'path' => $path,
                    'is_cover' => $existingCount === 0 && $i === 0,
                    'sort_order' => $existingCount + $i,
                ]);
            }
        }

        $this->dispatch('toast', type: 'success', message: 'Imóvel atualizado!');

        return redirect()->route('properties.show', $this->property);
    }

    public function render()
    {
        $owners = Owner::where('organization_id', auth()->user()->organization_id)->orderBy('name')->get();

        return view('livewire.properties.edit', compact('owners'));
    }
}
