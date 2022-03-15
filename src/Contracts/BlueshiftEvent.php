<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Contracts;

interface BlueshiftEvent
{
    public function sendEvent(array $event): string;
}
