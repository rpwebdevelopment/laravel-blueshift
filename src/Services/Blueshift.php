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

    protected function handleResponse(Result $result): string
    {
        if ($result->isOk()) {
            return $this->getResponse($result);
        }

        if ($result->isServerError()) {
            throw new BlueshiftServerError($this->getErrorMessage($result), $result->getResponseCode());
        }

        if ($result->isClientError()) {
            throw new BlueshiftClientError($this->getErrorMessage($result), $result->getResponseCode());
        }

        if ($result->isError()) {
            throw new BlueshiftError($this->getErrorMessage($result), $result->getResponseCode());
        }

        throw new BlueshiftError($this->getErrorMessage($result), $result->getResponseCode());
    }

    private function getResponse(Result $result)
    {
        if (method_exists($result, 'getBody')) {
            return $result->getBody();
        }

        if (method_exists($result, 'getResponse')) {
            return $result->getResponse();
        }
    }

    private function getErrorMessage(Result $result)
    {
        if (method_exists($result, 'getErorrMessage')) {
            return $result->getErrorMessage();
        }

        if (method_exists($result, 'getBody')) {
            return $result->getBody();
        }

        if (method_exists($result, 'getResponse')) {
            return $result->getResponse();
        }

        return 'An error has occurred';
    }
}
