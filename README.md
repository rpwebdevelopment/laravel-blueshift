
# Blueshift integration package for laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rpwebdevelopment/laravel-blueshift.svg?style=flat-square)](https://packagist.org/packages/rpwebdevelopment/laravel-blueshift)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/rpwebdevelopment/laravel-blueshift/run-tests?label=tests)](https://github.com/rpwebdevelopment/laravel-blueshift/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/rpwebdevelopment/laravel-blueshift/Check%20&%20fix%20styling?label=code%20style)](https://github.com/rpwebdevelopment/laravel-blueshift/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/rpwebdevelopment/laravel-blueshift.svg?style=flat-square)](https://packagist.org/packages/rpwebdevelopment/laravel-blueshift)

This is a Laravel specific package designed to make communication with the [Blueshift API](https://developer.blueshift.com/reference/welcome) quick and easy.

## Requirements

Currently this package only functions on Laravel 8.*

## Installation

You can install the package via composer:

```bash
composer require rpwebdevelopment/laravel-blueshift
```

## Usage

laravel-package accepts 2 .env constants for configuration:

* `BLUESHIFT_API_KEY` - This sould be the "Users Api Key" provided by Blueshift
* `BLUESHIFT_BASE_URL` - Defaults to 'https://api.eu.getblueshift.com', for non EU this should be set to 'https://api.getblueshift.com'

laravel-blueshift provides specific classes for handling different API endpoints, the available classes and their methods are as follows:

- BlueshiftCustomer
    - search(string $email);
    - get(string $uuid); 
    - createJson(string $customer);
    - createArray(array $customer);
    - bulkCreateJson(string $customers);
    - bulkCreateArray(array $customers);
    - startTracking(?string $email, ?string $uuid);
    - stopTracking(?string $email, ?string $uuid);
    - delete(?string $email, ?string $uuid, bool $allMatching)
- BlueshiftCatalog
    - createCatalog(string $name);
    - getList();
    - addItems(string $uuid, array $items);
    - getCatalog(string $uuid);
- BlueshiftUserList
    - createList(string $name, string $description, string $source = 'email');
    - addUserToList(int $listId, string $identifierKey, string $identifierValue);
    - removeUserFromList(int $listId, string $identifierKey, string $identifierValue);
- BlueshiftEvent
    - sendEvent(array $event);
      
From your laravel application these methods can be called as follows:
```php
try {
    $customer = app(BlueshiftCustomer::class)->search('email_address@example.org');
} catch (\Exception $e) {
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Rich Porter](https://github.com/rpwebdevelopment)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
