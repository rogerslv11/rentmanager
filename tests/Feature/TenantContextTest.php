<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Support\TenantContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantContextTest extends TestCase
{
    use RefreshDatabase;

    public function test_set_and_get_organization(): void
    {
        $org = Organization::factory()->create();

        TenantContext::set($org);

        $this->assertSame($org->id, TenantContext::id());
        $this->assertTrue(app()->has('organization'));
        $this->assertSame($org->id, app('organization')->id);
    }

    public function test_get_returns_null_when_no_context(): void
    {
        $this->assertNull(TenantContext::get());
        $this->assertNull(TenantContext::id());
    }
}
