<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Services;

use Rpwebdevelopment\LaravelBlueshift\Contracts\BlueshiftCustomer;
use Rpwebdevelopment\LaravelBlueshift\Exceptions\BlueshiftValidationException;

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

        return $this->bulkCreateJson($json);
    }

    public function manageCustomerSubscriptions(
        ?string $email = null,
        ?string $uuid = null,
        bool $unsubscribedEmail = false,
        bool $unsubscribedPush = false,
        bool $unsubscribedSms = false
    ): string {
        $customer = $this->validateCustomer($email, $uuid);
        $subscriptionStates = $this->getSubscriptionStateArray($unsubscribedEmail, $unsubscribedPush, $unsubscribedSms);

        return $this->createArray(array_merge($customer, $subscriptionStates));
    }

    public function unsubscribeCustomerFromEmail(?string $email = null, ?string $uuid = null): string
    {
        $customer = $this->validateCustomer($email, $uuid);

        $customer['unsubscribed'] = true;

        return $this->createArray($customer);
    }

    public function unsubscribeCustomerFromSms(?string $email = null, ?string $uuid = null): string
    {
        $customer = $this->validateCustomer($email, $uuid);

        $customer['unsubscribed_sms'] = true;

        return $this->createArray($customer);
    }

    public function unsubscribeCustomerFromPush(?string $email = null, ?string $uuid = null): string
    {
        $customer = $this->validateCustomer($email, $uuid);

        $customer['unsubscribed_push'] = true;

        return $this->createArray($customer);
    }

    public function unsubscribeCustomerFromAll(?string $email = null, ?string $uuid = null): string
    {
        return $this->manageCustomerSubscriptions($email, $uuid, true, true, true);
    }

    public function manageEmailListSubscriptions(
        array $emailList,
        ?bool $unsubscribedEmail = null,
        ?bool $unsubscribedPush = null,
        ?bool $unsubscribedSms = null
    ): string {
        if (count($emailList) > 50) {
            throw BlueshiftValidationException::rateLimitExceeded();
        }
        $subscriptionStates = $this->getSubscriptionStateArray($unsubscribedEmail, $unsubscribedPush, $unsubscribedSms);
        $mapped = array_map(fn ($item) => array_merge(['email' => $item], $subscriptionStates), $emailList);

        return $this->bulkCreateArray($mapped);
    }

    public function startTracking(?string $email = null, ?string $uuid = null): string
    {
        $customer = $this->validateCustomer($email, $uuid);

        $json = json_encode($customer);
        $response = $this->api->post($this->ext . '/unforget', ['body' => $json]);

        return $this->handleResponse($response);
    }

    public function stopTracking(?string $email = null, ?string $uuid = null): string
    {
        $customer = $this->validateCustomer($email, $uuid);

        $json = json_encode($customer);
        $response = $this->api->post($this->ext . '/forget', ['body' => $json]);

        return $this->handleResponse($response);
    }

    public function delete(?string $email = null, ?string $uuid = null, bool $allMatching = false): string
    {
        $customer = $this->validateCustomer($email, $uuid);

        $matching = $allMatching ? 'true' : 'false';
        $json = json_encode($customer);
        $response = $this->api->post(
            $this->ext . '/delete?delete_all_matching_customers=' . $matching,
            ['body' => $json]
        );

        return $this->handleResponse($response);
    }

    private function validateCustomer(?string $email = null, ?string $uuid = null): ?array
    {
        $search = [];
        if ($email !== null) {
            $search['email'] = $email;
        }

        if ($uuid !== null) {
            $search['customer_id'] = $uuid;
        }

        if (count($search) === 0) {
            throw BlueshiftValidationException::invalidCustomerIdentifier();
        }

        return $search;
    }

    private function getSubscriptionStateArray(
        ?bool $unsubscribedEmail = null,
        ?bool $unsubscribedPush = null,
        ?bool $unsubscribedSms = null
    ): array {
        $states = [];
        if ($unsubscribedEmail !== null) {
            $states['unsubscribed'] = $unsubscribedEmail;
        }

        if ($unsubscribedPush !== null) {
            $states['unsubscribed_push'] = $unsubscribedPush;
        }

        if ($unsubscribedSms !== null) {
            $states['unsubscribed_sms'] = $unsubscribedSms;
        }

        if (empty($states)) {
            throw BlueshiftValidationException::subscriptionStateRequired();
        }

        return $states;
    }
}
