<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Contracts;

interface BlueshiftCustomer
{
    public function search(string $email): ?string;

    public function get(string $uuid): ?string;

    public function createJson(string $customer): ?string;

    public function createArray(array $customer): ?string;

    public function bulkCreateJson(string $customers): ?string;

    public function bulkCreateArray(array $customers): ?string;

    public function manageCustomerSubscriptions(
        ?string $email = null,
        ?string $uuid = null,
        bool $unsubscribedEmail = false,
        bool $unsubscribedPush = false,
        bool $unsubscribedSms = false
    ): string;

    public function unsubscribeCustomerFromEmail(?string $email = null, ?string $uuid = null): string;

    public function unsubscribeCustomerFromSms(?string $email = null, ?string $uuid = null): string;

    public function unsubscribeCustomerFromPush(?string $email = null, ?string $uuid = null): string;

    public function unsubscribeCustomerFromAll(?string $email = null, ?string $uuid = null): string;

    public function manageEmailListSubscriptions(
        array $emailList,
        ?bool $unsubscribedEmail = null,
        ?bool $unsubscribedPush = null,
        ?bool $unsubscribedSms = null
    ): string;

    public function startTracking(?string $email = null, ?string $uuid = null): string;

    public function stopTracking(?string $email = null, ?string $uuid = null): string;

    public function delete(?string $email = null, ?string $uuid = null, bool $allMatching = false): string;
}
