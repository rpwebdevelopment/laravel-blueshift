<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MainServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-blueshift')
            ->hasConfigFile();
    }
}
