<?php

namespace Rpwebdevelopment\LaravelBlueshift\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rpwebdevelopment\LaravelBlueshift\LaravelBlueshift
 */
class LaravelBlueshift extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-blueshift';
    }
}
