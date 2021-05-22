# paylense-php-sdk
Winopay Paylense API SDK for PHP

[![Build Status](https://travis-ci.org/winopay/paylense-php-sdk.svg?branch=master)](https://travis-ci.org/winopay/paylense-php-sdk)
[![Latest Stable Version](https://poser.pugx.org/paylense/paylense-php-sdk/v/stable.svg)](https://packagist.org/packages/paylense/paylense-php-sdk)
[![Total Downloads](https://poser.pugx.org/paylense/paylense-php-sdk/downloads.svg)](https://packagist.org/packages/paylense/paylense-php-sdk)
[![License](https://poser.pugx.org/paylense/paylense-php-sdk/license.svg)](https://packagist.org/packages/paylense/paylense-php-sdk)
[![Coverage Status](https://coveralls.io/repos/github/winopay/paylense-php-sdk/badge.svg?branch=master)](https://coveralls.io/github/winopay/paylense-php-sdk?branch=master)
[![Join the community on Spectrum](https://withspectrum.github.io/badge/badge.svg)](https://spectrum.chat/paylense-api-sdk/)



## Requirements

PHP 5.4.0 and later.

## Composer

You can install the sdk via [Composer](http://getcomposer.org/). Run the following command:

```bash

composer require winopay/paylense-php-sdk
```

To use the sdk, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/winopay/paylense-php-sdk/releases). Then, to use the sdk, include the `init.php` file.

```php
require_once('/path/to/paylense-php-sdk/init.php');
```

## Dependencies

The sdk require the following extensions in order to work properly:

- [`curl`](https://secure.php.net/manual/en/book.curl.php), although you can use your own non-cURL client if you prefer
- [`json`](https://secure.php.net/manual/en/book.json.php)
- [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) (Multibyte String)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.

## Getting Started


# Sandbox Environment

## Getting environment API user 

Next, we need to get the `APP-ID`, `your_api_secret` and `password` for use in the product. You can get these details from `https://dashboard.paylense.com/signup`.

The redentials in the sandbox environment can be used straight away. In production, the credentials are provided for you after KYC requirements are met.


## Configuration

Before we can fully utilize the library, we need to specify global configurations. The global configuration using the requestOpts builder. By default, these are picked from environment variables,but can be overidden using the Paylense builder

* `BASE_URL`: An optional base url to the Paylense API. By default the staging base url will be used
* `ENVIRONMENT`: Optional enviroment, either "sandbox" or "production". Default is 'sandbox'
* `API_KEY`: The app key that is used to identify who is making the payments,
* `API_SECRET`:  App secret used for authentication

you can also use the `Paylense` to globally set the different variables.



```php
    Paylense::setBaseUrl('base');

    Paylense::setTargetEnvironment("targetenv");

    Paylense::setApiSecret("your_api_secret");

    Paylense::setApiKey("your_api_key");
```



## Collections
Used to create an instance of collection


You can create a collection client with the following:

```php
    use Paylense;

    $collections = new Collections();
```

### Methods

1. `request_to_pay`: This operation is used to request a payment from a Payer. The payer will be asked to authorize the payment. The transaction is executed once the payer has authorized the payment. The transaction will be in status PENDING until it is authorized or declined by the payer or it is timed out by the system. The status of the transaction can be validated by using `get_transaction_status`. 

2. `get_transaction_status`: Retrieve transaction information using the `transaction_reference` returned by `request_to_pay`. You can invoke it at intervals until the transaction fails or succeeds. If the transaction has failed, it will throw an appropriate error. 

### Sample Code

```php
    $params = [
                'account_number' => "256782181656",
                'merchant_reference' => "ref",
                'payer_message' => "12",
                'narration' => "what is being paid for",
                'amount' => "500"];

    $t = $collections->requestToPay($params);
```

## Disbursements
Used to create an instance of disbursement

You can create an disbursement client with the following:

```php
    use Paylense;

    $disbursements = new Disbursements();
```

### Methods
1. `transfer`: Used to transfer an amount from the payers's account to a owners account. The status of the transaction can be validated by using the `get_transaction_status` method.

2. `get_transaction_status`: Retrieve transaction information using the `transaction_reference` returned by `transfer`. You can invoke it at intervals until the transaction fails or succeeds. If the transaction has failed, it will throw an appropriate error. 

## Sample Code

```php

    $params = [
        'account_number' => "256782181656",
        'merchant_reference' => "ref",
        'payer_message' => "12",
        'narration' => "what is being paid for",
        'amount' => "500"];

    $t = $disbursements->transfer($params);

```

## Custom Request Timeouts

*NOTE:* We do not recommend decreasing the timeout for non-read-only calls , since even if you locally timeout, the request  can still complete.

To modify request timeouts (connect or total, in seconds) you'll need to tell the API client to use a CurlClient other than its default. You'll set the timeouts in that CurlClient.

```php
// set up your tweaked Curl client
$curl = new \Paylense\HttpClient\CurlClient();
$curl->setTimeout(10); // default is \Paylense\HttpClient\CurlClient::DEFAULT_TIMEOUT
$curl->setConnectTimeout(5); // default is \Paylense\HttpClient\CurlClient::DEFAULT_CONNECT_TIMEOUT

echo $curl->getTimeout(); // 10
echo $curl->getConnectTimeout(); // 5

// tell Paylense to use the tweaked client
\Paylense\ApiRequest::setHttpClient($curl);

// use the Paylense API client as you normally would
```

## Custom cURL Options (e.g. proxies)

Need to set a proxy for your requests? Pass in the requisite `CURLOPT_*` array to the CurlClient constructor, using the same syntax as `curl_stopt_array()`. This will set the default cURL options for each HTTP request made by the SDK, though many more common options (e.g. timeouts; see above on how to set those) will be overridden by the client even if set here.

```php
// set up your tweaked Curl client
$curl = new \Paylense\HttpClient\CurlClient([CURLOPT_PROXY => 'proxy.local:80']);
// tell Paylense to use the tweaked client
\Paylense\ApiRequest::setHttpClient($curl);
```

Alternately, a callable can be passed to the CurlClient constructor that returns the above array based on request inputs. See `testDefaultOptions()` in `tests/CurlClientTest.php` for an example of this behavior. Note that the callable is called at the beginning of every API request, before the request is sent.

### Configuring a Logger

The library does minimal logging, but it can be configured
with a [`PSR-3` compatible logger][psr3] so that messages
end up there instead of `error_log`:

```php
\Paylense\Paylense::setLogger($logger);
```


### Configuring Automatic Retries

The library can be configured to automatically retry requests that fail due to
an intermittent network problem:

```php
\Paylense\Paylense::setMaxNetworkRetries(2);
```


## Development

Get [Composer][composer]. For example, on Mac OS:

```bash
brew install composer
```

Install dependencies:

```bash
composer install
```



Install dependencies as mentioned above (which will resolve [PHPUnit](http://packagist.org/packages/phpunit/phpunit)), then you can run the test suite:

```bash
./vendor/bin/phpunit -c phpunit.no_autoload.xml
```

Or to run an individual test file:

```bash
./vendor/bin/phpunit tests/UtilTest.php
```


[composer]: https://getcomposer.org/
[curl]: http://curl.haxx.se/docs/caextract.html
[psr3]: http://www.php-fig.org/psr/psr-3/