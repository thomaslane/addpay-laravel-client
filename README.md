![AddPay Logo](http://i.imgur.com/IwnJKhP.png "AddPay Logo")

# Installation

## Require the package

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

# Usage

## Configuratiion

Edit `app/config/addpay-client.php` and add your `app key` and `app secret`.

## Get Payment Methods

```
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use AddPay\Wrapper\Client\Facades\AddPay;

try {
        $result = AddPay::getPaymentMethods();

        echo $result->getStatusCode();
        echo $result->getBody();
}
catch (RequestException $e) {
        echo $e->getMessage();
} catch (ConnectException $e) {
        echo $e->getMessage();
} catch (ClientException $e) {
         echo $e->getMessage();
} catch (\Exception $e) {
        echo $e->getMessage();
}
```

## Prepare Payment

See addPay integration documentation on the required parameters in the data block.

```
use AddPay\Wrapper\Client\Facades\AddPay;
use AddPay\Client\AddPayClient;
use AddPay\Client\Containers\Transaction\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
  
$transaction = new Transaction();
$transaction->setPayerFirstname('<payer-firstname>');
$transaction->setPayerLastname('<payer-lastname>');
$transaction->setPayerEmail('foobar@example.org');
$transaction->setMethod('METH_PAYMENT_CARD_STD'); // see getPaymentMethods()
$transaction->setAmountValue('<amount-in-cents>');
$transaction->setAmountCurrency('<currency-iso>');
$transaction->setAppReturnUrl('<app-return-url>');
$transaction->setAppNotifyUrl('<app-notification-url>');
$transaction->setApiMode('<live/test>');

try {
    $result = AddPay::setAppId('<your-app-id>');
                    ->setAppSecret('<your-app-secret>')
                    ->submitTransaction($transaction);

    echo $result->getStatusCode();
    echo $result->getBody();
}
catch (RequestException $e) {
    echo $e->getMessage();
} catch (ConnectException $e) {
    echo $e->getMessage();
} catch (ClientException $e) {
    echo $e->getMessage();
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

## Result Handling

The result of an HTTP call will always be returned in a Guzzle PSR7 Stream object allowing you full control over the handling of the result in instances where the response is not a `200` or `201`. To retreive the object content call `getBody()` on the response which will by default return JSON unless otherwise specified. HTTP status codes may be checked with `getStatusCode()` where anything other than `200` and `201` is an error which respects standard HTTP response codes:

Most common response codes:

- `403` Forbidden - Check your App ID and App Secret
- `422` Unprocessable Entity - Either an invalid parameter has been passed through or one or more are missing
