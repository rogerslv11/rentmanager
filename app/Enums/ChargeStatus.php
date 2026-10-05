<?php

namespace App\Enums;

enum ChargeStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Overdue = 'overdue';
    case PartiallyPaid = 'partially_paid';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendente',
            self::Paid => 'Pago',
            self::Overdue => 'Em Atraso',
            self::PartiallyPaid => 'Parcial',
            self::Cancelled => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Paid => 'success',
            self::Overdue => 'danger',
            self::PartiallyPaid => 'info',
            self::Cancelled => 'neutral',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
