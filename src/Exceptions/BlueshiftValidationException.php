<?php

declare(strict_types=1);

namespace Rpwebdevelopment\LaravelBlueshift\Exceptions;

use Exception;

class BlueshiftValidationException extends Exception
{
    public static function missingRequired(): self
    {
        return new self('A required product attribute is missing from the request.');
    }

    public static function invalidCategoryType(): self
    {
        return new self('Item category attribute must be of type array.');
    }

    public static function invalidCustomerIdentifier(): self
    {
        return new self('A valid customer identifier is required.');
    }

    public static function invalidAvailabilityStatus(): self
    {
        return new self('Availability status must be either "in stock" or "out of stock".');
    }

    public static function rateLimitExceeded(): self
    {
        return new self('Rate Limit exceeded, unable to complete request.');
    }

    public static function subscriptionStateRequired(): self
    {
        return new self('Request requires at least one subscription state to be set.');
    }
}
