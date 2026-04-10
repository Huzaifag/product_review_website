<?php

namespace Vironeer\Flutterwave;

use Illuminate\Support\ServiceProvider;
use Vironeer\Flutterwave\Flutterwave;

class FlutterwaveServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $config = realpath(__DIR__ . '/config/flutterwave.php');

        $this->publishes([
            $config => config_path('flutterwave.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(Flutterwave::class, function ($app) {
            return new Flutterwave($app->make("request"));
        });
    }

    public function provides()
    {
        return [Flutterwave::class];
    }
}