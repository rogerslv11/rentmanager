<?php

namespace App\Enums;

enum ContractStatus: string
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Active = 'active';
    case Expiring = 'expiring';
    case Expired = 'expired';
    case Cancelled = 'cancelled';
    case Terminated = 'terminated';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Rascunho',
            self::Pending => 'Pendente',
            self::Active => 'Ativo',
            self::Expiring => 'Vencendo',
            self::Expired => 'Expirado',
            self::Cancelled => 'Cancelado',
            self::Terminated => 'Encerrado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => 'neutral',
            self::Pending => 'warning',
            self::Active => 'success',
            self::Expiring => 'warning',
            self::Expired => 'danger',
            self::Cancelled => 'neutral',
            self::Terminated => 'danger',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
