<?php

namespace Paylense;

/**
 * Class Paylense
 *
 * @package Paylense
 */
class Paylense
{
    // @var string the base url of the API
    const VERSION = 'v1';

    //@var string target environment
    public static $baseUrl;


    // @var string the currency of http calls
    public static $targetEnvironment;

    // @var string The Paylense your_api_secret
    public static $your_api_secret;

    // @var string The Paylense password
    public static $password;


    // @var string The Paylense remittance API Secret.
    public static $appId;

    // @var Util\LoggerInterface|null The logger to which the library will
    //   produce messages.
    public static $verifySslCerts = false;

    // @var int Maximum number of request retries
    public static $logger = null;


    // @var float Maximum delay between retries, in seconds
    public static $maxNetworkRetries = 0;

    // @var float Initial delay between retries, in seconds
    private static $maxNetworkRetryDelay = 2.0;
    private static $initialNetworkRetryDelay = 0.5;

    /**
     * @return string The Base Url.
     */
    public static function getBaseUrl()
    {
        $burl = getenv("PAYLENSE_BASE_URL");

        if (isset(self::$baseUrl)) {
            return self::$baseUrl;
        } else if ($burl) {
            return $burl;
        } else {
            if (self::getTargetEnvironment() == "sandbox") {
                return "https://api-sandbox.paylense.com/api/".self::VERSION;
            }
            return "https://api.paylense.com/api/".self::VERSION;
        }
    }


    /**
     * Sets the baseUrl.
     *
     * @param string $baseUrl
     */
    public static function setBaseUrl($baseUrl)
    {
        self::$baseUrl = $baseUrl;
    }

    /**
     * @return string The target environment.
     */
    public static function getTargetEnvironment()
    {

        $targ = getenv("PAYLENSE_TARGET_ENVIRONMENT");
        if (isset(self::$targetEnvironment)) {
            return self::$targetEnvironment;
        }

        if ($targ) {
            return $targ;
        }

        return "sandbox";
    }


    /**
     * Sets the $targetEnvironment.
     *
     * @param string $targetEnvironment
     */
    public static function setTargetEnvironment($targetEnvironment)
    {
        self::$targetEnvironment = $targetEnvironment;
    }


    /**
     * @return string The your_api_secret.
     */
    public static function getApiSecret()
    {

        $arg = getenv("PAYLENSE_API_SECRET");

        if (isset(self::$your_api_secret)) {
            return self::$your_api_secret;
        }

        if ($arg) {
            return $arg;
        }
    }


    /**
     * Sets the your_api_secret.
     *
     * @param string $your_api_secret
     */
    public static function setApiSecret($your_api_secret)
    {
        self::$your_api_secret = $your_api_secret;
    }


    /**
     * @return string The password.
     */
    public static function getPassword()
    {
        $arg = getenv("PAYLENSE_PASSWORD");

        if (isset(self::$password)) {
            return self::$password;
        }

        if ($arg) {
            return $arg;
        }
    }


    /**
     * Sets the password.
     *
     * @param string $password
     */
    public static function setPassword($password)
    {
        self::$password = $password;
    }


    /**
     * @return string The appId.
     */
    public static function getApiKey()
    {

        $arg = getenv("PAYLENSE_API_KEY");

        if (isset(self::$appId)) {
            return self::$appId;
        }

        if ($arg) {
            return $arg;
        }
    }


    /**
     * Sets the appId.
     *
     * @param string $appId
     */
    public static function setApiKey($appId)
    {
        self::$appId = $appId;
    }

    /**
     * @return Util\LoggerInterface The logger to which the library will
     *   produce messages.
     */
    public static function getLogger()
    {
        if (self::$logger == null) {
            return new Util\DefaultLogger();
        }
        return self::$logger;
    }

    /**
     * @param Util\LoggerInterface $logger The logger to which the library
     *                                     will produce messages.
     */
    public static function setLogger($logger)
    {
        self::$logger = $logger;
    }


    /**
     * @return int Maximum number of request retries
     */
    public static function getMaxNetworkRetries()
    {
        return self::$maxNetworkRetries;
    }

    /**
     * @param int $maxNetworkRetries Maximum number of request retries
     */
    public static function setMaxNetworkRetries($maxNetworkRetries)
    {
        self::$maxNetworkRetries = $maxNetworkRetries;
    }

    /**
     * @return float Maximum delay between retries, in seconds
     */
    public static function getMaxNetworkRetryDelay()
    {
        return self::$maxNetworkRetryDelay;
    }

    /**
     * @return float Initial delay between retries, in seconds
     */
    public static function getInitialNetworkRetryDelay()
    {
        return self::$initialNetworkRetryDelay;
    }
}
