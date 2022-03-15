<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Tests;

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
}
