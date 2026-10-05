<?php

namespace Tests\Feature;

use App\Enums\ContractStatus;
use App\Enums\MaintenanceStatus;
use App\Models\Charge;
use App\Models\Contract;
use App\Models\MaintenanceRequest;
use App\Services\PayoutCalculationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayoutCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_maintenance_is_not_multiplied_by_number_of_payments_in_period(): void
    {
        $contract = Contract::factory()->create([
            'status' => ContractStatus::Active->value,
            'rent_amount' => 1000,
            'admin_fee_percent' => 10,
            'admin_fee_fixed' => 0,
        ]);

        Charge::factory()->paid()->create([
            'contract_id' => $contract->id,
            'property_id' => $contract->property_id,
            'rent_amount' => 1000,
            'total_amount' => 1000,
            'paid_at' => now()->subDays(20),
        ]);
        Charge::factory()->paid()->create([
            'contract_id' => $contract->id,
            'property_id' => $contract->property_id,
            'rent_amount' => 1000,
            'total_amount' => 1000,
            'paid_at' => now()->subDays(15),
        ]);
        Charge::factory()->paid()->create([
            'contract_id' => $contract->id,
            'property_id' => $contract->property_id,
            'rent_amount' => 1000,
            'total_amount' => 1000,
            'paid_at' => now()->subDays(10),
        ]);

        MaintenanceRequest::factory()->create([
            'property_id' => $contract->property_id,
            'final_cost' => 500,
            'completed_at' => now()->subDays(5),
            'status' => MaintenanceStatus::Completed->value,
        ]);

        $service = app(PayoutCalculationService::class);
        $result = $service->calculateForOwner(
            $contract->owner_id,
            now()->subMonth(),
            now(),
        );

        $this->assertSame(3000.0, $result['gross_amount']);
        $this->assertSame(500.0, $result['maintenance_amount']);
        $this->assertSame(300.0, $result['admin_fee']);
        $this->assertSame(2200.0, $result['net_amount']);
    }
}
