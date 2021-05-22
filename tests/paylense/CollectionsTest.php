<?php

namespace Paylense;

use Paylense\HttpClient\CurlClient;

class CollectionsTest extends TestCase
{
    public function testRequestToPay()
    {
        $coll = new Collections();

        $params = [
            'account_number' => "256782181656",
            'merchant_reference' => "ref",
            'payer_message' => "12",
            'narration' => "what is being paid for",
            'amount' => "500"];

        $t = $coll->requestToPay($params);

        $this->assertFalse(is_null($t));

        $collection = $coll->getCollection($t);

        $this->assertFalse(is_null($collection->getStatus()));
    }
}
