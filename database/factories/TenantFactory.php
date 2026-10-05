<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'name' => fake()->name(),
            'tax_id' => fake()->numerify('###.###.###-##'),
            'email' => fake()->safeEmail(),
            'phone' => fake()->numerify('(##) ####-####'),
            'mobile' => fake()->numerify('(##) #####-####'),
            'birth_date' => fake()->dateTimeBetween('-70 years', '-18 years'),
            'nationality' => 'Brasileira',
            'marital_status' => fake()->randomElement(['Solteiro(a)', 'Casado(a)', 'Divorciado(a)', 'Viúvo(a)', 'União Estável']),
            'profession' => fake()->randomElement(['Engenheiro', 'Médico', 'Professor', 'Advogado', 'Designer', 'Programador', 'Empresário', 'Dentista', 'Contador', 'Arquiteto', 'Analista']),
            'monthly_income' => fake()->randomFloat(2, 3000, 25000),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'zip_code' => fake()->numerify('#####-###'),
            'emergency_contact_name' => fake()->name(),
            'emergency_contact_phone' => fake()->numerify('(##) #####-####'),
            'is_active' => true,
        ];
    }
}
