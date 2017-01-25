![AddPay Logo](http://i.imgur.com/jPCaBUK.png "ShopKit Logo")

## Installation

### Require the package

`composer require addpay/addpay-laravel-client --prefer-dist`.

### Inject Service Provider & Publish package configuration files**

Add the AddPay Client service provider to your `App/Config/app.php` file

```
'providers' => [
        ...        
        AddPay\Wrapper\Client\AddPayServiceProvider::class,
      ]
```

Add the ShopKit facade to your `App/Config/app.php` file

```
'aliases' => [
        ...        
        'AddPayHttp' => AddPay\Wrapper\Client\Facades\AddPay::class,
      ]
```

Run `php artisan vendor:publish --provider="AddPay\Wrapper\Client\AddPayServiceProvider"` - This will generate all necessary configurations including migration files and config files.

## Usage

Edit `app/config/addpay-client.php` and add your `app secret` and `app key`.

### List Available Payment Methods
`AddPay::getPaymentMethods()`

### Prepare Payment
`AddPay::preparePayment($data);`

