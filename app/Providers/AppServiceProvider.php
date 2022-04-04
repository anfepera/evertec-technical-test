<?php

namespace App\Providers;

use App\Services\Interfaces\PaymentMethodTemplate;
use App\Services\PlaceToPayApi;
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
        $this->app->bind(PaymentMethodTemplate::class, PlaceToPayApi::class);
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
