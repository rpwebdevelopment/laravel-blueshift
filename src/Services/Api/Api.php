<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Services\Api;

use Rpwebdevelopment\LaravelBlueshift\Exceptions\CurlException;

class Api
{
    protected int $_timeout = 30;
    protected bool $_verify_ssl = true;
    protected int $_verify_host = 2;
    /** @var int|bool */
    protected $curlErrno = false;
    /** @var string|bool */
    protected $curlError = false;
    /** @var string|bool */
    protected $response = false;
    protected array $request = [];
    protected array $headers = [];
    protected array $curlInfo;

    public function __construct(string $authToken, array $headers = [])
    {
        if (! function_exists('curl_init')) {
            throw new CurlException("cURL is not available. This API wrapper cannot be used.");
        }
        $headers[] = 'Authorization: Basic ' . $authToken;
        $this->headers = $headers;
    }

    public function setTimeout($timeout)
    {
        $this->_timeout = $timeout;
    }

    private function _call($url, $params = null, $headers = null, $method = "GET")
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->_verify_ssl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->_verify_host);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

        switch (strtoupper($method)) {
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

                break;
            case 'GET':
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                if (! empty($params)) {
                    $url .= '?' . http_build_query($params);
                    curl_setopt($ch, CURLOPT_URL, $url);
                }

                break;
        }

        $this->request['method'] = strtoupper($method);
        if (! empty($headers)) {
            $this->headers = array_merge($this->headers, $headers);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $this->request['headers'] = $headers;
        $this->request['params'] = $params;

        $this->response = curl_exec($ch);
        if (curl_errno($ch)) {
            $this->curlErrno = curl_errno($ch);
            $this->curlError = curl_error($ch);
            curl_close($ch);

            return;
        }
        $this->curlInfo = curl_getinfo($ch);
        curl_close($ch);

        return new Result($this->_getBody(), $this->_getHeaders(), $this->curlInfo);
    }

    private function _parseHeaders($rawHeaders)
    {
        if (! function_exists('http_parse_headers')) {
            $headers = [];
            $key = '';

            foreach (explode("\n", $rawHeaders) as $header) {
                $header = explode(':', $header, 2);
                if (isset($header[1])) {
                    if (! isset($headers[$header[0]])) {
                        $headers[$header[0]] = trim($header[1]);
                    } elseif (is_array($headers[$header[0]])) {
                        $headers[$header[0]] = array_merge($headers[$header[0]], [trim($header[1])]);
                    } else {
                        $headers[$header[0]] = array_merge([$headers[$header[0]]], [trim($header[1])]);
                    }
                    $key = $header[0];
                } else {
                    if (substr($header[0], 0, 1) == "\t") {
                        $headers[$key] .= "\r\n\t" . trim($header[0]);
                    } elseif (! $key) {
                        $headers[0] = trim($header[0]);
                    }
                }
            }

            return $headers;
        } else {
            return http_parse_headers($rawHeaders);
        }
    }

    private function _getHeaders()
    {
        return $this->_parseHeaders(substr($this->response, 0, $this->curlInfo['header_size']));
    }

    private function _getBody()
    {
        return substr($this->response, $this->curlInfo['header_size']);
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function get($url, $params = null, array $headers = [])
    {
        return $this->_call($url, $params, $headers, $method = "GET");
    }

    public function post($url, $params = null, array $headers = [])
    {
        return $this->_call($url, $params, $headers, $method = "POST");
    }

    public function delete($url, $params = null, array $headers = [])
    {
        return $this->_call($url, $params, $headers, $method = "DELETE");
    }

    public function put($url, $params = null, array $headers = [])
    {
        return $this->_call($url, $params, $headers, $method = "PUT");
    }

    public function patch($url, $params = null, array $headers = [])
    {
        return $this->_call($url, $params, $headers, $method = "PATCH");
    }

    public function getCurlInfo()
    {
        return $this->curlInfo;
    }

    public function isCurlError()
    {
        return (bool) $this->curlErrno;
    }

    public function getCurlErrno()
    {
        return $this->curlErrno;
    }

    public function getCurlError()
    {
        return $this->curlError;
    }
}
