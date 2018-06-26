<?php

namespace App\Providers;

use App\Repositories\TestimonialRepository;
use App\Repositories\TestimonialRepositoryEloquent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(TestimonialRepository::class, TestimonialRepositoryEloquent::class);
    }
}
