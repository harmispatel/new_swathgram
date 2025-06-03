<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // app()->register(\App\Providers\RouteServiceProvider::class);
        View::composer('*', function ($view) {
            $view->with('current_route', Route::currentRouteName());
        });
    }
}
