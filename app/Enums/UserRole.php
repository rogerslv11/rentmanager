<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case OrganizationOwner = 'organization_owner';
    case Admin = 'admin';
    case PropertyManager = 'property_manager';
    case Financial = 'financial';
    case Maintenance = 'maintenance';
    case Agent = 'agent';
    case Owner = 'owner';
    case Tenant = 'tenant';
    case Viewer = 'viewer';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Administrador',
            self::OrganizationOwner => 'Proprietário da Organização',
            self::Admin => 'Administrador',
            self::PropertyManager => 'Gestor de Imóveis',
            self::Financial => 'Financeiro',
            self::Maintenance => 'Manutenção',
            self::Agent => 'Agente',
            self::Owner => 'Proprietário',
            self::Tenant => 'Inquilino',
            self::Viewer => 'Visualizador',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Acesso total ao sistema',
            self::OrganizationOwner => 'Dono da imobiliária ou administradora',
            self::Admin => 'Administração completa da organização',
            self::PropertyManager => 'Gerencia imóveis, contratos e vistorias',
            self::Financial => 'Gerencia cobranças, pagamentos e repasses',
            self::Maintenance => 'Gerencia solicitações e fornecedores',
            self::Agent => 'Agente imobiliário',
            self::Owner => 'Proprietário de imóveis',
            self::Tenant => 'Inquilino',
            self::Viewer => 'Apenas visualização',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SuperAdmin => 'danger',
            self::OrganizationOwner => 'info',
            self::Admin => 'info',
            self::PropertyManager, self::Financial, self::Maintenance => 'success',
            default => 'neutral',
        };
    }

    public function isPortal(): bool
    {
        return in_array($this, [self::Owner, self::Tenant]);
    }

    public static function portal(): array
    {
        return [self::Owner->value, self::Tenant->value];
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
