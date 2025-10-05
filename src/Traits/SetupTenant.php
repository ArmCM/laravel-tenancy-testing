<?php

namespace ArmCm\LaravelTenancyTesting\Traits;

trait SetupTenant
{
    /**
     * @throws \Exception
     */
    public function setupTenant(): void
    {
        $this->tenant = $this->createTenant();

        if (method_exists($this->tenant, 'makeCurrent')) {
            $this->tenant->makeCurrent();
        }
    }

    private function createTenant(array $attributes = [])
    {
        $tenantModelClass = config('tenant-testing.tenant_model.class');
        $connection = config('tenant-testing.tenant_model.connection');

        if (!class_exists($tenantModelClass)) {
            throw new \Exception("Tenant model class does not exist.");
        }

        $defaults = array_merge(
            config('tenant-testing.default_tenant_attributes', []),
            ['database' => $this->tenantDatabase]
        );

        return $tenantModelClass::on($connection)->create(array_merge($defaults, $attributes));
    }
}
