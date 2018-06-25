<?php

namespace Vicoders\LaravelKit\Facades;

use Illuminate\Support\Facades\Facade;
use Vicoders\LaravelKit\Manager;

class ExtensionKitManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return new Manager;
    }
}
