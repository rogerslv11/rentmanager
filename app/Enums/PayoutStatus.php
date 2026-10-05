<?php

namespace App\Enums;

enum PayoutStatus: string
{
    case Pending = 'pending';
    case Scheduled = 'scheduled';
    case Paid = 'paid';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendente',
            self::Scheduled => 'Agendado',
            self::Paid => 'Pago',
            self::Cancelled => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Scheduled => 'info',
            self::Paid => 'success',
            self::Cancelled => 'neutral',
        };
    }
}
