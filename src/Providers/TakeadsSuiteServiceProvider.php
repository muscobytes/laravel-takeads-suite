<?php

namespace Muscobytes\Laravel\Takeads\Suite\Providers;

use Generator;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Muscobytes\Laravel\Takeads\Suite\Console\Commands\ImportMerchants;
use Muscobytes\Laravel\Takeads\Suite\Console\Commands\SearchCoupons;

class TakeadsSuiteServiceProvider extends ServiceProvider
{
    /**
     * Searches migrations and publishes them as assets.
     * @see https://darkghosthunter.medium.com/laravel-packages-load-or-publish-migrations-119db770c870
     *
     * @param string $directory
     * @return void
     * @throws BindingResolutionException
     */
    protected function registerMigrations(string $directory): void
    {
        if ($this->app->runningInConsole()) {
            $generator = function(string $directory): Generator {
                foreach ($this->app->make('files')->allFiles($directory) as $file) {
                    yield $file->getPathname() => $this->app->databasePath(
                        'migrations/' . now()->format('Y_m_d_His') . Str::after($file->getFilename(), '00_00_00_000000')
                    );
                }
            };

            $this->publishes(iterator_to_array($generator($directory)), 'migrations');
        }
    }


    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/takeads.php' => config_path('takeads.php'),
        ]);

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
