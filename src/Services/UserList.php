<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Services;

use Exception;
use Rpwebdevelopment\LaravelBlueshift\Contracts\BlueshiftUserList;

class UserList extends Blueshift implements BlueshiftUserList
{
    private string $ext = '/api/v1/custom_user_lists';
    private array $identifiers = ['customer_id', 'email'];

    public function createList(string $name, string $description, string $source = 'email'): string
    {
        $this->validateIdentifier($source);
        $response = $this->api->post(
            $this->ext . '/create',
            [
                'body' => json_encode(
                    [
                        'name' => $name,
                        'description' => $description,
                        'source' => $source,
                    ]
                ),
            ]
        );

        return $this->handleResponse($response);
    }

    public function addUserToList(int $listId, string $identifierKey, string $identifierValue): string
    {
        $this->validateIdentifier($identifierKey);
        $response = $this->api->put(
            $this->ext . '/add_user_to_list/' . $listId,
            $this->getUserListParams($identifierKey, $identifierValue)
        );

        return $this->handleResponse($response);
    }

    public function removeUserFromList(int $listId, string $identifierKey, string $identifierValue): string
    {
        $this->validateIdentifier($identifierKey);
        $response = $this->api->put(
            $this->ext . '/remove_user_from_list/' . $listId,
            $this->getUserListParams($identifierKey, $identifierValue)
        );

        return $this->handleResponse($response);
    }

    private function validateIdentifier(string $key): void
    {
        if (! in_array($key, $this->identifiers)) {
            throw new Exception('Identifier key must be either "customer_id" or "email"');
        }
    }

    private function getUserListParams(string $identifierKey, string $identifierValue): array
    {
        return [
            'body' => json_encode(
                [
                    'identifier_key' => $identifierKey,
                    'identifier_value' => $identifierValue,
                ]
            ),
        ];
    }
}
