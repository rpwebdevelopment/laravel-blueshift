<?php

namespace Rpwebdevelopment\LaravelBlueshift\Commands;

use Illuminate\Console\Command;

class LaravelBlueshiftCommand extends Command
{
    public $signature = 'laravel-blueshift';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
