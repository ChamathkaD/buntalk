<?php

namespace Cyntrek\Marx\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MarxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::middleware('web')->group(__DIR__.'/../Routes/web.php');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/paymentmethods.php', 'payment_methods'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/system.php', 'core'
        );
    }
}
