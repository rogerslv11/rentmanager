<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition(): array
    {
        $name = fake()->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::lower(Str::random(4)),
            'legal_name' => $name.' Ltda',
            'tax_id' => fake()->numerify('##.###.###/####-##'),
            'email' => fake()->companyEmail(),
            'phone' => fake()->numerify('(##) #####-####'),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'zip_code' => fake()->numerify('#####-###'),
            'country' => 'Brasil',
            'default_admin_fee_percent' => fake()->randomElement([8.0, 10.0, 12.0]),
            'default_admin_fee_fixed' => 0,
            'is_active' => true,
        ];
    }
}
