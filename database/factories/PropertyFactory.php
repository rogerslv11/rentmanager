<?php

namespace Database\Factories;

use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Models\Organization;
use App\Models\Owner;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $type = fake()->randomElement(PropertyType::cases());
        $name = match ($type) {
            PropertyType::Apartment => 'Apto '.fake()->numberBetween(101, 999),
            PropertyType::House => 'Casa '.fake()->lastName(),
            PropertyType::Commercial => 'Sala '.fake()->numberBetween(101, 999),
            PropertyType::Store => 'Loja '.fake()->numberBetween(1, 50),
            PropertyType::Warehouse => 'Galpão '.fake()->company(),
            PropertyType::Land => 'Terreno '.fake()->streetName(),
            PropertyType::Office => 'Escritório '.fake()->numberBetween(101, 999),
            PropertyType::Studio => 'Kitnet '.fake()->numberBetween(101, 999),
            PropertyType::Other => 'Imóvel '.fake()->numberBetween(101, 999),
        };

        $rent = fake()->randomFloat(2, 800, 12000);

        return [
            'organization_id' => Organization::factory(),
            'owner_id' => Owner::factory(),
            'code' => 'IMV-'.fake()->unique()->numerify('######'),
            'slug' => Str::slug($name).'-'.Str::lower(Str::random(6)),
            'name' => $name,
            'type' => $type,
            'description' => fake()->paragraph(),
            'area_total' => fake()->randomFloat(2, 30, 600),
            'area_built' => fake()->randomFloat(2, 30, 400),
            'bedrooms' => fake()->numberBetween(0, 5),
            'bathrooms' => fake()->numberBetween(1, 4),
            'parking_spaces' => fake()->numberBetween(0, 4),
            'floor' => fake()->numberBetween(0, 20),
            'address' => fake()->streetAddress(),
            'address_number' => fake()->numberBetween(1, 9999),
            'address_complement' => fake()->optional(0.3)->randomElement(['Apto 101', 'Bloco A', 'Fundos', 'Casa 2']),
            'neighborhood' => fake()->streetName(),
            'city' => fake()->randomElement(['São Paulo', 'Rio de Janeiro', 'Belo Horizonte', 'Curitiba', 'Porto Alegre', 'Salvador', 'Fortaleza', 'Brasília', 'Manaus', 'Recife']),
            'state' => fake()->randomElement(['SP', 'RJ', 'MG', 'PR', 'RS', 'BA', 'CE', 'DF', 'AM', 'PE']),
            'zip_code' => fake()->numerify('#####-###'),
            'latitude' => fake()->latitude(-30, -5),
            'longitude' => fake()->longitude(-60, -35),
            'rent_amount' => $rent,
            'condo_fee' => fake()->randomFloat(2, 0, $rent * 0.4),
            'property_tax' => fake()->randomFloat(2, 0, $rent * 0.15),
            'insurance_amount' => fake()->randomFloat(2, 0, 50),
            'status' => fake()->randomElement([
                PropertyStatus::Available->value,
                PropertyStatus::Available->value,
                PropertyStatus::Available->value,
                PropertyStatus::Rented->value,
                PropertyStatus::Rented->value,
                PropertyStatus::Reserved->value,
                PropertyStatus::Maintenance->value,
            ]),
            'is_furnished' => fake()->boolean(30),
            'is_published' => fake()->boolean(70),
            'pets_allowed' => fake()->boolean(60),
            'features' => fake()->randomElements(['Sacada', 'Varanda', 'Piscina', 'Academia', 'Salão de Festas', 'Churrasqueira', 'Playground', 'Portaria 24h', 'Elevador', 'Garagem Coberta'], fake()->numberBetween(2, 6)),
        ];
    }

    public function rented(): static
    {
        return $this->state(fn () => ['status' => PropertyStatus::Rented->value]);
    }

    public function available(): static
    {
        return $this->state(fn () => ['status' => PropertyStatus::Available->value]);
    }
}
