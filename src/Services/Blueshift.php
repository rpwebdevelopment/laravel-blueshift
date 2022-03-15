<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Services;

use Rpwebdevelopment\LaravelBlueshift\Exceptions\BlueshiftClientError;
use Rpwebdevelopment\LaravelBlueshift\Exceptions\BlueshiftError;
use Rpwebdevelopment\LaravelBlueshift\Exceptions\BlueshiftServerError;
use Rpwebdevelopment\LaravelBlueshift\Services\Api\Api;
use Rpwebdevelopment\LaravelBlueshift\Services\Api\Result;

abstract class Blueshift
{
    protected Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    protected function handleResponse(Result $result): string
    {
        if ($result->isOk()) {
            return $result->getBody();
        }

        if ($result->isServerError()) {
            throw new BlueshiftServerError($result->getErrorMessage(), $result->getResponseCode());
        }

        if ($result->isClientError()) {
            throw new BlueshiftClientError($result->getBody(), $result->getResponseCode());
        }

        if ($result->isError()) {
            throw new BlueshiftError($result->getErrorMessage(), $result->getResponseCode());
        }

        throw new BlueshiftError($result->getErrorMessage(), $result->getResponseCode());
    }
}
