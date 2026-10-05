<?php

namespace App\Notifications;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContractExpiringNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Contract $contract, public int $daysToExpire) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Contrato próximo do vencimento')
            ->line('O contrato '.$this->contract->number.' vence em '.$this->daysToExpire.' dias.')
            ->action('Ver contrato', url('/contracts/'.$this->contract->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'contract_id' => $this->contract->id,
            'contract_number' => $this->contract->number,
            'days_to_expire' => $this->daysToExpire,
            'end_date' => $this->contract->end_date->format('Y-m-d'),
            'type' => 'contract.expiring',
            'title' => 'Contrato vencendo',
            'message' => "Contrato {$this->contract->number} vence em {$this->daysToExpire} dias",
            'icon' => 'file-warning',
        ];
    }
}
