<?php

namespace Tests\Feature;

use App\Enums\ChargeStatus;
use App\Models\Charge;
use App\Services\ChargeGenerationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarkOverdueChargesTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_pending_or_partially_paid_charges_with_past_due_date_are_marked_overdue(): void
    {
        $service = app(ChargeGenerationService::class);

        $overduePending = Charge::factory()->create([
            'due_date' => now()->subDays(10),
            'status' => ChargeStatus::Pending->value,
        ]);
        $overduePartially = Charge::factory()->create([
            'due_date' => now()->subDays(5),
            'status' => ChargeStatus::PartiallyPaid->value,
        ]);
        $futurePending = Charge::factory()->create([
            'due_date' => now()->addDays(10),
            'status' => ChargeStatus::Pending->value,
        ]);
        $alreadyPaid = Charge::factory()->paid()->create([
            'due_date' => now()->subDays(30),
        ]);
        $alreadyOverdue = Charge::factory()->overdue()->create([
            'due_date' => now()->subDays(20),
        ]);

        $updated = $service->markOverdueCharges();

        $this->assertSame(2, $updated);
        $this->assertSame(ChargeStatus::Overdue, $overduePending->fresh()->status);
        $this->assertSame(ChargeStatus::Overdue, $overduePartially->fresh()->status);
        $this->assertSame(ChargeStatus::Pending, $futurePending->fresh()->status);
        $this->assertSame(ChargeStatus::Paid, $alreadyPaid->fresh()->status);
        $this->assertSame(ChargeStatus::Overdue, $alreadyOverdue->fresh()->status);
    }
}
