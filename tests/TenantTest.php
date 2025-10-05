<?php

use ArmCm\LaravelTenancyTesting\Tests\Fixtures\FakeTenancyTestCase;
use PHPUnit\Framework\Attributes\Test;

class TenantTest extends FakeTenancyTestCase
{
    #[Test]
    public function it_creates_a_tenant_record_in_landlord_database()
    {
        $tenantModelClass = config('tenant-testing.tenant_model.class');

        $tenant = $tenantModelClass::first();

        $this->assertNotNull($tenant);
        $this->assertDatabaseHas('tenants', ['id' => $tenant->id], 'landlord');
    }

    #[Test]
    public function it_throws_exception_if_model_tenant_not_exist()
    {
        config()->set('tenant-testing.tenant_model.class', '');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Tenant model class does not exist.');

        $this->setupTenant();
    }
}
