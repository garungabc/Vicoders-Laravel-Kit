<?php

namespace Vicoders\LaravelKit;

use Illuminate\Support\ServiceProvider;
use Vicoders\LaravelKit\Console\MakeModuleCommand;

class ExtensionKitServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (!is_dir(get_stylesheet_directory() . '/vendor/Vicoders/menu-kit/resources/cache')) {
            mkdir(get_stylesheet_directory() . '/vendor/Vicoders/menu-kit/resources/cache', 0755);
        }
        $this->setShortcode();
        if (is_admin()) {
            $this->registerOptionPage();
        }
    }
    
    public function registerCommand()
    {
        // Register your command here, they will be bootstrapped at console
        return [
            MakeModuleCommand::class,
        ];
    }
}
