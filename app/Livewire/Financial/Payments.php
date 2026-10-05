<?php

namespace App\Livewire\Financial;

use App\Enums\PaymentMethod;
use App\Models\Charge;
use App\Models\Payment;
use App\Services\PaymentService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Pagamentos')]
class Payments extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public ?int $chargeId = null;

    public float $amount = 0;

    public string $method = 'pix';

    public string $paid_at = '';

    public string $transaction_id = '';

    public string $notes = '';

    public bool $showForm = false;

    public function updatedChargeId()
    {
        $charge = Charge::find($this->chargeId);
        if ($charge) {
            $this->amount = (float) $charge->remainingAmount();
        }
    }

    public function openForm(int $chargeId)
    {
        $this->chargeId = $chargeId;
        $charge = Charge::find($chargeId);
        $this->amount = (float) $charge->remainingAmount();
        $this->paid_at = now()->format('Y-m-d');
        $this->method = 'pix';
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate([
            'chargeId' => 'required|exists:charges,id',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string',
            'paid_at' => 'required|date',
        ]);

        $charge = Charge::find($this->chargeId);
        app(PaymentService::class)->recordPayment($charge, [
            'amount' => $this->amount,
            'method' => $this->method,
            'paid_at' => $this->paid_at,
            'transaction_id' => $this->transaction_id ?: null,
            'notes' => $this->notes ?: null,
        ]);

        $this->reset(['chargeId', 'amount', 'method', 'paid_at', 'transaction_id', 'notes', 'showForm']);
        $this->dispatch('toast', type: 'success', message: 'Pagamento registrado!');
    }

    #[Computed]
    public function payments()
    {
        return Payment::query()
            ->with(['charge.tenant', 'charge.property'])
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('transaction_id', 'like', '%'.$this->search.'%')
                    ->orWhereHas('charge.tenant', fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'));
            }))
            ->latest('paid_at')
            ->paginate(20);
    }

    #[Computed]
    public function stats(): array
    {
        $base = Payment::query();
        $org = auth()->user()?->organization_id;
        if ($org) {
            $base->whereHas('charge', fn ($q) => $q->where('organization_id', $org));
        }

        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();

        return [
            'total' => (float) (clone $base)->sum('amount'),
            'month' => (float) (clone $base)->where('paid_at', '>=', $startOfMonth)->sum('amount'),
            'count_month' => (clone $base)->where('paid_at', '>=', $startOfMonth)->count(),
            'count_total' => (clone $base)->count(),
            'avg_ticket' => (clone $base)->count() > 0 ? (float) (clone $base)->avg('amount') : 0,
        ];
    }

    #[Computed]
    public function methodBreakdown(): array
    {
        $base = Payment::query();
        $org = auth()->user()?->organization_id;
        if ($org) {
            $base->whereHas('charge', fn ($q) => $q->where('organization_id', $org));
        }

        $methods = PaymentMethod::cases();
        $breakdown = [];
        foreach ($methods as $m) {
            $count = (clone $base)->where('method', $m->value)->count();
            if ($count > 0) {
                $breakdown[] = [
                    'label' => $m->label(),
                    'value' => $count,
                    'amount' => (clone $base)->where('method', $m->value)->sum('amount'),
                    'method' => $m->value,
                ];
            }
        }

        return $breakdown;
    }

    public function render()
    {
        $pendingCharges = Charge::with(['tenant', 'property'])
            ->whereIn('status', ['pending', 'partially_paid', 'overdue'])
            ->orderBy('due_date')
            ->limit(50)
            ->get();

        return view('livewire.financial.payments', compact('pendingCharges'));
    }
}
