<?php

namespace Muscobytes\Laravel\Takeads\Coupons\Database\Seeders;

use Illuminate\Database\Seeder;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsCategory;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsCountry;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsCoupon;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsCurrency;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsLanguage;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsMerchant;

class LocalSeeder extends Seeder
{
    public function run(): void
    {
        TakeadsCountry::factory()->count(70)->create();
        TakeadsCategory::factory()->count(120)->create();
        TakeadsCurrency::factory()->count(20)->create();
        TakeadsLanguage::factory()->count(30)->create();
        TakeadsMerchant::factory()->count(100)->create()
            ->each(function(TakeadsMerchant $merchant){
                $merchant->countries()->attach(TakeadsCountry::all()->random(rand(1, 4)));
            });
        TakeadsCoupon::factory()->count(100)->create()
            ->each(function (TakeadsCoupon $coupon) {
                $coupon->languages()->attach(TakeadsLanguage::all()->random(rand(1, 3)));
                $coupon->countries()->attach(TakeAdsCountry::all()->random(rand(1, 20)));
                $coupon->categories()->attach(TakeadsCategory::all()->random(rand(1, 2)));
            });
    }
}
