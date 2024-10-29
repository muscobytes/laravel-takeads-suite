<?php

namespace Muscobytes\Laravel\Takeads\Suite\Database\Seeders;

use Illuminate\Database\Seeder;
use Muscobytes\Laravel\Takeads\Suite\Models\TakeadsCategory;
use Muscobytes\Laravel\Takeads\Suite\Models\TakeadsCountry;
use Muscobytes\Laravel\Takeads\Suite\Models\TakeadsCoupon;
use Muscobytes\Laravel\Takeads\Suite\Models\TakeadsCurrency;
use Muscobytes\Laravel\Takeads\Suite\Models\TakeadsLanguage;
use Muscobytes\Laravel\Takeads\Suite\Models\TakeadsMerchant;

class DatabaseSeeder extends Seeder
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
