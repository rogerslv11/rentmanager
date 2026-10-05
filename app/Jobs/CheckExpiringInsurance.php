<?php

namespace App\Jobs;

use App\Models\InsurancePolicy;
use App\Notifications\InsuranceExpiringNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckExpiringInsurance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): int
    {
        $policies = InsurancePolicy::where('is_active', true)
            ->whereBetween('end_date', [now()->startOfDay(), now()->addDays(60)->endOfDay()])
            ->get();

        $count = 0;
        foreach ($policies as $policy) {
            $days = (int) now()->diffInDays($policy->end_date, false);
            $policy->property?->owner?->user?->notify(new InsuranceExpiringNotification($policy, $days));
            $count++;
        }

        return $count;
    }
}
