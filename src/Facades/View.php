<?php

namespace Vicoders\LaravelKit\Facades;

use Illuminate\Support\Facades\Facade;

class View extends Facade
{
    protected static function getFacadeAccessor()
    {
        return new \Vicoders\LaravelKit\Services\View;
    }
}
