<?php

use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    #[On('open-modal')]
    public function open(string $name): void
    {
        $this->dispatch('modal-opened', name: $name);
    }
};
?>

<div></div>
