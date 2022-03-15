<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Services;

use PHPLicengine\Api\Api;
use PHPLicengine\Api\Result;
use Rpwebdevelopment\LaravelBlueshift\Exceptions\BlueshiftClientError;
use Rpwebdevelopment\LaravelBlueshift\Exceptions\BlueshiftError;
use Rpwebdevelopment\LaravelBlueshift\Exceptions\BlueshiftServerError;

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
            throw new BlueshiftServerError($response->getErrorMessage(), $response->getResponseCode());
        }

        if ($response->isClientError()) {
            throw new BlueshiftClientError($response->getErrorMessage(), $response->getResponseCode());
        }

        if ($response->isError()) {
            throw new BlueshiftError($response->getErrorMessage(), $response->getResponseCode());
        }

        throw new BlueshiftError($response->getErrorMessage(), $response->getResponseCode());
    }
}
