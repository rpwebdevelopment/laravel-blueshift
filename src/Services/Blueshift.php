<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Services;

use PHPLicengine\Api\Api;
use PHPLicengine\Api\Result;

abstract class Blueshift
{
    protected Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    protected function handleResponse(Result $response): string
    {
        if ($response->isOk()) {
            return $response->getBody();
        }

        if ($response->isServerError()) {
            throw new \Exception('Blueshift server error');
        }

        if ($response->isError()) {
            throw new \Exception($response->getErrorMessage());
        }

        throw new \Exception('An unexpected error has occurred');
    }
}
