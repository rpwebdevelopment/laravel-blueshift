<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Rpwebdevelopment\LaravelBlueshift\Contracts\BlueshiftCatalog;
use Rpwebdevelopment\LaravelBlueshift\Contracts\BlueshiftCustomer;
use Rpwebdevelopment\LaravelBlueshift\Contracts\BlueshiftUserList;
use Rpwebdevelopment\LaravelBlueshift\Services\Catalog;
use Rpwebdevelopment\LaravelBlueshift\Services\Customer;
use Rpwebdevelopment\LaravelBlueshift\Services\UserList;

class BlueshiftServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BlueshiftCustomer::class, Customer::class);
        $this->app->singleton(BlueshiftCatalog::class, Catalog::class);
        $this->app->singleton(BlueshiftUserList::class, UserList::class);
    }
}
