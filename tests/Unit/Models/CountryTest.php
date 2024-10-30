<?php

namespace Muscobytes\Laravel\Takeads\Suite\Tests\Unit\Models;

use Muscobytes\Laravel\Takeads\Suite\Models\Country;
use Muscobytes\Laravel\Takeads\Suite\Providers\TakeadsSuiteServiceProvider;
use Muscobytes\Laravel\Takeads\Suite\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Country::class)]
#[CoversClass(TakeadsSuiteServiceProvider::class)]
class CountryTest extends TestCase
{
    public function test_country_creation()
    {
        /** @var Country $country */
        $country = Country::create([
            'code' => 'RU'
        ]);
        $this->assertInstanceOf(Country::class, $country);
        $this->assertEquals('RU', $country->code);
    }
}