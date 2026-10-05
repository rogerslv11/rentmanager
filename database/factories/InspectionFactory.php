<?php

namespace Database\Factories;

use App\Enums\InspectionType;
use App\Models\Inspection;
use App\Models\Organization;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class InspectionFactory extends Factory
{
    protected $model = Inspection::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'property_id' => Property::factory(),
            'type' => fake()->randomElement(InspectionType::cases()),
            'title' => 'Vistoria '.fake()->randomElement(['Inicial', 'Periódica', 'Final']),
            'scheduled_for' => fake()->dateTimeBetween('-3 months', '+1 month'),
            'notes' => fake()->optional(0.7)->paragraph(),
            'status' => fake()->randomElement(['scheduled', 'completed', 'cancelled']),
            'checklist' => [
                'Sala' => ['Pintura' => 'ok', 'Piso' => 'ok', 'Iluminação' => 'ok'],
                'Quarto' => ['Pintura' => 'ok', 'Janela' => 'ok'],
                'Cozinha' => ['Pia' => 'ok', 'Azulejos' => 'ok'],
                'Banheiro' => ['Vaso' => 'ok', 'Chuveiro' => 'ok'],
            ],
        ];
    }
}
