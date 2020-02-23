<?php

namespace App\Providers;

use App\Services\DailyService;
use App\Services\InformationService;
use App\Services\TravelService;
use App\Services\WeiboService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('daily', function ($app) {
            return new DailyService();
        });
        $this->app->singleton('information', function ($app) {
            return new InformationService();
        });
        $this->app->singleton('travel', function ($app) {
            return new TravelService();
        });
        $this->app->singleton('weibo', function ($app) {
            return new WeiboService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
