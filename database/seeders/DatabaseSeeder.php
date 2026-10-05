<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        // Demo Organization (primary)
        $demoOrg = Organization::factory()->create([
            'name' => 'RentManager Demo',
            'legal_name' => 'RentManager Demonstrações Ltda',
            'tax_id' => '11.222.333/0001-44',
            'email' => 'contato@rentmanager.test',
            'phone' => '(11) 4002-8922',
            'default_admin_fee_percent' => 8.0,
        ]);

        // Additional orgs
        $otherOrgs = Organization::factory()->count(2)->create();

        // Demo user
        $demoUser = User::factory()->demo()->create([
            'organization_id' => $demoOrg->id,
            'name' => 'Carlos Administrador',
        ]);
        $demoUser->assignRole(UserRole::Admin->value);

        // Staff users
        $staff = User::factory()->count(5)->create([
            'organization_id' => $demoOrg->id,
        ]);
        foreach ($staff as $i => $user) {
            $user->assignRole([
                UserRole::PropertyManager->value,
                UserRole::Financial->value,
                UserRole::Maintenance->value,
                UserRole::Agent->value,
                UserRole::Admin->value,
            ][$i]);
        }

        // Additional orgs users
        foreach ($otherOrgs as $org) {
            $u = User::factory()->create(['organization_id' => $org->id]);
            $u->assignRole(UserRole::OrganizationOwner->value);
        }

        // Super admin
        $super = User::factory()->superAdmin()->create([
            'name' => 'Super Administrador',
        ]);

        // Seed domains for demo org
        $this->call(DemoDataSeeder::class, false, ['organization' => $demoOrg]);
    }
}
