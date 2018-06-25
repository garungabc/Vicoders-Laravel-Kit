<?php

namespace Vicoders\LaravelKit\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelKitServiceProvider extends ServiceProvider
{
    /**
     *
     * @return void
     */
    public function boot()
    {

    }

    public function register()
    {
        $this->commands('Vicoders\LaravelKit\Commands\MakeModuleCommand');
    }
}
