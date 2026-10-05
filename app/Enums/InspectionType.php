<?php

namespace App\Enums;

enum InspectionType: string
{
    case MoveIn = 'move_in';
    case Periodic = 'periodic';
    case MoveOut = 'move_out';
    case Maintenance = 'maintenance';

    public function label(): string
    {
        return match ($this) {
            self::MoveIn => 'Entrada',
            self::Periodic => 'Periódica',
            self::MoveOut => 'Saída',
            self::Maintenance => 'Manutenção',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
