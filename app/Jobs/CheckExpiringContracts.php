<?php

namespace App\Jobs;

use App\Models\Contract;
use App\Notifications\ContractExpiringNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckExpiringContracts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): int
    {
        $thresholds = [90, 60, 30, 7];
        $count = 0;

        foreach ($thresholds as $days) {
            $contracts = Contract::with('tenant.user', 'owner.user')
                ->where('status', 'active')
                ->whereBetween('end_date', [now()->startOfDay(), now()->addDays($days)->endOfDay()])
                ->get();

            foreach ($contracts as $contract) {
                $daysLeft = (int) now()->diffInDays($contract->end_date, false);
                if ($daysLeft !== $days) {
                    continue;
                }

                $contract->tenant?->user?->notify(new ContractExpiringNotification($contract, $daysLeft));
                $count++;
            }
        }

        return $count;
    }
}
