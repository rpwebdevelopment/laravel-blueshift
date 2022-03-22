<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Services\Api;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Rpwebdevelopment\LaravelBlueshift\Exceptions\CurlException;

class Api
{
    protected string $baseUrl;
    protected array $headers = [];

    public function __construct(string $baseUrl, string $authToken, array $headers = [])
    {
        if (! function_exists('curl_init')) {
            throw new CurlException("cURL is not available. This API wrapper cannot be used.");
        }
        $headers['Authorization'] = 'Basic ' . base64_encode($authToken);
        $this->baseUrl = $baseUrl;
        $this->headers = $headers;
    }

    private function getHeaders(array $headers = []): array
    {
        $tmpHeaders = $this->headers;
        if (! empty($headers)) {
            $tmpHeaders = array_merge($this->headers, $headers);
        }

        return $tmpHeaders;
    }

    private function getUrl(string $ext): string
    {
        return $this->baseUrl . $ext;
    }

    private function getBaseRequest(array $headers = []): PendingRequest
    {
        return Http::acceptJson()
            ->withHeaders($this->getHeaders($headers));
    }

    public function get(string $ext, $params = null, array $headers = []): Response
    {
        return $this->getBaseRequest($headers)
            ->get($this->getUrl($ext), $params);
    }

    public function post(string $ext, $params = null, array $headers = []): Response
    {
        return $this->getBaseRequest($headers)
            ->post($this->getUrl($ext), $params);
    }

    public function delete(string $ext, $params = null, array $headers = []): Response
    {
        return $this->getBaseRequest($headers)
            ->delete($this->getUrl($ext), $params);
    }

    public function put(string $ext, $params = null, array $headers = []): Response
    {
        return $this->getBaseRequest($headers)
            ->put($this->getUrl($ext), $params);
    }

    public function patch(string $ext, $params = null, array $headers = []): Response
    {
        return $this->getBaseRequest($headers)
            ->patch($this->getUrl($ext), $params);
    }
}
