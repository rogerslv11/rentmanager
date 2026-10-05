<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    protected $model = Vendor::class;

    public function definition(): array
    {
        $category = fake()->randomElement([
            'Elétrica', 'Hidráulica', 'Pintura', 'Ar Condicionado',
            'Marcenaria', 'Limpeza', 'Jardinagem', 'Serralheria',
        ]);

        return [
            'organization_id' => Organization::factory(),
            'name' => fake()->name(),
            'company_name' => fake()->optional(0.6)->company(),
            'tax_id' => fake()->numerify('##.###.###/####-##'),
            'email' => fake()->safeEmail(),
            'phone' => fake()->numerify('(##) #####-####'),
            'category' => $category,
            'specialty' => fake()->randomElement([
                'Residencial', 'Comercial', 'Industrial', 'Predial',
            ]),
            'hourly_rate' => fake()->randomFloat(2, 50, 250),
            'address' => fake()->streetAddress(),
            'notes' => fake()->optional(0.4)->sentence(),
            'is_active' => true,
        ];
    }
}
