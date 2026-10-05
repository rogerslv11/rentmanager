<?php

namespace App\Livewire\Contracts;

use App\Actions\Contract\TerminateContractAction;
use App\Models\Contract;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Contrato')]
class Show extends Component
{
    public Contract $contract;

    public function mount(Contract $contract)
    {
        $this->contract = $contract->load([
            'property', 'tenant', 'owner', 'charges', 'histories.user', 'documents',
        ]);
    }

    public function terminate()
    {
        app(TerminateContractAction::class)->execute($this->contract, 'Encerramento solicitado');
        $this->dispatch('toast', type: 'success', message: 'Contrato encerrado.');

        return redirect()->route('contracts.show', $this->contract);
    }

    public function render()
    {
        return view('livewire.contracts.show');
    }
}
