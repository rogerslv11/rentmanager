<?php

namespace App\Services;

use App\Enums\PayoutStatus;
use App\Models\Contract;
use App\Models\OwnerPayout;
use Carbon\Carbon;

class PayoutCalculationService
{
    /**
     * Calcula repasses pendentes para um proprietário em um período.
     */
    public function calculateForOwner(int $ownerId, Carbon $start, Carbon $end): array
    {
        $contracts = Contract::query()
            ->where('owner_id', $ownerId)
            ->where('status', 'active')
            ->get();

        $totalRent = 0;
        $totalAdminFee = 0;
        $totalMaintenance = 0;
        $totalNet = 0;

        foreach ($contracts as $contract) {
            $charges = $contract->charges()
                ->where('status', 'paid')
                ->whereBetween('paid_at', [$start, $end])
                ->get();

            $contractRent = 0;
            $contractAdminFee = 0;
            foreach ($charges as $charge) {
                $rent = (float) $charge->rent_amount;
                $contractRent += $rent;
                $contractAdminFee += (float) $contract->admin_fee_fixed
                    + ($rent * (float) $contract->admin_fee_percent / 100);
            }

            $contractMaintenance = (float) ($contract->property?->maintenanceRequests()
                ->whereBetween('completed_at', [$start, $end])
                ->sum('final_cost') ?? 0);

            $totalRent += $contractRent;
            $totalAdminFee += $contractAdminFee;
            $totalMaintenance += $contractMaintenance;
            $totalNet += ($contractRent - $contractAdminFee - $contractMaintenance);
        }

        return [
            'gross_amount' => $totalRent,
            'admin_fee' => $totalAdminFee,
            'maintenance_amount' => $totalMaintenance,
            'other_deductions' => 0,
            'net_amount' => max(0, $totalNet),
        ];
    }

    public function createPayout(int $ownerId, int $organizationId, Carbon $periodStart, Carbon $periodEnd, array $data): OwnerPayout
    {
        return OwnerPayout::create([
            'organization_id' => $organizationId,
            'owner_id' => $ownerId,
            'reference' => $data['reference'] ?? $periodStart->format('Y-m'),
            'gross_amount' => $data['gross_amount'],
            'admin_fee' => $data['admin_fee'],
            'maintenance_amount' => $data['maintenance_amount'],
            'other_deductions' => $data['other_deductions'] ?? 0,
            'net_amount' => $data['net_amount'],
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
            'scheduled_for' => $data['scheduled_for'] ?? null,
            'status' => PayoutStatus::Pending,
            'payment_method' => $data['payment_method'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);
    }
}
