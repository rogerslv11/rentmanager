<?php

namespace App\Livewire\Owners;

use App\Models\Owner;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Proprietário')]
class Show extends Component
{
    public Owner $owner;

    public function mount(Owner $owner)
    {
        $this->owner = $owner->load(['properties', 'contracts', 'payouts']);
    }

    public function render()
    {
        return view('livewire.owners.show');
    }
}
