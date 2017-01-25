<?php

namespace AddPay\Wrapper\Client;

use AddPay\Client\AddPayClient;

class AddPay extends AddPayClient
{
    public function __construct()
    {
        parent::__construct();

        $this->app_key = config('addpay-client.API_APP_KEY', '');
        $this->app_secret = config('addpay-client.API_APP_SECRET', '');
    }
}
