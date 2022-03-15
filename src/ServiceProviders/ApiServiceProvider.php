<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use PHPLicengine\Api\Api;
use Rpwebdevelopment\LaravelBlueshift\Contracts\ApiInterface;

class ApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ApiInterface::class, Api::class);
        $this->app->bind(
            Api::class,
            static function (): Api {
                $curlOptions = (array)config()->get('blueshift.provider.curl_options', []);
                $bitlyApi = new Api(config('blueshift.provider.api_key'));
                if (! empty($curlOptions)) {
                    $bitlyApi->setCurlCallback(
                    /** @param resource $ch */
                        static function ($ch) use ($curlOptions): void {
                            foreach ($curlOptions as $curlOption => $optionValue) {
                                curl_setopt($ch, $curlOption, $optionValue);
                            }
                        }
                    );
                }

                return $bitlyApi;
            }
        );
    }
}
