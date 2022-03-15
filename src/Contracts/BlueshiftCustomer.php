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

    public function startTracking(?string $email = null, ?string $uuid = null): string;

    public function stopTracking(?string $email = null, ?string $uuid = null): string;

    public function delete(?string $email = null, ?string $uuid = null, bool $allMatching = false): string;
}
