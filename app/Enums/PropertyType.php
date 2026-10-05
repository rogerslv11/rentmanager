<?php

namespace App\Enums;

enum PropertyType: string
{
    case Apartment = 'apartment';
    case House = 'house';
    case Commercial = 'commercial';
    case Store = 'store';
    case Warehouse = 'warehouse';
    case Land = 'land';
    case Office = 'office';
    case Studio = 'studio';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Apartment => 'Apartamento',
            self::House => 'Casa',
            self::Commercial => 'Sala Comercial',
            self::Store => 'Loja',
            self::Warehouse => 'Galpão',
            self::Land => 'Terreno',
            self::Office => 'Escritório',
            self::Studio => 'Kitnet',
            self::Other => 'Outro',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Apartment, self::Studio => 'building-2',
            self::House => 'home',
            self::Commercial, self::Office => 'briefcase',
            self::Store => 'store',
            self::Warehouse => 'warehouse',
            self::Land => 'map',
            self::Other => 'box',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
