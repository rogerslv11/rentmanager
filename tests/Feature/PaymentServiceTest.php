<?php

namespace Tests\Feature;

use App\Enums\ChargeStatus;
use App\Enums\PaymentMethod;
use App\Models\Charge;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_partial_payment_creates_payment_and_updates_charge_status(): void
    {
        $charge = Charge::factory()->create([
            'total_amount' => 1000,
            'paid_amount' => 0,
            'status' => ChargeStatus::Pending->value,
        ]);

        $payment = app(PaymentService::class)->recordPayment($charge, [
            'amount' => 400,
            'method' => PaymentMethod::Pix->value,
            'paid_at' => now(),
        ]);

        $this->assertInstanceOf(Payment::class, $payment);
        $this->assertSame(400.0, (float) $charge->fresh()->paid_amount);
        $this->assertSame(ChargeStatus::PartiallyPaid, $charge->fresh()->status);
        $this->assertDatabaseHas('receipts', [
            'payment_id' => $payment->id,
            'charge_id' => $charge->id,
            'amount' => 400,
        ]);
    }

    public function test_full_payment_marks_charge_as_paid(): void
    {
        $charge = Charge::factory()->create([
            'total_amount' => 500,
            'paid_amount' => 0,
            'status' => ChargeStatus::Pending->value,
        ]);

        app(PaymentService::class)->recordPayment($charge, [
            'amount' => 500,
            'method' => PaymentMethod::Pix->value,
            'paid_at' => now(),
        ]);

        $fresh = $charge->fresh();
        $this->assertSame(500.0, (float) $fresh->paid_amount);
        $this->assertSame(ChargeStatus::Paid, $fresh->status);
        $this->assertNotNull($fresh->paid_at);
    }
}
