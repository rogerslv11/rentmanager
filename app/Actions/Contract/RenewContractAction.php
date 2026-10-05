<?php

namespace App\Actions\Contract;

use App\Models\Contract;
use App\Models\ContractHistory;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;

class RenewContractAction
{
    public function __construct(protected ActivityLogger $logger) {}

    public function execute(Contract $contract, array $data): Contract
    {
        return DB::transaction(function () use ($contract, $data) {
            $newContract = Contract::create([
                'organization_id' => $contract->organization_id,
                'property_id' => $contract->property_id,
                'owner_id' => $contract->owner_id,
                'tenant_id' => $contract->tenant_id,
                'number' => null,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'rent_amount' => $data['rent_amount'] ?? $contract->rent_amount,
                'condo_fee' => $data['condo_fee'] ?? $contract->condo_fee,
                'property_tax' => $data['property_tax'] ?? $contract->property_tax,
                'insurance_amount' => $data['insurance_amount'] ?? $contract->insurance_amount,
                'due_day' => $data['due_day'] ?? $contract->due_day,
                'adjustment_index' => $data['adjustment_index'] ?? $contract->adjustment_index,
                'adjustment_periodicity' => $data['adjustment_periodicity'] ?? $contract->adjustment_periodicity,
                'deposit_amount' => $data['deposit_amount'] ?? $contract->deposit_amount,
                'late_fee_percent' => $data['late_fee_percent'] ?? $contract->late_fee_percent,
                'interest_percent' => $data['interest_percent'] ?? $contract->interest_percent,
                'admin_fee_percent' => $data['admin_fee_percent'] ?? $contract->admin_fee_percent,
                'admin_fee_fixed' => $data['admin_fee_fixed'] ?? $contract->admin_fee_fixed,
                'discount_amount' => $data['discount_amount'] ?? $contract->discount_amount,
                'auto_renew' => $data['auto_renew'] ?? $contract->auto_renew,
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
                'parent_contract_id' => $contract->id,
            ]);

            ContractHistory::create([
                'contract_id' => $contract->id,
                'user_id' => auth()->id(),
                'action' => 'renewed',
                'notes' => 'Contrato renovado. Novo contrato: '.$newContract->number,
            ]);

            $contract->update(['status' => 'expired']);

            $this->logger->log('contract.renewed', $newContract, "Contrato {$contract->number} renovado");

            return $newContract;
        });
    }
}
