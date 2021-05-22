<?php

namespace Paylense;

class Payments extends Request
{
    public $headers;

    public $authToken;

    public $_baseUrl;

    // @var string The Paylense your_api_secret
    public $_your_api_secret;

    // @var string The Paylense password
    public $_password;

    // @var string The Paylense remittance API Secret.
    public $_appId;


    /**
     * @var HttpClient\ClientInterface
     */
    private static $_httpClient;


    /**
     * Collection constructor.
     *
     * @param string|null $apiKey
     * @param string|null $apiBase
     */
    public function __construct($baseUrl = null, $targetEnvironment = null, $your_api_secret = null, $password = null, $appId = null)
    {
        if (!$baseUrl) {
            $baseUrl = Paylense::getBaseUrl();
        }
        $this->_baseUrl = $baseUrl;

        if (!$your_api_secret) {
            $your_api_secret = Paylense::getApiSecret();
        }
        $this->_your_api_secret = $your_api_secret;


        if (!$password) {
            $password = Paylense::getPassword();
        }
        $this->_password = $password;


        if (!$appId) {
            $appId = Paylense::getApiKey();
        }
        $this->_appId = $appId;
    }

     /**
     *
     * @return string The encoded string for the basic http authorization
     */
    public function getAuthorization()
    {
        $encodedString = base64_encode(
            Paylense::getApiSecret() . ':' . Paylense::getPassword()
        );

        return $encodedString;
    }
    
     /**
     *
     * @return array The associative array of the header
     */
    public function getHeader()
    {
        $authorization = $this->getAuthorization();

        $headers = [
            'Authorization' => 'Basic ' . $authorization,
            'Content-Type' => 'application/json',
            "APP-ID" => $this->_appId
        ];
        
        return $headers;
    }

    /**
     * @param array|null|mixed $params The list of parameters to validate
     *
     * @throws \Paylense\Error\PaylenseError if $params exists and is not an array
     */
    protected static function _validateParams($params = null)
    {
        if ($params && !is_array($params)) {
            $message = "You must pass an array as the first argument to Paylense API "
                . "method calls.  (HINT: an example call to create a charge "
                . "would be: \"Paylense\\Charge::create(['amount' => 100, "
                . "'currency' => 'usd', 'source' => 'tok_1234'])\")";
            throw new \Paylense\Error\PaylenseError($message);
        }
    }
}
