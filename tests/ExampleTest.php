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

    public function testCatalogValidateRequiresAllFields(): void
    {
        $catalog = app()->make(BlueshiftCatalog::class);
        $this->expectException(BlueshiftValidationException::class);
        $catalog->validateItem(
            [
                'category' => ['cars'],
                'image' => 'https://someurl.com/image/test.jpg',
                'product_id' => 'ABC1234',
                'availability' => 'in stock',
                'title' => 'Test Product',
            ]
        );
    }

    public function testCatalogValidateRequiresCategoryArray(): void
    {
        $catalog = app()->make(BlueshiftCatalog::class);
        $this->expectException(BlueshiftValidationException::class);
        $catalog->validateItem(
            [
                'category' => 'cars',
                'image' => 'https://someurl.com/image/test.jpg',
                'product_id' => 'ABC1234',
                'availability' => 'in stock',
                'title' => 'Test Product',
                'web_link' => 'https://someurl.com/product/ABC1234',
            ]
        );
    }

    public function testCatalogValidateRequiresValidAvailability(): void
    {
        $catalog = app()->make(BlueshiftCatalog::class);
        $this->expectException(BlueshiftValidationException::class);
        $catalog->validateItem(
            [
                'category' => ['cars'],
                'image' => 'https://someurl.com/image/test.jpg',
                'product_id' => 'ABC1234',
                'availability' => 'fail',
                'title' => 'Test Product',
                'web_link' => 'https://someurl.com/product/ABC1234',
            ]
        );
    }
}
