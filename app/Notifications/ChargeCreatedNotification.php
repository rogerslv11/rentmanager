<?php

namespace App\Notifications;

use App\Models\Charge;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChargeCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Charge $charge) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nova cobrança disponível - '.$this->charge->reference)
            ->greeting('Olá '.$notifiable->name.'!')
            ->line('Uma nova cobrança foi gerada para o seu contrato.')
            ->line('Valor: R$ '.number_format((float) $this->charge->total_amount, 2, ',', '.'))
            ->line('Vencimento: '.$this->charge->due_date->format('d/m/Y'))
            ->action('Ver cobrança', url('/tenant-portal/charges/'.$this->charge->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'charge_id' => $this->charge->id,
            'reference' => $this->charge->reference,
            'amount' => (float) $this->charge->total_amount,
            'due_date' => $this->charge->due_date->format('Y-m-d'),
            'type' => 'charge.created',
            'title' => 'Nova cobrança',
            'message' => 'Cobrança de R$ '.number_format((float) $this->charge->total_amount, 2, ',', '.').' vence em '.$this->charge->due_date->format('d/m/Y'),
            'icon' => 'receipt',
        ];
    }
}
