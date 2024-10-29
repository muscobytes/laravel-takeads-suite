<?php

namespace Muscobytes\Laravel\Takeads\Suite\Tests;

use Muscobytes\Laravel\Takeads\Suite\Providers\TakeadsSuiteServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    protected function getPackageProviders($app): array
    {
        return [
            TakeadsSuiteServiceProvider::class
        ];
    }


    protected function getEnvironmentSetUp($app): void
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate',
            ['--database' => 'testbench'])->run();
    }
}