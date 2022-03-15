<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\ServiceProviders;

use Illuminate\Support\ServiceProvider;

use Rpwebdevelopment\LaravelBlueshift\Contracts\ApiInterface;
use Rpwebdevelopment\LaravelBlueshift\Services\Api\Api;

class ApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ApiInterface::class, Api::class);
        $this->app->bind(
            Api::class,
            static function (): Api {
                return new Api(
                    config('blueshift.provider.api_key'),
                    config('blueshift.provider.headers')
                );
            }
        );
    }
}
