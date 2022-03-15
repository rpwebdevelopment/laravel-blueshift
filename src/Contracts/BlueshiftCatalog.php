<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Contracts;

interface BlueshiftCatalog
{
    public function createCatalog(string $name): string;

    public function getList(): string;

    public function addItems(string $uuid, array $items): string;

    public function getCatalog(string $uuid): string;
}
