<?php

namespace App\Jobs;

use App\Models\Charge;
use App\Notifications\ChargeCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendChargeNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $chargeId, public string $stage = 'created') {}

    public function handle(): void
    {
        $charge = Charge::with('tenant.user', 'contract.tenant.user')->find($this->chargeId);
        if (! $charge) {
            return;
        }

        $user = $charge->tenant?->user;
        if ($user) {
            $user->notify(new ChargeCreatedNotification($charge));
        }
    }
}
