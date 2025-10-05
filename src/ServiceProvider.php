<?php

namespace ArmCm\LaravelTenancyTesting;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/tenancy-testing.php' => config_path('tenant-testing.php'),
        ], 'config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/tenancy-testing.php',
            'tenant-testing'
        );
    }
}
