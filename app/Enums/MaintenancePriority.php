<?php

namespace App\Enums;

enum MaintenancePriority: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
    case Urgent = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::Low => 'Baixa',
            self::Medium => 'Média',
            self::High => 'Alta',
            self::Urgent => 'Urgente',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Low => 'neutral',
            self::Medium => 'info',
            self::High => 'warning',
            self::Urgent => 'danger',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
