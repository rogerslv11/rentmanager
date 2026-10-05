<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Payment $payment) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pagamento confirmado')
            ->line('Recebemos seu pagamento de R$ '.number_format((float) $this->payment->amount, 2, ',', '.'))
            ->action('Ver recibo', url('/tenant-portal/receipts'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'payment_id' => $this->payment->id,
            'amount' => (float) $this->payment->amount,
            'method' => $this->payment->method?->value,
            'type' => 'payment.received',
            'title' => 'Pagamento confirmado',
            'message' => 'R$ '.number_format((float) $this->payment->amount, 2, ',', '.').' via '.$this->payment->method?->label(),
            'icon' => 'check-circle',
        ];
    }
}
