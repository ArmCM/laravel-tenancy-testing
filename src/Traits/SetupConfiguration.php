<?php

namespace ArmCm\LaravelTenancyTesting\Traits;

use Illuminate\Support\Facades\Config;

trait SetupConfiguration
{
    public function setupConfigs(): void
    {
        Config::set([
            'multitenancy.landlord_database_connection_name' => config('tenant-testing.connections.landlord'),
            'multitenancy.tenant_database_connection_name' => config('tenant-testing.connections.tenant'),
            'database.default' => config('tenant-testing.connections.tenant'),
        ]);

        $tenantModelClass = config('tenant-testing.tenant_model.class');

        if (class_exists($tenantModelClass) && method_exists($tenantModelClass, 'forgetCurrent')) {
            $tenantModelClass::forgetCurrent();
        }
    }
}
