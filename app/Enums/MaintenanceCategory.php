<?php

namespace App\Enums;

enum MaintenanceCategory: string
{
    case Electrical = 'electrical';
    case Plumbing = 'plumbing';
    case Painting = 'painting';
    case AirConditioning = 'air_conditioning';
    case Structure = 'structure';
    case Furniture = 'furniture';
    case Cleaning = 'cleaning';
    case Gardening = 'gardening';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Electrical => 'Elétrica',
            self::Plumbing => 'Hidráulica',
            self::Painting => 'Pintura',
            self::AirConditioning => 'Ar Condicionado',
            self::Structure => 'Estrutura',
            self::Furniture => 'Móveis',
            self::Cleaning => 'Limpeza',
            self::Gardening => 'Jardinagem',
            self::Other => 'Outros',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Electrical => 'zap',
            self::Plumbing => 'droplets',
            self::Painting => 'paintbrush',
            self::AirConditioning => 'wind',
            self::Structure => 'building',
            self::Furniture => 'sofa',
            self::Cleaning => 'sparkles',
            self::Gardening => 'tree-pine',
            self::Other => 'wrench',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
