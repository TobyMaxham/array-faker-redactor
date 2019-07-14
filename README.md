TobyMaxham Array Faker Redactor
=========================

A PHP package to redact or fake array values by their keys no matter how deep the array.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tobymaxham/array-faker-redactor.svg?style=flat-square)](https://packagist.org/packages/tobymaxham/array-faker-redactor)
[![GitHub commits](https://img.shields.io/github/commits-since/tobymaxham/array-faker-redactor/v1.0.svg)](https://GitHub.com/tobymaxham/array-faker-redactor/commit/)
[![Total Downloads](https://img.shields.io/packagist/dt/tobymaxham/array-faker-redactor.svg?style=flat-square)](https://packagist.org/packages/tobymaxham/array-faker-redactor)
[![GitHub contributors](https://img.shields.io/github/contributors/tobymaxham/array-faker-redactor.svg)](https://GitHub.com/TobyMaxham/array-faker-redactor/graphs/contributors/)
[![GitHub issues](https://img.shields.io/github/issues/tobymaxham/array-faker-redactor.svg)](https://GitHub.com/TobyMaxham/array-faker-redactor/issues/)

## Notice
This packages uses the `mtownsend/array-redactor` package by [mtownsend5512](https://github.com/mtownsend5512) and the `Faker` library by [fzaninotto](https://github.com/fzaninotto).
So for more details to those packages look at the repositories readme files:
- [mtownsend/array-redactor](https://github.com/mtownsend5512/array-redactor)
- [fzaninotto/faker](https://github.com/fzaninotto/Faker)

## Why
Sometimes you need to customized your data to protect the privacy of your users or the security of your application.
This is no longer a problem with this package.

With this package, an element of an array or a JSON, no matter how deep, can be easily deleted, redact or faked.
This allows you to customize the response of your server or api and pass it on without worry.


## Installation

Install via composer:

```
composer require tobymaxham/array-faker-redactor
```

## Quick start

### Using the class

```php
use TobyMaxham\ArrayFakerRedactor\ArrayFakerRedactor;

// An example array, maybe a request being made to/from an API application
$content = [
    'email'       => 'git2019@maxham.de',
    'phone'       => '1234567',
    'password'    => 'secret123',
    'notes'       => 'this can be removed',
    'sample_data' => 'nothing else matters',
];

$redactor = (new ArrayFakerRedactor())->content($content)->keys(['email', 'password', 'notes', 'sample_data' => 'random'])->withFaker()->redact();

// $redactor will return something like:
[
    'email'       => 'russel94@hotmail.com',
    'phone'       => '1234567',
    'password'    => ']61i8~}DJB',
    'notes'       => '[REDACTED]',
    'sample_data' => 'e2k9aDUoeXRFQzhP',
];

```


### Advanced usage

You can also add your own FakerProvider (see [Faker Docs](https://github.com/fzaninotto/Faker#faker-internals-understanding-providers)).

```php
$content = [
    'key' => 'some data',
];

$redactor = (new ArrayFakerRedactor())->content($content)->keys(['key' => 'myformatter'])
    ->withFaker()
    ->addFakerProvider(MyProvider::class)
    ->redact();
```


## Testing

You can run the tests with:

```bash
./vendor/bin/phpunit
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- TobyMaxham


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.