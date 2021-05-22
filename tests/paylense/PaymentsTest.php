<?php

namespace Paylense;

use Paylense\HttpClient\CurlClient;

class PaymentsTest extends TestCase
{

    public function testHttpClientInjection()
    {
        $reflector = new \ReflectionClass('Paylense\\Payments');
        $method = $reflector->getMethod('httpClient');
        $method->setAccessible(true);

        $curl = new CurlClient();
        $curl->setTimeout(10);
        Payments::setHttpClient($curl);

        $injectedCurl = $method->invoke(new Payments());
        $this->assertSame($injectedCurl, $curl);
    }


    public function testGetAuthorization()
    {
        $coll = new Payments();

        $authorization = $coll->getAuthorization();

        $this->assertFalse(is_null($authorization));
    }
    
    public function testGetHeader()
    {
        $coll = new Payments();

        $header = $coll->getHeader();

        $this->assertFalse(is_null($header));
    }
}
