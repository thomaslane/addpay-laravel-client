<?php

namespace AddPay\Wrapper\Client;

use Illuminate\Support\ServiceProvider;

class AddPayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind('addpay', function ($app) {
            return new AddPay();
        });

        $this->publishes([
            __DIR__.'/Config/addpay-client.php' => config_path('addpay-client.php'),
        ]);
    }

    public function provides()
    {
        return ['addpay'];
    }
    
    public function register() {};
}
