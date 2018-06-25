# Vicoders Laravel Kit

## Table of Contents

- <a href="#installation">Installation</a>
    - <a href="#composer">Composer</a>
    - <a href="#laravel">Laravel</a>

## Installation

### Composer

Execute the following command to get the latest version of the package:

```terminal
composer require vicodersvn/laravel-kit
```

### Laravel

#### >= laravel5.5

ServiceProvider will be attached automatically

#### Other

In your `config/app.php` add `Vicoders\LaravelKit\Providers\LaravelKitServiceProvider::class` to the end of the `providers` array:

```php
'providers' => [
    ...
    Vicoders\LaravelKit\Providers\LaravelKitServiceProvider::class,
],
```