<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Failed = 'failed';
    case Refunded = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendente',
            self::Confirmed => 'Confirmado',
            self::Failed => 'Falhou',
            self::Refunded => 'Reembolsado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Confirmed => 'success',
            self::Failed => 'danger',
            self::Refunded => 'neutral',
        };
    }
}
