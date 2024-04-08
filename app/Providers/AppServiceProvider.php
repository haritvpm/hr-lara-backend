<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Services\EmployeeService;
use App\Services\PunchingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
   

//injecting ExampleDependantService into SyncProfile service
        // $this->app->bind(SyncProfile::class, function (Application $app) {
        //     return new SyncProfile($app->make(ExampleDependantService::class));
        // });
        // $this->app->bind(PunchingService::class, function (Application $app) {
        //     return new PunchingService($app->make(AebasFetchService::class));
        // });
        // $this->app->bind(PunchingService::class, function (Application $app) {
        //     return new PunchingService($app->make(EmployeeService::class));
        // });
        // $this->app->bind(EmployeeService::class, function (Application $app) {
        //     return new EmployeeService($app->make(AebasFetchService::class));
        // });
        
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
