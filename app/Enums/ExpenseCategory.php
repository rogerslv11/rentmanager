<?php

namespace App\Enums;

enum ExpenseCategory: string
{
    case Maintenance = 'maintenance';
    case Condo = 'condo';
    case PropertyTax = 'property_tax';
    case Insurance = 'insurance';
    case Fees = 'fees';
    case Energy = 'energy';
    case Water = 'water';
    case Cleaning = 'cleaning';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Maintenance => 'Manutenção',
            self::Condo => 'Condomínio',
            self::PropertyTax => 'IPTU',
            self::Insurance => 'Seguro',
            self::Fees => 'Taxas',
            self::Energy => 'Energia',
            self::Water => 'Água',
            self::Cleaning => 'Limpeza',
            self::Other => 'Outros',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
