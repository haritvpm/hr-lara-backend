<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

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
        //
        // Paginator::defaultView('vendor.pagination.default');
 
        // Paginator::defaultSimpleView('vendor.pagination.default');

        // Paginator::useBootstrap();

        date_default_timezone_set('Asia/Kolkata');
        Carbon::setLocale(config('app.locale'));
    }
}
