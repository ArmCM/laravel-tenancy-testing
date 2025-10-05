<?php

namespace ArmCm\LaravelTenancyTesting\Traits;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

Trait SetupDatabase
{
    protected string $landlordDatabase;
    protected string $tenantDatabase;

    /**
     * @throws Exception
     */
    public function setupDatabases(): void
    {
        $this->landlordDatabase = $this->makeDatabase('landlord');
        $this->tenantDatabase = $this->makeDatabase('tenant_' . Str::uuid());

        $this->configureConnection(
            config('tenant-testing.connections.landlord'),
            $this->landlordDatabase
        );

        $this->configureConnection(
            config('tenant-testing.connections.tenant'),
            $this->tenantDatabase
        );

        $this->migrateDatabase(
            config('tenant-testing.connections.landlord'),
            config('tenant-testing.migrations.landlord')
        );

        $this->migrateDatabase(
            config('tenant-testing.connections.tenant'),
            config('tenant-testing.migrations.tenant')
        );
    }

    private function makeDatabase(string $name): string
    {
        $tempDir = config('tenant-testing.database.temp_directory') ?: sys_get_temp_dir();
        $path = $tempDir . "/{$name}.sqlite";

        if (File::exists($path)) {
            File::delete($path);
        }

        File::ensureDirectoryExists(dirname($path));
        File::put($path, '');

        return $path;
    }

    private function migrateDatabase(string $connection, string $path): void
    {
        if (!File::exists($path)) {
            throw new \Exception("Migration path does not exist: {$path}");
        }

        $files = File::files($path);

        if (empty($files)) {
            throw new \Exception("No migration files found in: {$path}");
        }

        $this->artisan('migrate:fresh', [
            '--database' => $connection,
            '--path' => $path,
            '--realpath' => true,
        ])->assertExitCode(0);
    }

    private function configureConnection(string $name, string $path): void
    {
        $driver = config('tenant-testing.database.driver', 'sqlite');
        $foreignKeyConstraints = config('tenant-testing.database.foreign_key_constraints', true);

        Config::set("database.connections.{$name}", [
            'driver' => $driver,
            'database' => $path,
            'prefix' => '',
            'foreign_key_constraints' => $foreignKeyConstraints,
        ]);
    }
}
