<?php

namespace App\Enums;

enum MaintenanceStatus: string
{
    case Requested = 'requested';
    case Approved = 'approved';
    case Scheduled = 'scheduled';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Requested => 'Solicitada',
            self::Approved => 'Aprovada',
            self::Scheduled => 'Agendada',
            self::InProgress => 'Em Andamento',
            self::Completed => 'Concluída',
            self::Cancelled => 'Cancelada',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Requested => 'warning',
            self::Approved => 'info',
            self::Scheduled => 'info',
            self::InProgress => 'warning',
            self::Completed => 'success',
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
