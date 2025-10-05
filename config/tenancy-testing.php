<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Specify the connection names for landlord and tenant databases.
    | These should match your multitenancy configuration.
    |
    */

    'connections' => [
        'landlord' => 'landlord',
        'tenant' => 'tenant',
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Paths
    |--------------------------------------------------------------------------
    |
    | Define the paths to your migration files for both landlord and tenant.
    | Leave empty string for landlord if using default Laravel migrations.
    |
    */

    'migrations' => [
        'landlord' => '',
        'tenant' => 'database/migrations',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tenant Model Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the tenant model class and its database connection.
    | By default, it uses Spatie's Tenant model.
    |
    */

    'tenant_model' => [
        'class' => 'Spatie\\Multitenancy\\Models\\Tenant',
        'connection' => 'landlord',
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the database driver and behavior for test databases.
    | The temp_directory is where SQLite databases will be created.
    |
    */

    'database' => [
        'driver' => 'sqlite',
        'temp_directory' => null,
        'foreign_key_constraints' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Tenant Attributes
    |--------------------------------------------------------------------------
    |
    | Default attributes used when creating test tenants.
    | You can override these in individual tests.
    |
    */

    'default_tenant_attributes' => [
        'name' => 'Test Tenant',
        'domain' => 'test.localhost',
    ],
];
