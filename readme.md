# Vicoders Laravel Kit

## Table of Contents

- <a href="#installation">Installation</a>
    - <a href="#composer">Composer</a>
    - <a href="#laravel">Laravel</a>
    - <a href="#command">Command</a>


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

### Command
##### Create register basic module 
```terminal
php artisan make:module register --type=basic
```

##### Create register api module 
```terminal
php artisan make:module register --type=api
```

##### Create category basic module 
```terminal
php artisan make:module category --type=basic
```

##### Create category api module 
```terminal
php artisan make:module category --type=api
```

##### Create post basic module 
```terminal
php artisan make:module post --type=basic
```

##### Create post api module 
```terminal
php artisan make:module post --type=api
```

##### Create testimonial basic module 
```terminal
php artisan make:module testimonial --type=basic
```

##### Create testimonial api module 
```terminal
php artisan make:module testimonial --type=api
```

##### Create product basic module 
```terminal
php artisan make:module product --type=basic
```

##### Create product api module 
```terminal
php artisan make:module product --type=api
```