<?php

namespace Muscobytes\Laravel\Takeads\Coupons\Providers;

use Illuminate\Support\ServiceProvider;
use Muscobytes\Laravel\Takeads\Coupons\Console\Commands\ImportMerchants;
use Muscobytes\Laravel\Takeads\Coupons\Console\Commands\SearchCoupons;

class TakeadsCouponsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/takeads-coupons.php' => config_path('takeads-coupons.php'),
        ]);

        /**
         * Implement this after package will be ready
         * https://darkghosthunter.medium.com/laravel-packages-load-or-publish-migrations-119db770c870
         */
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                SearchCoupons::class,
                ImportMerchants::class
            ]);
        }
    }


    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/takeads-coupons.php', 'takeads-coupons'
        );
    }
}
