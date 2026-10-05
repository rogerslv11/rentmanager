<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Models\Charge;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $charge = Charge::factory()->create();

        return [
            'organization_id' => $charge->organization_id,
            'charge_id' => $charge->id,
            'amount' => $charge->total_amount,
            'paid_at' => fake()->dateTimeBetween('-2 months', 'now'),
            'method' => fake()->randomElement(PaymentMethod::cases()),
            'transaction_id' => fake()->optional(0.5)->bothify('TRANS-########'),
            'notes' => fake()->optional(0.3)->sentence(),
        ];
    }
}
