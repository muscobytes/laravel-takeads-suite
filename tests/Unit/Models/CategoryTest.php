<?php

namespace Muscobytes\Laravel\Takeads\Suite\Tests\Unit\Models;

use Muscobytes\Laravel\Takeads\Suite\Models\Category;
use Muscobytes\Laravel\Takeads\Suite\Models\Coupon;
use Muscobytes\Laravel\Takeads\Suite\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Category::class)]
class CategoryTest extends TestCase
{
    public function test_category_creation()
    {
        $external_id = 43;
        $category = Category::create([
            'external_id' => 43
        ]);
        $this->assertNotNull($category);
        $this->assertIsInt($category->external_id);
        $this->assertSame($category->external_id, $external_id);
        $this->assertEquals(1, Category::count());
    }


    public function test_category_coupon_relation()
    {
        $category = Category::create([
            'external_id' => 43
        ]);
        $this->assertEquals($category->coupons()->count(), 0);

        $coupon = Coupon::create([
            'external_id' => '0103Gkr5QEPahe6calErk',
            'is_active' => true,
            'tracking_link' => 'https://tatrck.com/h/1Hu30zX',
            'name' => 'Tendance Cadeau - -5€ sur toute la boutique à partir de 25€ d’achats',
            'code' => 'EFF5E',
            'merchant_id' => 1,
            'image_uri' => 'https://monetizeamex.com/logos_v2/90x45/7878f4bbd60eea86eee0afd69669aaa8.gif',
            'start_date' => '2023-03-08T23:00:00.000Z',
            'end_date' => '2030-01-01T00:00:00.000Z',
            'description' => 'descriptino'
        ]);

        $category->coupons()->attach($coupon);

        $this->assertEquals($category->coupons()->count(), 1);
        $this->assertEquals($category->coupons()->where('is_active', true)->count(), 1);
        $this->assertSame($category->coupons()->first()->external_id, '0103Gkr5QEPahe6calErk');
        $this->assertSame($category->coupons()->first()->code, 'EFF5E');
    }
}
