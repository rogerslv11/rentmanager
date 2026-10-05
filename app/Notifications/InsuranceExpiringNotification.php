<?php

namespace App\Notifications;

use App\Models\InsurancePolicy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class InsuranceExpiringNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public InsurancePolicy $policy, public int $daysToExpire) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'policy_id' => $this->policy->id,
            'type' => $this->policy->type?->value,
            'provider' => $this->policy->provider,
            'days_to_expire' => $this->daysToExpire,
            'end_date' => $this->policy->end_date->format('Y-m-d'),
            'type_event' => 'insurance.expiring',
            'title' => 'Seguro vencendo',
            'message' => "Apólice {$this->policy->policy_number} vence em {$this->daysToExpire} dias",
            'icon' => 'shield',
        ];
    }
}
