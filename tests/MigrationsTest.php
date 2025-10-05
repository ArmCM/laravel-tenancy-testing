<?php

namespace ArmCm\LaravelTenancyTesting\Tests;

use ArmCm\LaravelTenancyTesting\Tests\Fixtures\FakeTenancyTestCase;
use PHPUnit\Framework\Attributes\Test;

class MigrationsTest extends FakeTenancyTestCase
{
    #[Test]
    public function it_runs_migrations_on_landlord_database()
    {
        $this->assertTrue(\Schema::connection('landlord')->hasTable('tenants'));
    }

    #[Test]
    public function it_runs_migrations_on_tenant_database()
    {
        $this->assertTrue(\Schema::connection('tenant')->hasTable('users'));
    }

    #[Test]
    public function it_throws_exception_if_directory_not_exist()
    {
        config()->set('tenant-testing.migrations.landlord', 'invalid-directory');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Migration path does not exist: invalid-directory');

        $this->setupDatabases();
    }

    #[Test]
    public function it_throws_exception_if_no_migrations_exist()
    {
        $emptyPath = sys_get_temp_dir() . '/empty_migrations_' . uniqid();
        \Illuminate\Support\Facades\File::ensureDirectoryExists($emptyPath);

        config()->set('tenant-testing.migrations.landlord', $emptyPath);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("No migration files found in: {$emptyPath}");

        $this->setupDatabases();
    }
}
