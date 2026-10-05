<?php

namespace App\Livewire\Properties;

use App\Models\Owner;
use App\Models\Property;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
#[Title('Novo imóvel')]
class Create extends Component
{
    use WithFileUploads;

    // Basic
    public string $name = '';

    public string $type = 'apartment';

    public string $code = '';

    public string $status = 'available';

    public ?int $owner_id = null;

    public string $description = '';

    // Features
    public ?float $area_total = null;

    public ?float $area_built = null;

    public int $bedrooms = 0;

    public int $bathrooms = 0;

    public int $parking_spaces = 0;

    public ?int $floor = null;

    public bool $is_furnished = false;

    public bool $pets_allowed = false;

    public bool $is_published = false;

    public array $features = [];

    // Address
    public string $address = '';

    public string $address_number = '';

    public string $address_complement = '';

    public string $neighborhood = '';

    public string $city = '';

    public string $state = '';

    public string $zip_code = '';

    public ?float $latitude = null;

    public ?float $longitude = null;

    // Financial
    public float $rent_amount = 0;

    public float $condo_fee = 0;

    public float $property_tax = 0;

    public float $insurance_amount = 0;

    // Photos
    public array $photos = [];

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'type' => 'required|string',
            'code' => 'nullable|string|max:32',
            'status' => 'required|string',
            'owner_id' => 'nullable|exists:owners,id',
            'description' => 'nullable|string|max:2000',
            'area_total' => 'nullable|numeric|min:0',
            'area_built' => 'nullable|numeric|min:0',
            'bedrooms' => 'integer|min:0',
            'bathrooms' => 'integer|min:0',
            'parking_spaces' => 'integer|min:0',
            'floor' => 'nullable|integer',
            'address' => 'required|string|max:255',
            'address_number' => 'nullable|string|max:32',
            'address_complement' => 'nullable|string|max:128',
            'neighborhood' => 'required|string|max:128',
            'city' => 'required|string|max:128',
            'state' => 'required|string|max:64',
            'zip_code' => 'required|string|max:16',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'rent_amount' => 'required|numeric|min:0',
            'condo_fee' => 'nullable|numeric|min:0',
            'property_tax' => 'nullable|numeric|min:0',
            'insurance_amount' => 'nullable|numeric|min:0',
            'photos.*' => 'nullable|image|max:5120',
        ];
    }

    public function save()
    {
        $data = $this->validate();
        $data['organization_id'] = auth()->user()->organization_id;

        $property = Property::create($data);

        if ($property->owner_id) {
            $property->owners()->attach($property->owner_id, ['ownership_percent' => 100]);
        }

        if ($this->photos) {
            foreach ($this->photos as $i => $photo) {
                $path = $photo->store('properties/'.$property->id, 'public');
                $property->photos()->create([
                    'path' => $path,
                    'is_cover' => $i === 0,
                    'sort_order' => $i,
                ]);
            }
        }

        $this->dispatch('toast', type: 'success', message: 'Imóvel criado com sucesso!');

        return redirect()->route('properties.show', $property);
    }

    public function render()
    {
        $owners = Owner::query()
            ->when(auth()->user()->organization_id, fn ($q) => $q->where('organization_id', auth()->user()->organization_id))
            ->orderBy('name')
            ->get();

        return view('livewire.properties.create', compact('owners'));
    }
}
