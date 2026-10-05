<?php

namespace App\Notifications;

use App\Models\MaintenanceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MaintenanceStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public MaintenanceRequest $maintenance,
        public string $stage,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = match ($this->stage) {
            'created' => 'Sua solicitação de manutenção foi recebida.',
            'approved' => 'Sua solicitação foi aprovada.',
            'completed' => 'Sua manutenção foi concluída.',
            default => 'Atualização da sua solicitação.',
        };

        return (new MailMessage)
            ->subject('Manutenção - '.$this->maintenance->title)
            ->line($message)
            ->action('Ver detalhes', url('/maintenance/'.$this->maintenance->id));
    }

    public function toArray(object $notifiable): array
    {
        $titles = [
            'created' => 'Solicitação criada',
            'approved' => 'Solicitação aprovada',
            'scheduled' => 'Manutenção agendada',
            'in_progress' => 'Em andamento',
            'completed' => 'Concluída',
            'cancelled' => 'Cancelada',
        ];

        return [
            'maintenance_id' => $this->maintenance->id,
            'stage' => $this->stage,
            'type' => 'maintenance.'.$this->stage,
            'title' => $titles[$this->stage] ?? 'Manutenção atualizada',
            'message' => $this->maintenance->title,
            'icon' => 'wrench',
        ];
    }
}
