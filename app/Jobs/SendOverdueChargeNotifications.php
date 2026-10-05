<?php

namespace App\Jobs;

use App\Enums\ChargeStatus;
use App\Models\Charge;
use App\Notifications\ChargeOverdueNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOverdueChargeNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): int
    {
        $charges = Charge::whereIn('status', ['pending', 'partially_paid', 'overdue'])
            ->where('due_date', '<', now()->startOfDay())
            ->with('tenant.user')
            ->get();

        $count = 0;
        foreach ($charges as $charge) {
            $charge->refresh();
            if ($charge->status === ChargeStatus::Overdue) {
                $user = $charge->tenant?->user;
                if ($user) {
                    $user->notify(new ChargeOverdueNotification($charge, $charge->daysOverdue()));
                    $count++;
                }
            }
        }

        return $count;
    }
}
