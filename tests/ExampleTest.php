<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Tests;

use Rpwebdevelopment\LaravelBlueshift\Contracts\BlueshiftCatalog;
use Rpwebdevelopment\LaravelBlueshift\Exceptions\BlueshiftValidationException;
use Rpwebdevelopment\LaravelBlueshift\Services\Api\Api;

class ExampleTest extends TestCase
{
    public function testTrueIsTrue(): void
    {
        $this->assertTrue(true);
    }

    public function testApiCorrectInstance(): void
    {
        $api = app()->make(Api::class);
        $this->assertInstanceOf(Api::class, $api);
    }

    public function testCatalogValidateReturnsValid(): void
    {
        $catalog = app()->make(BlueshiftCatalog::class);
        $product = [
            'category' => ['cars'],
            'image' => 'https://someurl.com/image/test.jpg',
            'product_id' => 'ABC1234',
            'availability' => 'in stock',
            'title' => 'Test Product',
            'web_link' => 'https://someurl.com/product/ABC1234',
        ];
        $item = $catalog->validateItem($product);
        $this->assertSame($item, $product);
    }

    public function invalidItemDataProvider(): array
    {
        return [
            'missing field' => [
                'item' => [
                    'category' => ['cars'],
                    'image' => 'https://someurl.com/image/test.jpg',
                    'product_id' => 'ABC1234',
                    'availability' => 'in stock',
                    'title' => 'Test Product',
                ],
            ],
            'invalid category type' => [
                'item' => [
                    'category' => 'cars',
                    'image' => 'https://someurl.com/image/test.jpg',
                    'product_id' => 'ABC1234',
                    'availability' => 'in stock',
                    'title' => 'Test Product',
                    'web_link' => 'https://someurl.com/product/ABC1234',
                ],
            ],
            'invalid availability' => [
                'item' => [
                    'category' => ['cars'],
                    'image' => 'https://someurl.com/image/test.jpg',
                    'product_id' => 'ABC1234',
                    'availability' => 'fail',
                    'title' => 'Test Product',
                    'web_link' => 'https://someurl.com/product/ABC1234',
                ],
            ],
        ];
    }

    /**
     * @dataProvider invalidItemDataProvider
     */
    public function testInvalidDataThrowsException(array $item): void
    {
        $catalog = app()->make(BlueshiftCatalog::class);
        $this->expectException(BlueshiftValidationException::class);
        $catalog->validateItem($item);
    }
}
