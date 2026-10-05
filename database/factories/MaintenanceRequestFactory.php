<?php

namespace Database\Factories;

use App\Enums\MaintenanceCategory;
use App\Enums\MaintenancePriority;
use App\Enums\MaintenanceStatus;
use App\Models\MaintenanceRequest;
use App\Models\Organization;
use App\Models\Property;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceRequestFactory extends Factory
{
    protected $model = MaintenanceRequest::class;

    public function definition(): array
    {
        $category = fake()->randomElement(MaintenanceCategory::cases());
        $title = match ($category) {
            MaintenanceCategory::Electrical => fake()->randomElement([
                'Tomada com mau contato', 'Chuveiro queimado', 'Interruptor com problema',
                'Quadro de energia desarmando', 'Lâmpada queimada no corredor',
            ]),
            MaintenanceCategory::Plumbing => fake()->randomElement([
                'Vazamento no banheiro', 'Pia entupida', 'Descarga com defeito',
                'Torneira pingando', 'Caixa d\'água com problema',
            ]),
            MaintenanceCategory::Painting => fake()->randomElement([
                'Pintura da sala', 'Reparo de parede', 'Pintura externa',
                'Pintura do quarto', 'Retoque na fachada',
            ]),
            MaintenanceCategory::AirConditioning => fake()->randomElement([
                'Ar condicionado não gela', 'Manutenção preventiva do ar', 'Limpeza do filtro',
                'Vazamento de água no split', 'Instalação de ar condicionado',
            ]),
            MaintenanceCategory::Structure => fake()->randomElement([
                'Trinca na parede', 'Infiltração no teto', 'Piso solto',
                'Porta com problema', 'Janela emperrada',
            ]),
            MaintenanceCategory::Furniture => fake()->randomElement([
                'Reparo em armário', 'Troca de dobradiça', 'Reforma de móvel',
                'Montagem de móvel', 'Conserto de mesa',
            ]),
            MaintenanceCategory::Cleaning => fake()->randomElement([
                'Limpeza pós-obra', 'Limpeza de caixa d\'água', 'Limpeza de calhas',
                'Higienização de estofados', 'Limpeza profunda',
            ]),
            MaintenanceCategory::Gardening => fake()->randomElement([
                'Manutenção do jardim', 'Poda de árvore', 'Limpeza de quintal',
                'Plantio de grama', 'Adubação',
            ]),
            default => fake()->randomElement([
                'Reparo geral', 'Manutenção preventiva', 'Verificação técnica',
                'Solicitação diversa', 'Outro reparo',
            ]),
        };

        return [
            'organization_id' => Organization::factory(),
            'property_id' => Property::factory(),
            'tenant_id' => Tenant::factory(),
            'vendor_id' => null,
            'title' => $title,
            'description' => fake()->paragraph(),
            'category' => $category,
            'priority' => fake()->randomElement(MaintenancePriority::cases()),
            'status' => fake()->randomElement([
                MaintenanceStatus::Requested->value,
                MaintenanceStatus::Approved->value,
                MaintenanceStatus::Scheduled->value,
                MaintenanceStatus::InProgress->value,
                MaintenanceStatus::Completed->value,
            ]),
            'scheduled_for' => fake()->optional(0.6)->dateTimeBetween('-1 month', '+1 month'),
            'completed_at' => null,
            'estimated_cost' => fake()->optional(0.5)->randomFloat(2, 80, 2000),
            'final_cost' => null,
            'notes' => fake()->optional(0.3)->sentence(),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'status' => MaintenanceStatus::Completed->value,
            'completed_at' => now()->subDays(rand(1, 30)),
            'final_cost' => fake()->randomFloat(2, 80, 1500),
        ]);
    }

    public function open(): static
    {
        return $this->state(fn () => [
            'status' => fake()->randomElement([
                MaintenanceStatus::Requested->value,
                MaintenanceStatus::Approved->value,
                MaintenanceStatus::Scheduled->value,
                MaintenanceStatus::InProgress->value,
            ]),
        ]);
    }
}
