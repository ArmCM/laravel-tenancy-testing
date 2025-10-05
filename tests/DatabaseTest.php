<?php

namespace ArmCm\LaravelTenancyTesting\Tests;

use ArmCm\LaravelTenancyTesting\Tests\Fixtures\FakeTenancyTestCase;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

class DatabaseTest extends FakeTenancyTestCase
{
    #[Test]
    public function it_validate_the_landlord_database_file()
    {
        $landlordConnection = config('database.connections.' . config('tenant-testing.connections.landlord'));

        $this->assertTrue(File::exists($landlordConnection['database']));
    }

    #[Test]
    public function it_validate_the_tenant_database_file()
    {
        $tenantConnection = config('database.connections.' . config('tenant-testing.connections.tenant'));

        $this->assertTrue(File::exists($tenantConnection['database']));
    }

    #[Test]
    public function it_validated_configuration_the_landlord_database_connection()
    {
        $landlordConnection = config('database.connections.' . config('tenant-testing.connections.landlord'));

        $this->assertEquals('sqlite', $landlordConnection['driver']);
        $this->assertStringEndsWith('landlord.sqlite', $landlordConnection['database']);
        $this->assertEquals('', $landlordConnection['prefix']);
        $this->assertTrue($landlordConnection['foreign_key_constraints']);
    }

    #[Test]
    public function it_validated_configuration_the_tenant_database_connection()
    {
        $tenantConnection = config('database.connections.' . config('tenant-testing.connections.tenant'));

        $this->assertEquals('sqlite', $tenantConnection['driver']);
        $this->assertMatchesRegularExpression(
            '#/tenant_[a-f0-9\-]+\.sqlite$#',
            $tenantConnection['database']
        );
        $this->assertEquals('', $tenantConnection['prefix']);
        $this->assertTrue($tenantConnection['foreign_key_constraints']);
    }
}
