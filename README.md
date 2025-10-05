![Banner](https://banners.beyondco.de/Laravel%20Tenancy%20Testing%20.png?theme=light&packageManager=composer+require&packageName=armcm%2Flaravel-tenancy-testing&pattern=squares&style=style_1&description=Testing+helper+for+Spatie+Laravel+Multitenancy+with+automatic+database+isolation&md=1&showWatermark=1&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg&widths=200&heights=auto)

[![Total Downloads](https://img.shields.io/packagist/dt/armcm/laravel-tenancy-testing?style=for-the-badge&color=%237CB342)](https://packagist.org/packages/armcm/laravel-tenancy-testing)
[![run-tests](https://github.com/ArmCM/laravel-tenancy-testing/actions/workflows/main.yml/badge.svg)](https://github.com/ArmCM/laravel-tenancy-testing/actions/workflows/main.yml)

Testing utilities for Laravel multitenancy applications. Provides a comprehensive base test case with automatic tenant database isolation, configuration management, and helper methods to simplify testing in multi-tenant environments built with [Spatie Laravel Multitenancy](https://github.com/spatie/laravel-multitenancy).

## Installation

You can install the package via composer:

| Laravel | PHP  | Version |
|---------|------|---------|
| 10, 11  | 8.1+ | 1.0.0   |

```bash
composer require armcm/laravel-tenancy-testing
```

## Usage

Extend the `TenancyTestCase` class in your test classes instead of Laravel's default TestCase:

```php
<?php

namespace Tests\Feature;

use ArmCm\LaravelTenancyTesting\TenancyTestCase;
use App\Models\User;

class UserTest extends TenancyTestCase
{
    /** @test */
    public function it_creates_users_in_tenant_context()
    {
        // The tenant is automatically set up and active
        $user = User::factory()->create([
            'name' => 'John Doe',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
        ], 'tenant');
    }
}
```

### What Happens Automatically
When you extend `TenancyTestCase`, the following is handled for you:

1. Landlord database is created with a fresh SQLite database
2. Tenant database is created with isolated SQLite database
3. Migrations are run automatically for both databases
4. A test tenant is created and made current
5. Configuration is set up correctly for multitenancy
6. Cleanup happens automatically after each test

### Testing Landlord Context
You can also test landlord-specific functionality:

```php
<?php

namespace Tests\Feature;

use ArmCm\LaravelTenancyTesting\LandlordTestCase;
use Modules\Landlord\Models\Tenant;

class TenantTest extends LandlordTestCase
{
    /** @test */
    public function it_creates_tenants_in_landlord_context()
    {
        // The tenant is automatically set up and active
        $tenant = Tenant::factory()->create([
            'name' => 'Fake inc',
        ]);

        $this->assertDatabaseHas('tenants', [
            'name' => 'Fake inc',
        ], 'landlord');
    }
}
```
## Configuration

### Publishing Configuration File
You can publish the configuration file to customize the package behavior:
The package uses the following configuration file to override:

```shell
php artisan vendor:publish --provider="ArmCm\LaravelTenancyTesting\ServiceProvider" --tag=config
```
This will create a `config/tenancy-testing.php` file with the following options:

```php
<?php

return [
    'connections' => [
        'landlord' => 'landlord',
        'tenant' => 'tenant',
    ],

    'migrations' => [
        'landlord' => '',
        'tenant' => 'database/migrations',
    ],

    'tenant_model' => [
        'class' => '',
        'connection' => 'landlord',
    ],

    'database' => [
        'driver' => 'sqlite',
        'temp_directory' => null,
        'foreign_key_constraints' => true,
    ],

    'default_tenant_attributes' => [
        'name' => 'Test Tenant',
        'domain' => 'test.localhost',
    ],
];
```

### Registering the Service Provider
Laravel 11+ Add the service provider to your `bootstrap/providers.php`:

```php
<?php

return [
    App\Providers\AppServiceProvider::class,
    ArmCm\LaravelTenancyTesting\ServiceProvider::class,
];
```

Laravel 10 Add the service provider to your `config/app.php`:

```php
'providers' => [
    // Other Service Providers...
    
    ArmCm\LaravelTenancyTesting\ServiceProvider::class,
],
```
### Using Custom Tenant Model
If you have a custom tenant model: `config/tenancy-testing.php`
```php
'tenant_model' => [
'class' => \App\Models\CustomTenant::class,
'connection' => 'landlord',
],
```

## Requirements

- PHP 8.1 or higher
- Laravel 10.x or 11.x
- Spatie Laravel Multitenancy package

## Testing
```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

-   [Armando Monreal](https://github.com/ArmCM)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
