<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()['cache']->forget('spatie.permission.cache');

        $resources = [
            'properties' => 'Imóveis',
            'owners' => 'Proprietários',
            'tenants' => 'Inquilinos',
            'contracts' => 'Contratos',
            'charges' => 'Cobranças',
            'payments' => 'Pagamentos',
            'payouts' => 'Repasses',
            'expenses' => 'Despesas',
            'maintenance' => 'Manutenção',
            'vendors' => 'Fornecedores',
            'inspections' => 'Vistorias',
            'insurance' => 'Seguros',
            'documents' => 'Documentos',
            'reports' => 'Relatórios',
            'settings' => 'Configurações',
            'users' => 'Usuários',
        ];

        $actions = ['view', 'create', 'edit', 'delete'];
        $specialActions = [
            'payments' => ['record'],
            'charges' => ['cancel'],
            'contracts' => ['renew', 'terminate'],
            'maintenance' => ['approve', 'complete'],
            'payouts' => ['process'],
        ];

        foreach ($resources as $key => $label) {
            foreach ($actions as $action) {
                $name = "{$action} {$key}";
                Permission::firstOrCreate(
                    ['name' => $name, 'guard_name' => 'web'],
                    ['group' => $label]
                );
            }
            if (isset($specialActions[$key])) {
                foreach ($specialActions[$key] as $sa) {
                    Permission::firstOrCreate(
                        ['name' => "{$sa} {$key}", 'guard_name' => 'web'],
                        ['group' => $label]
                    );
                }
            }
        }

        $roleDefinitions = [
            UserRole::OrganizationOwner->value => [
                'label' => UserRole::OrganizationOwner->label(),
                'description' => UserRole::OrganizationOwner->description(),
                'permissions' => 'all',
            ],
            UserRole::Admin->value => [
                'label' => UserRole::Admin->label(),
                'description' => UserRole::Admin->description(),
                'permissions' => 'all',
            ],
            UserRole::PropertyManager->value => [
                'label' => UserRole::PropertyManager->label(),
                'description' => UserRole::PropertyManager->description(),
                'permissions' => [
                    'view properties', 'create properties', 'edit properties', 'delete properties',
                    'view owners', 'create owners', 'edit owners',
                    'view tenants', 'create tenants', 'edit tenants',
                    'view contracts', 'create contracts', 'edit contracts', 'renew contracts', 'terminate contracts',
                    'view maintenance', 'create maintenance', 'edit maintenance', 'approve maintenance', 'complete maintenance',
                    'view vendors', 'create vendors', 'edit vendors',
                    'view inspections', 'create inspections', 'edit inspections',
                    'view insurance',
                    'view documents', 'create documents',
                    'view reports',
                ],
            ],
            UserRole::Financial->value => [
                'label' => UserRole::Financial->label(),
                'description' => UserRole::Financial->description(),
                'permissions' => [
                    'view properties',
                    'view owners',
                    'view tenants',
                    'view contracts',
                    'view charges', 'create charges', 'edit charges', 'cancel charges',
                    'view payments', 'record payments', 'edit payments',
                    'view payouts', 'create payouts', 'edit payouts', 'process payouts',
                    'view expenses', 'create expenses', 'edit expenses', 'delete expenses',
                    'view reports',
                ],
            ],
            UserRole::Maintenance->value => [
                'label' => UserRole::Maintenance->label(),
                'description' => UserRole::Maintenance->description(),
                'permissions' => [
                    'view properties',
                    'view tenants',
                    'view maintenance', 'create maintenance', 'edit maintenance', 'approve maintenance', 'complete maintenance',
                    'view vendors', 'create vendors', 'edit vendors',
                    'view inspections',
                ],
            ],
            UserRole::Agent->value => [
                'label' => UserRole::Agent->label(),
                'description' => UserRole::Agent->description(),
                'permissions' => [
                    'view properties', 'create properties', 'edit properties',
                    'view owners', 'view tenants',
                    'view contracts',
                    'view maintenance',
                    'view inspections',
                ],
            ],
            UserRole::Owner->value => [
                'label' => UserRole::Owner->label(),
                'description' => UserRole::Owner->description(),
                'permissions' => [
                    'view properties',
                    'view contracts',
                    'view payouts',
                ],
            ],
            UserRole::Tenant->value => [
                'label' => UserRole::Tenant->label(),
                'description' => UserRole::Tenant->description(),
                'permissions' => [
                    'view contracts',
                    'view charges',
                    'view maintenance', 'create maintenance',
                    'view documents',
                ],
            ],
            UserRole::Viewer->value => [
                'label' => UserRole::Viewer->label(),
                'description' => UserRole::Viewer->description(),
                'permissions' => [
                    'view properties', 'view owners', 'view tenants', 'view contracts',
                    'view charges', 'view payments', 'view maintenance', 'view inspections',
                ],
            ],
        ];

        foreach ($roleDefinitions as $name => $definition) {
            $role = Role::firstOrCreate(
                ['name' => $name, 'guard_name' => 'web', 'organization_id' => null],
                ['description' => $definition['description']]
            );

            if ($definition['permissions'] === 'all') {
                $role->syncPermissions(Permission::all());
            } else {
                $role->syncPermissions($definition['permissions']);
            }
        }
    }
}
