<?php

namespace Muscobytes\Laravel\Takeads\Suite\Tests\Unit\Models;

use DateTimeInterface;
use Muscobytes\Laravel\Takeads\Suite\Models\Action;
use Muscobytes\Laravel\Takeads\Suite\Models\Country;
use Muscobytes\Laravel\Takeads\Suite\Models\Currency;
use Muscobytes\Laravel\Takeads\Suite\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Action::class)]
class TakeadsActionTest extends TestCase
{
    public function test_takeads_action_creation()
    {
        $action = Action::create([
            'external_id' => '2673d88c-84c8-4ee7-a0e7-71f83292aeab',
            'external_numeric_id' => 94241012,
            'adspace_id' => '0c181f1f-92e6-43cc-927f-d179caf2a254',
            'merchant_id' => 113533,
            'program_id' => '3b4d4c28-bb5a-45c7-8935-bb95ebbbb573',
            'status' => 'CONFIRMED',
            'sub_id' => null,
            'order_amount' => 781.14,
            'publisher_revenue' => 8.65,
            'currency_id' => Currency::firstOrCreate(['code' => 'EUR'])->first()->id,
            'type' => 'SALE',
            'order_date' => '2024-08-01T02:10:50.000Z',
            'remote_created_at' => '2024-08-01T05:07:13.928Z',
            'remote_updated_at' => '2024-10-11T19:08:09.703Z',
            'country_id' => Country::firstOrCreate(['code' => 'ES'])->first()->id,
            'click_id' => null,
            'coupon_id' => '0jYshT7wFBFhAkP2fO8Yf'
        ]);

        $this->assertInstanceOf(Action::class, $action);

        $this->assertIsString($action->external_id);
        $this->assertSame($action->external_id, '2673d88c-84c8-4ee7-a0e7-71f83292aeab');

        $this->assertIsInt($action->external_numeric_id);
        $this->assertSame($action->external_numeric_id, 94241012);

        $this->assertIsString($action->adspace_id);
        $this->assertSame($action->adspace_id, '0c181f1f-92e6-43cc-927f-d179caf2a254');

        $this->assertIsInt($action->merchant_id);
        $this->assertSame($action->merchant_id, 113533);

        $this->assertIsString($action->program_id);
        $this->assertSame($action->program_id, '3b4d4c28-bb5a-45c7-8935-bb95ebbbb573');

        $this->assertIsString($action->status);
        $this->assertSame($action->status, 'CONFIRMED');

        $this->assertNull($action->sub_id);

        $this->assertIsFloat($action->order_amount);
        $this->assertSame($action->order_amount, 781.14);

        $this->assertIsFloat($action->publisher_revenue);
        $this->assertSame($action->publisher_revenue, 8.65);

        $this->assertIsInt($action->currency_id);
        $this->assertSame($action->currency_id, 1);

        $this->assertIsString($action->type);
        $this->assertSame($action->type, 'SALE');

        $this->assertInstanceOf(DateTimeInterface::class, $action->order_date);
        $this->assertSame($action->order_date->format('Y-m-d H:i:s'), '2024-08-01 02:10:50');

        $this->assertInstanceOf(DateTimeInterface::class, $action->remote_created_at);
        $this->assertSame($action->remote_created_at->format('Y-m-d H:i:s'), '2024-08-01 05:07:13');

        $this->assertInstanceOf(DateTimeInterface::class, $action->remote_updated_at);
        $this->assertSame($action->remote_updated_at->format('Y-m-d H:i:s'), '2024-10-11 19:08:09');

        $this->assertIsInt($action->country_id);
        $this->assertSame($action->country_id, 1);

        $this->assertNull($action->sub_id);

        $this->assertIsString($action->coupon_id);
        $this->assertSame($action->coupon_id, '0jYshT7wFBFhAkP2fO8Yf');
    }
}