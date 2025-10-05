<?php

namespace ArmCm\LaravelTenancyTesting\Tests\Fixtures;

use ArmCm\LaravelTenancyTesting\Traits\SetupConfiguration;
use ArmCm\LaravelTenancyTesting\Traits\SetupDatabase;
use ArmCm\LaravelTenancyTesting\Traits\SetupTenant;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase;

abstract class FakeTenancyTestCase extends TestCase
{
    use SetupDatabase, SetupConfiguration, SetupTenant;

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('tenant-testing.connections.landlord', 'landlord');
        $app['config']->set('tenant-testing.connections.tenant', 'tenant');

        $landlordPath = realpath(__DIR__ . '/../database/migrations/landlord');
        $tenantPath = realpath(__DIR__ . '/../database/migrations/tenant');

        $app['config']->set('tenant-testing.migrations.landlord', $landlordPath);
        $app['config']->set('tenant-testing.migrations.tenant', $tenantPath);

        $app['config']->set('tenant-testing.database.temp_directory', sys_get_temp_dir());
        $app['config']->set('tenant-testing.database.driver', 'sqlite');
        $app['config']->set('tenant-testing.database.foreign_key_constraints', true);

        $app['config']->set('tenant-testing.tenant_model.class', FakeTenant::class);
        $app['config']->set('tenant-testing.tenant_model.connection', 'landlord');

        $app['config']->set('tenant-testing.default_tenant_attributes.name', 'Test Tenant');
        $app['config']->set('tenant-testing.default_tenant_attributes.domain', 'localhost.test');
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setupDatabases();
        $this->setupConfigs();
        $this->setupTenant();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        File::delete([$this->landlordDatabase, $this->tenantDatabase]);
    }
}
