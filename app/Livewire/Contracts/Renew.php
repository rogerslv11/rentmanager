<?php

namespace App\Livewire\Contracts;

use App\Actions\Contract\RenewContractAction;
use App\Models\Contract;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Renovar contrato')]
class Renew extends Component
{
    public Contract $contract;

    public string $start_date;

    public string $end_date;

    public float $rent_amount;

    public float $admin_fee_percent;

    public function mount(Contract $contract)
    {
        $this->contract = $contract;
        $this->start_date = $contract->end_date->copy()->addDay()->format('Y-m-d');
        $this->end_date = $this->start_date ? Carbon::parse($this->start_date)->addYear()->format('Y-m-d') : now()->addYear()->format('Y-m-d');
        $this->rent_amount = (float) $contract->rent_amount;
        $this->admin_fee_percent = (float) $contract->admin_fee_percent;
    }

    public function renew()
    {
        $this->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rent_amount' => 'required|numeric|min:0',
        ]);

        $new = app(RenewContractAction::class)->execute($this->contract, [
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'rent_amount' => $this->rent_amount,
            'admin_fee_percent' => $this->admin_fee_percent,
        ]);

        $this->dispatch('toast', type: 'success', message: 'Contrato renovado!');

        return redirect()->route('contracts.show', $new);
    }

    public function render()
    {
        return view('livewire.contracts.renew');
    }
}
