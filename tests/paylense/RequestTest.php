<?php

namespace Paylense;

use Paylense\HttpClient\CurlClient;

class RequestTest extends TestCase
{
    public function testHttpClientInjection()
    {
        $reflector = new \ReflectionClass('Paylense\\Request');
        $method = $reflector->getMethod('httpClient');
        $method->setAccessible(true);

        $curl = new CurlClient();
        $curl->setTimeout(10);
        Request::setHttpClient($curl);

        $injectedCurl = $method->invoke(new Request());
        $this->assertSame($injectedCurl, $curl);
    }
}
