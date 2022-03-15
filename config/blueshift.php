<?php
// config for Rpwebdevelopment/LaravelBlueshift
return [
    'provider' => [
        'api_key' => env('BLUESHIFT_API_KEY', ''),
        'curl_options' => [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]
    ]
];
