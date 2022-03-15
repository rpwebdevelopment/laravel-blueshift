<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Services;

use Exception;
use Rpwebdevelopment\LaravelBlueshift\Contracts\BlueshiftEvent;

class Event extends Blueshift implements Blueshiftevent
{
    private string $baseUrl = 'https://api.getblueshift.com/api/v1/event';

    public function sendEvent(array $event): string
    {
        if (! isset($event['customer_id']) || ! isset($event['event'])) {
            throw new Exception('"customer_id" and "event" keys are required');
        }
        $response = $this->api->post($this->baseUrl, ['body' => json_encode($event)]);

        return $this->handleResponse($response);
    }
}
