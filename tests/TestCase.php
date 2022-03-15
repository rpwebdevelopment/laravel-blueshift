<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Rpwebdevelopment\LaravelBlueshift\ServiceProviders\ApiServiceProvider;
use Rpwebdevelopment\LaravelBlueshift\ServiceProviders\BlueshiftServiceProvider;
use Rpwebdevelopment\LaravelBlueshift\MainServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Rpwebdevelopment\\LaravelBlueshift\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            MainServiceProvider::class,
            ApiServiceProvider::class,
            BlueshiftServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-blueshift_table.php.stub';
        $migration->up();
        */
    }
}
