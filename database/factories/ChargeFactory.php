<?php

namespace Database\Factories;

use App\Enums\ChargeStatus;
use App\Models\Charge;
use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChargeFactory extends Factory
{
    protected $model = Charge::class;

    public function definition(): array
    {
        $contract = Contract::factory()->create();
        $rent = (float) $contract->rent_amount;
        $condo = (float) $contract->condo_fee;
        $iptu = (float) $contract->property_tax;
        $insurance = (float) $contract->insurance_amount;
        $total = $rent + $condo + $iptu + $insurance;
        $dueDate = fake()->dateTimeBetween('-3 months', '+1 month');

        return [
            'organization_id' => $contract->organization_id,
            'contract_id' => $contract->id,
            'property_id' => $contract->property_id,
            'tenant_id' => $contract->tenant_id,
            'reference' => $dueDate->format('Y-m'),
            'description' => 'Aluguel '.Carbon::parse($dueDate)->translatedFormat('F/Y'),
            'rent_amount' => $rent,
            'condo_fee' => $condo,
            'property_tax' => $iptu,
            'insurance_amount' => $insurance,
            'discount' => 0,
            'total_amount' => $total,
            'paid_amount' => 0,
            'due_date' => $dueDate,
            'status' => ChargeStatus::Pending->value,
        ];
    }

    public function paid(): static
    {
        return $this->state(function () {
            return [
                'paid_amount' => fn (array $attrs) => $attrs['total_amount'],
                'paid_at' => now()->subDays(rand(0, 5)),
                'status' => ChargeStatus::Paid->value,
            ];
        });
    }

    public function overdue(): static
    {
        return $this->state(fn () => [
            'due_date' => now()->subDays(rand(10, 90)),
            'status' => ChargeStatus::Overdue->value,
        ]);
    }
}
