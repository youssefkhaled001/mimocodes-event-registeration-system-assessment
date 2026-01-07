<?php

namespace App\Providers;

use App\Models\Registeration;
use App\Observers\RegisterationObserver;
use Illuminate\Support\ServiceProvider;

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
        Registeration::observe(RegisterationObserver::class);
    }
}
