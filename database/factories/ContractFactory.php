<?php

namespace Database\Factories;

use App\Enums\ContractStatus;
use App\Models\Contract;
use App\Models\Organization;
use App\Models\Owner;
use App\Models\Property;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-1 year', '6 months');
        $duration = fake()->randomElement([12, 24, 30, 36]);
        $end = (clone $start)->modify("+{$duration} months");
        $rent = fake()->randomFloat(2, 1000, 8000);

        return [
            'organization_id' => Organization::factory(),
            'property_id' => Property::factory(),
            'owner_id' => Owner::factory(),
            'tenant_id' => Tenant::factory(),
            'number' => 'CT-'.date('Y').'-'.fake()->unique()->numerify('######'),
            'start_date' => $start,
            'end_date' => $end,
            'signed_at' => (clone $start)->modify('-3 days'),
            'rent_amount' => $rent,
            'condo_fee' => fake()->randomFloat(2, 0, 800),
            'property_tax' => fake()->randomFloat(2, 0, 300),
            'insurance_amount' => fake()->randomFloat(2, 0, 50),
            'due_day' => fake()->randomElement([5, 10, 15, 20, 25]),
            'adjustment_index' => 'IGPM',
            'adjustment_periodicity' => 'yearly',
            'deposit_amount' => $rent,
            'late_fee_percent' => 2.0,
            'interest_percent' => 1.0,
            'admin_fee_percent' => 8.0,
            'admin_fee_fixed' => 0,
            'discount_amount' => 0,
            'auto_renew' => fake()->boolean(30),
            'status' => ContractStatus::Active->value,
            'notes' => fake()->optional(0.5)->sentence(),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'status' => ContractStatus::Active->value,
            'start_date' => now()->subMonths(rand(1, 11)),
            'end_date' => now()->addMonths(rand(3, 24)),
        ]);
    }

    public function expiring(): static
    {
        return $this->state(fn () => [
            'status' => ContractStatus::Active->value,
            'start_date' => now()->subMonths(11),
            'end_date' => now()->addDays(rand(7, 60)),
        ]);
    }
}
