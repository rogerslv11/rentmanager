<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Pix = 'pix';
    case Transfer = 'transfer';
    case Boleto = 'boleto';
    case Card = 'card';
    case Cash = 'cash';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Pix => 'PIX',
            self::Transfer => 'Transferência',
            self::Boleto => 'Boleto',
            self::Card => 'Cartão',
            self::Cash => 'Dinheiro',
            self::Other => 'Outro',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Pix => 'zap',
            self::Transfer => 'arrow-left-right',
            self::Boleto => 'file-text',
            self::Card => 'credit-card',
            self::Cash => 'banknote',
            self::Other => 'circle',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
