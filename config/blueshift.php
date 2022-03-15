<?php
// config for Rpwebdevelopment/LaravelBlueshift
return [
    'provider' => [
        'api_key' => env('BLUESHIFT_API_KEY', 'ABC123'),
        'headers' => [
            'Accept: application/json',
            'Content-Type: application/json',
        ]
    ]
];
