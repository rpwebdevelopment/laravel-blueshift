<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Services;

use Exception;
use Rpwebdevelopment\LaravelBlueshift\Contracts\BlueshiftCustomer;

class Customer extends Blueshift implements BlueshiftCustomer
{
    private string $ext = '/api/v1/customers';

    public function search(string $email): ?string
    {
        $response = $this->api->get($this->ext, ['email' => $email]);

        return $this->handleResponse($response);
    }

    public function get(string $uuid): ?string
    {
        $response = $this->api->get($this->ext . '/' . $uuid);

        return $this->handleResponse($response);
    }

    public function createJson(string $customer): ?string
    {
        $response = $this->api->post($this->ext, ['body' => $customer]);

        return $this->handleResponse($response);
    }

    public function createArray(array $customer): ?string
    {
        return $this->createJson(json_encode($customer));
    }

    public function bulkCreateJson(string $customers): ?string
    {
        $response = $this->api->post($this->ext . '/bulk', ['body' => $customers]);

        return $this->handleResponse($response);
    }

    public function bulkCreateArray(array $customers): ?string
    {
        $json = json_encode(['customers' => $customers]);

        return $this->createJson($json);
    }

    public function startTracking(?string $email = null, ?string $uuid = null): string
    {
        $search = $this->validateSearch($email, $uuid);
        if ($search === null) {
            throw new Exception('Email or Customer ID is required in order to start tracking');
        }

        $json = json_encode($search);
        $response = $this->api->post($this->ext . '/unforget', ['body' => $json]);

        return $this->handleResponse($response);
    }

    public function stopTracking(?string $email = null, ?string $uuid = null): string
    {
        $search = $this->validateSearch($email, $uuid);
        if ($search === null) {
            throw new Exception('Email or Customer ID is required in order to stop tracking');
        }

        $json = json_encode($search);
        $response = $this->api->post($this->ext . '/forget', ['body' => $json]);

        return $this->handleResponse($response);
    }

    public function delete(?string $email = null, ?string $uuid = null, bool $allMatching = false): string
    {
        $search = $this->validateSearch($email, $uuid);
        if ($search === null) {
            throw new Exception('Email or Customer ID is required in order to stop tracking');
        }

        $matching = $allMatching ? 'true' : 'false';
        $json = json_encode($search);
        $response = $this->api->post(
            $this->ext . '/delete?delete_all_matching_customers=' . $matching,
            ['body' => $json]
        );

        return $this->handleResponse($response);
    }

    private function validateSearch(?string $email = null, ?string $uuid = null): ?array
    {
        $search = [];
        if ($email !== null) {
            $search['email'] = $email;
        }

        if ($uuid !== null) {
            $search['customer_id'] = $uuid;
        }

        if (count($search) === 0) {
            return null;
        }

        return $search;
    }
}
