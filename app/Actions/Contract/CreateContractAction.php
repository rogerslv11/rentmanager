<?php

namespace App\Actions\Contract;

use App\Models\Contract;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\DB;

class CreateContractAction
{
    public function __construct(protected ActivityLogger $logger) {}

    public function execute(array $data): Contract
    {
        return DB::transaction(function () use ($data) {
            $contract = Contract::create($data);

            $contract->property->update(['status' => 'rented']);

            $this->logger->log('contract.created', $contract, "Contrato {$contract->number} criado");

            return $contract;
        });
    }
}
