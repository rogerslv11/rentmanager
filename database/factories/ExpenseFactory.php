<?php

namespace Database\Factories;

use App\Enums\ExpenseCategory;
use App\Models\Expense;
use App\Models\Organization;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'property_id' => Property::factory(),
            'category' => fake()->randomElement(ExpenseCategory::cases()),
            'description' => fake()->randomElement([
                'Conta de luz', 'Conta de água', 'Condomínio', 'IPTU',
                'Manutenção preventiva', 'Material de limpeza', 'Reparo elétrico',
                'Pintura', 'Serviço de jardinagem', 'Taxa administrativa',
            ]),
            'amount' => fake()->randomFloat(2, 50, 3000),
            'expense_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'vendor_name' => fake()->optional(0.7)->company(),
            'status' => 'paid',
        ];
    }
}
