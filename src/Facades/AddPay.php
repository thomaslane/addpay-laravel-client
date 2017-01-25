<?php

namespace AddPay\Wrapper\Client\Facades;

use Illuminate\Support\Facades\Facade;

class AddPay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'addpay';
    }
}
