<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Contracts;

interface ApiInterface
{
    public function get($url, $params = null, $headers = null);

    public function post($url, $params = null, $headers = null);

    public function delete($url, $params = null, $headers = null);

    public function put($url, $params = null, $headers = null);

    public function patch($url, $params = null, $headers = null);

    public function setApiKey($api_key);

    public function setOAuth();
}
