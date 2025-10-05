<?php

namespace ArmCm\LaravelTenancyTesting;

use ArmCm\LaravelTenancyTesting\Traits\SetupConfiguration;
use ArmCm\LaravelTenancyTesting\Traits\SetupDatabase;
use ArmCm\LaravelTenancyTesting\Traits\SetupTenant;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\File;

abstract class TenancyTestCase extends TestCase
{
    use SetupDatabase, SetupConfiguration, SetupTenant;

    private $tenant;
    protected bool $setupTenant = true;

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
