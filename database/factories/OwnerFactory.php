<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

class OwnerFactory extends Factory
{
    protected $model = Owner::class;

    public function definition(): array
    {
        $isCompany = fake()->boolean(20);

        return [
            'organization_id' => Organization::factory(),
            'name' => $isCompany ? fake()->company() : fake()->name(),
            'tax_id' => $isCompany ? fake()->numerify('##.###.###/####-##') : fake()->numerify('###.###.###-##'),
            'email' => fake()->safeEmail(),
            'phone' => fake()->numerify('(##) ####-####'),
            'mobile' => fake()->numerify('(##) #####-####'),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'zip_code' => fake()->numerify('#####-###'),
            'bank_name' => fake()->randomElement(['Itaú', 'Bradesco', 'Banco do Brasil', 'Santander', 'Caixa', 'Nubank', 'Inter']),
            'bank_agency' => fake()->numerify('####'),
            'bank_account' => fake()->numerify('######-#'),
            'bank_account_type' => fake()->randomElement(['Corrente', 'Poupança']),
            'pix_key' => fake()->randomElement([fake()->email(), fake()->numerify('###.###.###-##'), fake()->numerify('(##) #####-####')]),
            'is_active' => true,
        ];
    }
}
