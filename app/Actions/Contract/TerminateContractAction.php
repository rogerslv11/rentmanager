<?php

namespace App\Actions\Contract;

use App\Models\Contract;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;

class TerminateContractAction
{
    public function __construct(protected ActivityLogger $logger) {}

    public function execute(Contract $contract, string $reason, ?string $notes = null): Contract
    {
        return DB::transaction(function () use ($contract, $reason, $notes) {
            $contract->update([
                'status' => 'terminated',
                'terminated_at' => now(),
                'termination_reason' => $reason,
                'notes' => $notes ? ($contract->notes."\n\n[Encerramento] {$notes}") : $contract->notes,
            ]);

            $contract->property->update(['status' => 'available']);

            $this->logger->log('contract.terminated', $contract, "Contrato {$contract->number} encerrado. Motivo: {$reason}");

            return $contract;
        });
    }
}
