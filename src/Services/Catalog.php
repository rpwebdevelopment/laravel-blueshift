<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Services;

use Rpwebdevelopment\LaravelBlueshift\Contracts\BlueshiftCatalog;
use Rpwebdevelopment\LaravelBlueshift\Exceptions\BlueshiftValidationException;

class Catalog extends Blueshift implements BlueshiftCatalog
{
    private string $baseUrl = 'https://api.getblueshift.com/api/v1/catalogs';
    private array $availabilityOptions = ['in stock', 'out of stock'];
    private array $requiredKeys = [
        'category',
        'image',
        'product_id',
        'availability',
        'title',
        'web_link',
    ];

    public function createCatalog(string $name): string
    {
        $response = $this->api->post($this->baseUrl, ['body' => json_encode(['catalog' => ['name' => $name]])]);

        return $this->handleResponse($response);
    }

    public function getList(): string
    {
        $response = $this->api->get($this->baseUrl);

        return $this->handleResponse($response);
    }

    public function addItems(string $uuid, array $items): string
    {
        $products = [];
        foreach ($items as $item) {
            $products[] = $this->validateItem($item);
        }

        $response = $this->api->put(
            $this->baseUrl . '/' . $uuid . '.json',
            ['body' => json_encode(['catalog' => ['products' => $products]])]
        );

        return $this->handleResponse($response);
    }

    public function getCatalog(string $uuid): string
    {
        $response = $this->api->get($this->baseUrl . '/' . $uuid . '.json');

        return $this->handleResponse($response);
    }

    public function validateItem(array $item): ?array
    {
        $required = array_filter(
            array_intersect_key($item, array_flip($this->requiredKeys)),
            fn ($v) => ((is_array($v) && count($v) > 0) || ($v !== null && $v !== ''))
        );
        if (count($this->requiredKeys) !== count($required)) {
            throw BlueshiftValidationException::missingRequired();
        }

        if (! is_array($item['category'])) {
            throw BlueshiftValidationException::invalidCategoryType();
        }

        if (! in_array($item['availability'], $this->availabilityOptions)) {
            throw BlueshiftValidationException::invalidAvailabilityStatus();
        }

        return $item;
    }
}
