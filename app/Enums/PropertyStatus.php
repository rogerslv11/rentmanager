<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case Available = 'available';
    case Rented = 'rented';
    case Reserved = 'reserved';
    case Maintenance = 'maintenance';
    case Inactive = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::Available => 'Disponível',
            self::Rented => 'Alugado',
            self::Reserved => 'Reservado',
            self::Maintenance => 'Manutenção',
            self::Inactive => 'Inativo',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Available => 'success',
            self::Rented => 'info',
            self::Reserved => 'warning',
            self::Maintenance => 'warning',
            self::Inactive => 'neutral',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Available => 'home',
            self::Rented => 'key',
            self::Reserved => 'bookmark',
            self::Maintenance => 'wrench',
            self::Inactive => 'pause',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
