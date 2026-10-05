<?php

namespace App\Services;

use App\Enums\ChargeStatus;
use App\Enums\ContractStatus;
use App\Jobs\SendChargeNotification;
use App\Models\Charge;
use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChargeGenerationService
{
    /**
     * Gera cobranças mensais para todos os contratos ativos.
     * Idempotente: não cria cobranças duplicadas para o mesmo mês/referência.
     */
    public function generateMonthlyCharges(?Carbon $referenceDate = null): array
    {
        $referenceDate = $referenceDate ?? now();
        $reference = $referenceDate->format('Y-m');
        $created = 0;
        $skipped = 0;

        $contracts = Contract::query()
            ->where('status', ContractStatus::Active->value)
            ->where('start_date', '<=', $referenceDate->endOfMonth())
            ->where('end_date', '>=', $referenceDate->startOfMonth())
            ->get();

        foreach ($contracts as $contract) {
            if ($this->chargeExistsForMonth($contract, $reference)) {
                $skipped++;

                continue;
            }

            $charge = $this->createChargeFromContract($contract, $referenceDate);
            if ($charge) {
                $created++;
                SendChargeNotification::dispatch($charge->id, 'created');
            }
        }

        return [
            'created' => $created,
            'skipped' => $skipped,
            'reference' => $reference,
        ];
    }

    public function chargeExistsForMonth(Contract $contract, string $reference): bool
    {
        return Charge::where('contract_id', $contract->id)
            ->where('reference', $reference)
            ->exists();
    }

    public function createChargeFromContract(Contract $contract, Carbon $dueDate): ?Charge
    {
        return DB::transaction(function () use ($contract, $dueDate) {
            $rent = (float) $contract->rent_amount;
            $condo = (float) $contract->condo_fee;
            $iptu = (float) $contract->property_tax;
            $insurance = (float) $contract->insurance_amount;
            $discount = (float) $contract->discount_amount;
            $total = $rent + $condo + $iptu + $insurance - $discount;

            if ($total <= 0) {
                return null;
            }

            $charge = Charge::create([
                'organization_id' => $contract->organization_id,
                'contract_id' => $contract->id,
                'property_id' => $contract->property_id,
                'tenant_id' => $contract->tenant_id,
                'reference' => $dueDate->format('Y-m'),
                'description' => 'Aluguel '.$dueDate->translatedFormat('F/Y'),
                'rent_amount' => $rent,
                'condo_fee' => $condo,
                'property_tax' => $iptu,
                'insurance_amount' => $insurance,
                'discount' => $discount,
                'total_amount' => $total,
                'due_date' => $dueDate->copy()->day($contract->due_day ?: 5),
                'status' => ChargeStatus::Pending,
            ]);

            // Marca o imóvel como alugado
            $contract->property?->update(['status' => 'rented']);

            return $charge;
        });
    }

    /**
     * Atualiza status de cobranças vencidas.
     */
    public function markOverdueCharges(): int
    {
        return Charge::whereIn('status', [ChargeStatus::Pending->value, ChargeStatus::PartiallyPaid->value])
            ->where('due_date', '<', now()->startOfDay())
            ->update(['status' => ChargeStatus::Overdue->value]);
    }
}
