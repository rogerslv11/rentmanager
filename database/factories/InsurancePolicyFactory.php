<?php

namespace Database\Factories;

use App\Enums\InsuranceType;
use App\Models\InsurancePolicy;
use App\Models\Organization;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class InsurancePolicyFactory extends Factory
{
    protected $model = InsurancePolicy::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-2 years', '-1 month');
        $end = (clone $start)->modify('+1 year');

        return [
            'organization_id' => Organization::factory(),
            'property_id' => Property::factory(),
            'type' => fake()->randomElement(InsuranceType::cases()),
            'provider' => fake()->randomElement(['Porto Seguro', 'Bradesco Seguros', 'SulAmérica', 'Mapfre', 'Zurich', 'Tokio Marine', 'HDI']),
            'policy_number' => fake()->unique()->numerify('POL-########'),
            'coverage_amount' => fake()->randomFloat(2, 100000, 1000000),
            'premium_amount' => fake()->randomFloat(2, 80, 600),
            'start_date' => $start,
            'end_date' => $end,
            'is_active' => true,
        ];
    }
}
