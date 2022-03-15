<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Contracts;

interface BlueshiftUserList
{
    public function createList(string $name, string $description, string $source = 'email'): string;

    public function addUserToList(int $listId, string $identifierKey, string $identifierValue): string;

    public function removeUserFromList(int $listId, string $identifierKey, string $identifierValue): string;
}
