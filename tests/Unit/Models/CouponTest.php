<?php

namespace Muscobytes\Laravel\Takeads\Suite\Tests\Unit\Models;

use DateTimeInterface;
use Muscobytes\Laravel\Takeads\Suite\Models\Coupon;
use Muscobytes\Laravel\Takeads\Suite\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Coupon::class)]
class CouponTest extends TestCase
{
    public function test_coupon_model_creation()
    {
        $coupon = Coupon::create([
            'external_id' => '003vzm1sl12i4vxnJkk7O',
            'is_active' => true,
            'tracking_link' => 'https://tatrck.com/h/1Hu',
            'name' => '5€ sur toute la boutique à partir de 25€ d’achats',
            'code' => 'EFF5E',
            'merchant_id' => 202544,
            'image_uri' => 'https://monetizeamex.com/123',
            'start_date' => '2023-03-08T23:00:00.000Z',
            'end_date' => '2030-01-01T00:00:00.000Z',
            'description' => 'Description and other conditions'
        ]);

        $this->assertInstanceOf(Coupon::class, $coupon);

        $this->assertIsString($coupon->external_id);
        $this->assertEquals('003vzm1sl12i4vxnJkk7O', $coupon->external_id);

        $this->assertIsBool($coupon->is_active);
        $this->assertTrue($coupon->is_active);

        $this->assertIsString($coupon->tracking_link);
        $this->assertSame('https://tatrck.com/h/1Hu', $coupon->tracking_link);

        $this->assertIsString($coupon->name);
        $this->assertSame('5€ sur toute la boutique à partir de 25€ d’achats', $coupon->name);

        $this->assertIsInt($coupon->merchant_id);
        $this->assertSame(202544, $coupon->merchant_id);

        $this->assertIsString($coupon->image_uri);
        $this->assertSame('https://monetizeamex.com/123', $coupon->image_uri);

        $this->assertInstanceOf(DateTimeInterface::class, $coupon->start_date);
        $this->assertSame('2023-03-08 23:00:00', $coupon->start_date->format('Y-m-d H:i:s'));

        $this->assertInstanceOf(DateTimeInterface::class, $coupon->end_date);
        $this->assertSame('2030-01-01 00:00:00', $coupon->end_date->format('Y-m-d H:i:s'));
    }
}
