<?php

namespace ArmCm\LaravelTenancyTesting;

use ArmCm\LaravelTenancyTesting\Traits\SetupDatabase;
use Illuminate\Foundation\Testing\TestCase;

abstract class LandlordTestCase extends TestCase
{
    use SetupDatabase;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->configureConnection('landlord', ':memory:');

        config(['database.default' => 'landlord']);

        $this->migrateDatabase(
            config('tenant-testing.connections.landlord'),
            config('tenant-testing.migrations.landlord'),
        );

        $this->artisan('migrate', [
            '--database' => config('tenant-testing.connections.landlord'),
            '--path' => config('tenant-testing.migrations.landlord'),
        ]);

        $tenantModelClass = config('tenant-testing.tenant_model.class');

        if (class_exists($tenantModelClass) && method_exists($tenantModelClass, 'forgetCurrent')) {
            $tenantModelClass::forgetCurrent();
        }
    }
}
