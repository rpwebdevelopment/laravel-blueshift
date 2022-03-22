<?php
// config for Rpwebdevelopment/LaravelBlueshift
return [
    'provider' => [
        'api_key' => env('BLUESHIFT_API_KEY', ''),
        'base_url' => env('BLUESHIFT_BASE_URL', 'https://api.eu.getblueshift.com'),
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]
    ]
];
