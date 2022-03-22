<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Services;

use Illuminate\Http\Client\Response;
use Rpwebdevelopment\LaravelBlueshift\Exceptions\BlueshiftClientError;
use Rpwebdevelopment\LaravelBlueshift\Exceptions\BlueshiftError;
use Rpwebdevelopment\LaravelBlueshift\Exceptions\BlueshiftServerError;
use Rpwebdevelopment\LaravelBlueshift\Services\Api\Api;

abstract class Blueshift
{
    protected Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    protected function handleResponse(Response $response): string
    {
        if ($response->ok()) {
            return $response->body();
        }

        if ($response->serverError()) {
            throw new BlueshiftServerError($response->body(), $response->status());
        }

        if ($response->clientError()) {
            throw new BlueshiftClientError($response->body(), $response->status());
        }

        if ($response->failed()) {
            throw new BlueshiftError($response->body(), $response->status());
        }

        throw new BlueshiftError($response->body(), $response->status());
    }
}
