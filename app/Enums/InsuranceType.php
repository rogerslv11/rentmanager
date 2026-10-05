<?php

namespace App\Enums;

enum InsuranceType: string
{
    case Fire = 'fire';
    case Residential = 'residential';
    case Bond = 'bond';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Fire => 'Seguro Incêndio',
            self::Residential => 'Seguro Residencial',
            self::Bond => 'Seguro Fiança',
            self::Other => 'Outro',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
