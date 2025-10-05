<?php

namespace ArmCm\LaravelTenancyTesting\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

class FakeUser extends Model
{
    protected $connection = 'tenant';
    protected $table = 'users';
    protected $guarded = [];

    public bool $isCurrent = false;

    public function makeCurrent(): void
    {
        $this->isCurrent = true;
    }

    public static function forgetCurrent() {}
}
