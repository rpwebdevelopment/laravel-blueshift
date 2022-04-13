<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Rpwebdevelopment\LaravelBlueshift\Contracts\BlueshiftCatalog;
use Rpwebdevelopment\LaravelBlueshift\Contracts\BlueshiftCustomer;
use Rpwebdevelopment\LaravelBlueshift\Contracts\BlueshiftEvent;
use Rpwebdevelopment\LaravelBlueshift\Contracts\BlueshiftUserList;
use Rpwebdevelopment\LaravelBlueshift\Services\Catalog;
use Rpwebdevelopment\LaravelBlueshift\Services\Customer;
use Rpwebdevelopment\LaravelBlueshift\Services\Event;
use Rpwebdevelopment\LaravelBlueshift\Services\UserList;

class BlueshiftServiceProvider extends ServiceProvider
{
    public array $singletons = [
        BlueshiftCustomer::class => Customer::class,
        BlueshiftCatalog::class => Catalog::class,
        BlueshiftUserList::class => UserList::class,
        BlueshiftEvent::class => Event::class,
    ];
}
