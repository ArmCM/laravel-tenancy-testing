<?php

namespace ArmCm\LaravelTenancyTesting\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

class FakeTenant extends Model
{
    protected $connection = 'landlord';
    protected $table = 'tenants';
    protected $guarded = [];

    public bool $isCurrent = false;

    public function makeCurrent(): void
    {
        $this->isCurrent = true;
    }

    public static function forgetCurrent() {}
}
