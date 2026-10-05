<?php

namespace App\Notifications;

use App\Models\Charge;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChargeOverdueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Charge $charge, public int $daysOverdue) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Cobrança em atraso - '.$this->charge->reference)
            ->greeting('Olá '.$notifiable->name.'!')
            ->line('Identificamos uma cobrança em atraso.')
            ->line('Valor: R$ '.number_format((float) $this->charge->total_amount, 2, ',', '.'))
            ->line('Dias em atraso: '.$this->daysOverdue)
            ->line('Vencimento: '.$this->charge->due_date->format('d/m/Y'))
            ->action('Regularizar agora', url('/tenant-portal/charges/'.$this->charge->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'charge_id' => $this->charge->id,
            'reference' => $this->charge->reference,
            'amount' => (float) $this->charge->total_amount,
            'days_overdue' => $this->daysOverdue,
            'type' => 'charge.overdue',
            'title' => 'Cobrança em atraso',
            'message' => $this->daysOverdue.' dia(s) em atraso - R$ '.number_format((float) $this->charge->total_amount, 2, ',', '.'),
            'icon' => 'alert-circle',
        ];
    }
}
