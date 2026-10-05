<?php

namespace Database\Seeders;

use App\Enums\ChargeStatus;
use App\Enums\ContractStatus;
use App\Enums\InsuranceType;
use App\Enums\MaintenanceCategory;
use App\Enums\MaintenanceStatus;
use App\Enums\PaymentMethod;
use App\Enums\PropertyStatus;
use App\Enums\UserRole;
use App\Models\Charge;
use App\Models\Contract;
use App\Models\Expense;
use App\Models\Inspection;
use App\Models\InsurancePolicy;
use App\Models\MaintenanceRequest;
use App\Models\Organization;
use App\Models\Owner;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Receipt;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $organization = $this->command->getOutput() ? null : ($this->container['organization'] ?? null);

        if (! $organization) {
            $organization = Organization::where('slug', 'like', 'rentmanager%')->first();
        }
        if (! $organization) {
            $organization = Organization::first();
        }

        // Owners
        $owners = Owner::factory()->count(20)->create([
            'organization_id' => $organization->id,
        ]);

        // Properties
        $properties = collect();
        for ($i = 0; $i < 50; $i++) {
            $owner = $owners->random();
            $property = Property::factory()->create([
                'organization_id' => $organization->id,
                'owner_id' => $owner->id,
            ]);
            $property->owners()->attach($owner->id, ['ownership_percent' => 100]);
            $properties->push($property);
        }

        // Tenants (with user accounts for portal)
        $tenants = collect();
        for ($i = 0; $i < 80; $i++) {
            $tenantUser = User::factory()->create([
                'organization_id' => $organization->id,
                'email' => 'inquilino'.$i.'@demo.test',
            ]);
            $tenantUser->assignRole(UserRole::Tenant->value);

            $tenant = Tenant::factory()->create([
                'organization_id' => $organization->id,
                'user_id' => $tenantUser->id,
            ]);
            $tenants->push($tenant);
        }

        // Active contracts + their charges/payments
        foreach ($tenants->take(40) as $i => $tenant) {
            $property = $properties->random();
            if ($property->status !== PropertyStatus::Available) {
                continue;
            }

            $contract = Contract::factory()->create([
                'organization_id' => $organization->id,
                'property_id' => $property->id,
                'owner_id' => $property->owner_id,
                'tenant_id' => $tenant->id,
                'start_date' => Carbon::now()->subMonths(rand(1, 12)),
                'end_date' => Carbon::now()->addMonths(rand(3, 24)),
                'status' => ContractStatus::Active->value,
            ]);

            $property->update(['status' => PropertyStatus::Rented]);

            // Past charges: mix paid + overdue
            for ($m = 12; $m >= 1; $m--) {
                $dueDate = Carbon::now()->subMonths($m)->day($contract->due_day);
                $rent = (float) $contract->rent_amount;
                $condo = (float) $contract->condo_fee;
                $iptu = (float) $contract->property_tax;
                $total = $rent + $condo + $iptu;

                $isOverdue = $m > 2 && rand(1, 100) <= 15;
                $isPaid = ! $isOverdue && rand(1, 100) <= 80;

                $charge = Charge::create([
                    'organization_id' => $organization->id,
                    'contract_id' => $contract->id,
                    'property_id' => $property->id,
                    'tenant_id' => $tenant->id,
                    'reference' => $dueDate->format('Y-m'),
                    'description' => 'Aluguel '.$dueDate->translatedFormat('F/Y'),
                    'rent_amount' => $rent,
                    'condo_fee' => $condo,
                    'property_tax' => $iptu,
                    'total_amount' => $total,
                    'due_date' => $dueDate,
                    'paid_amount' => $isPaid ? $total : 0,
                    'paid_at' => $isPaid ? $dueDate->copy()->addDays(rand(0, 5)) : null,
                    'status' => $isPaid ? ChargeStatus::Paid->value : ($isOverdue ? ChargeStatus::Overdue->value : ChargeStatus::Pending->value),
                ]);

                if ($isPaid) {
                    Payment::create([
                        'organization_id' => $organization->id,
                        'charge_id' => $charge->id,
                        'amount' => $total,
                        'paid_at' => $charge->paid_at,
                        'method' => fake()->randomElement(PaymentMethod::cases()),
                        'transaction_id' => fake()->optional(0.5)->bothify('TRANS-########'),
                    ]);
                    Receipt::create([
                        'organization_id' => $organization->id,
                        'payment_id' => $charge->payments()->latest()->first()?->id ?? 0,
                        'charge_id' => $charge->id,
                        'issued_at' => $charge->paid_at,
                        'amount' => $total,
                    ]);
                }
            }

            // Current month charge (always pending)
            $dueDate = Carbon::now()->day($contract->due_day);
            if ($dueDate->lt(now())) {
                $dueDate->addMonth();
            }
            Charge::create([
                'organization_id' => $organization->id,
                'contract_id' => $contract->id,
                'property_id' => $property->id,
                'tenant_id' => $tenant->id,
                'reference' => $dueDate->format('Y-m'),
                'description' => 'Aluguel '.$dueDate->translatedFormat('F/Y'),
                'rent_amount' => $contract->rent_amount,
                'condo_fee' => $contract->condo_fee,
                'property_tax' => $contract->property_tax,
                'total_amount' => (float) $contract->rent_amount + (float) $contract->condo_fee + (float) $contract->property_tax,
                'due_date' => $dueDate,
                'status' => ChargeStatus::Pending->value,
            ]);
        }

        // Vendors
        $vendors = Vendor::factory()->count(20)->create([
            'organization_id' => $organization->id,
        ]);

        // Maintenance requests (mix open + closed)
        $propertiesForMaintenance = $properties->random(min(30, $properties->count()));
        foreach ($propertiesForMaintenance as $property) {
            $count = rand(1, 3);
            for ($j = 0; $j < $count; $j++) {
                $category = fake()->randomElement(MaintenanceCategory::cases());
                $status = fake()->randomElement([
                    MaintenanceStatus::Requested->value,
                    MaintenanceStatus::Approved->value,
                    MaintenanceStatus::Scheduled->value,
                    MaintenanceStatus::InProgress->value,
                    MaintenanceStatus::Completed->value,
                    MaintenanceStatus::Completed->value,
                    MaintenanceStatus::Completed->value,
                ]);

                $request = MaintenanceRequest::factory()->create([
                    'organization_id' => $organization->id,
                    'property_id' => $property->id,
                    'tenant_id' => $property->activeContract?->tenant_id,
                    'vendor_id' => $vendors->random()->id,
                    'category' => $category,
                    'status' => $status,
                ]);

                if ($status === MaintenanceStatus::Completed->value) {
                    $request->update([
                        'completed_at' => fake()->dateTimeBetween('-3 months', '-1 day'),
                        'final_cost' => fake()->randomFloat(2, 80, 1500),
                    ]);

                    Expense::create([
                        'organization_id' => $organization->id,
                        'property_id' => $property->id,
                        'owner_id' => $property->owner_id,
                        'maintenance_request_id' => $request->id,
                        'category' => 'maintenance',
                        'description' => $request->title,
                        'amount' => $request->final_cost,
                        'expense_date' => $request->completed_at,
                        'vendor_name' => $request->vendor?->name,
                        'status' => 'paid',
                    ]);
                }
            }
        }

        // Inspections
        foreach ($properties->random(30) as $property) {
            Inspection::factory()->create([
                'organization_id' => $organization->id,
                'property_id' => $property->id,
            ]);
        }

        // Insurance
        foreach ($properties->random(25) as $property) {
            InsurancePolicy::factory()->create([
                'organization_id' => $organization->id,
                'property_id' => $property->id,
                'type' => fake()->randomElement(InsuranceType::cases()),
            ]);
        }

        // General expenses
        Expense::factory()->count(100)->create([
            'organization_id' => $organization->id,
        ])->each(function (Expense $expense) use ($organization) {
            $property = $organization->properties()->inRandomOrder()->first();
            if ($property) {
                $expense->update([
                    'property_id' => $property->id,
                    'owner_id' => $property->owner_id,
                ]);
            }
        });

        // Property photos (sample)
        foreach ($properties->random(30) as $property) {
            $property->photos()->create([
                'path' => 'properties/placeholder-'.rand(1, 5).'.jpg',
                'is_cover' => true,
                'sort_order' => 0,
            ]);
        }

        $this->command->info('Demo data seeded: '.
            $properties->count().' properties, '.
            $owners->count().' owners, '.
            $tenants->count().' tenants, '.
            '40+ contracts, '.
            Charge::count().' charges, '.
            Payment::count().' payments, '.
            MaintenanceRequest::count().' maintenance, '.
            Vendor::count().' vendors'
        );
    }
}
