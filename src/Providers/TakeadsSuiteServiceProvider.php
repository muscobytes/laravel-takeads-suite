<?php

namespace Muscobytes\Laravel\Takeads\Suite\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Muscobytes\Laravel\Takeads\Suite\Console\Commands\ImportMerchants;
use Muscobytes\Laravel\Takeads\Suite\Console\Commands\SearchCoupons;
use Muscobytes\Laravel\TraitsCollection\ServiceProviders\PublishesMigrations;

class TakeadsSuiteServiceProvider extends ServiceProvider
{
    use PublishesMigrations;

    /**
     * Bootstrap any package services.
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/takeads.php' => config_path('takeads.php'),
        ]);

        $this->registerMigrations(__DIR__ . '/../../database/migrations');

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
            __DIR__ . '/../../config/takeads.php', 'takeads'
        );
    }
}
