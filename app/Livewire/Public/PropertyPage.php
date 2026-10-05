<?php

namespace App\Livewire\Public;

use App\Models\Lead;
use App\Models\Property;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('Imóvel disponível')]
class PropertyPage extends Component
{
    public Property $property;

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $message = '';

    public bool $sent = false;

    public function mount(Property $property)
    {
        $this->property = $property;
    }

    public function send()
    {
        $this->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'phone' => 'nullable|string',
        ]);

        Lead::create([
            'organization_id' => $this->property->organization_id,
            'property_id' => $this->property->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
        ]);

        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.public.property-page');
    }
}
