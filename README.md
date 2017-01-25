![AddPay Logo](http://i.imgur.com/IwnJKhP.png "AddPay Logo")

# Installation

## Require the package

`composer require addpay/addpay-php-client --prefer-dist`.

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

# Usage

## Configuratiion

Edit `app/config/addpay-client.php` and add your `app key` and `app secret`.

## Get Payment Methods

```
use AddPay\Wrapper\Client\Facades\AddPay;

$request = AddPay::getPaymentMethods();
```

## Prepare Payment

See addPay integration documentation on the required parameters in the data block.

```
use AddPay\Wrapper\Client\Facades\AddPay;

$request = AddPay::preparePayment([
      ...
      'trans_amount'   => '500.00',
      'trans_method'   => 'METH_PAYMENT_CARD_STD',
      'trans_currency' => 'USD',
      ...
  ]);
```

## Result Handling

When the request is completed, an `AddPayResult` object is returned. In some cases you may experience errors, in these events, an `AddPayResult` object is created which contains the error code, error message and in the event of a caught exception, the exception will be included - Using the `AddPayResult` object is quite straight forward.

### Ensure the request succeeded

```
use AddPay\Wrapper\Client\Facades\AddPay;

$request = AddPay::getPaymentMethods();

if ($request->succeeds()) {
     $response = $request->payload;
     
     // do something with your response
}
```

### Handle failed request

```
use AddPay\Wrapper\Client\Facades\AddPay;

$request = AddPay::getPaymentMethods();

if ($request->fails()) {
     $error = $request->error;
     
     $error_message = $error->desc;
     $error_code    = $error->code;
     
     // do something with your error
     
     if (isset($error->exception)) {
         $exception = $error->exception;
         
         // do something with your exception
     }
}
```
