<?php

namespace Muscobytes\Laravel\Takeads\Suite\Database\Seeders;

use Illuminate\Database\Seeder;
use Muscobytes\Laravel\Takeads\Suite\Models\Category;
use Muscobytes\Laravel\Takeads\Suite\Models\Country;
use Muscobytes\Laravel\Takeads\Suite\Models\Coupon;
use Muscobytes\Laravel\Takeads\Suite\Models\Currency;
use Muscobytes\Laravel\Takeads\Suite\Models\Language;
use Muscobytes\Laravel\Takeads\Suite\Models\Merchant;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Country::factory()->count(70)->create();
        Category::factory()->count(120)->create();
        Currency::factory()->count(20)->create();
        Language::factory()->count(30)->create();
        Merchant::factory()->count(100)->create()
            ->each(function(Merchant $merchant){
                $merchant->countries()->attach(Country::all()->random(rand(1, 4)));
            });
        Coupon::factory()->count(100)->create()
            ->each(function (Coupon $coupon) {
                $coupon->languages()->attach(Language::all()->random(rand(1, 3)));
                $coupon->countries()->attach(Country::all()->random(rand(1, 20)));
                $coupon->categories()->attach(Category::all()->random(rand(1, 2)));
            });
    }
}
