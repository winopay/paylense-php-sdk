<?php

namespace Paylense;

use Paylense\HttpClient\CurlClient;

class DisbursementsTest extends TestCase
{
    public function testTransfer()
    {
        $coll = new Disbursements();

        $params = [
            'account_number' => "256782181656",
            'merchant_reference' => "ref",
            'payer_message' => "12",
            'narration' => "what is being paid for",
            'amount' => "500"];

        $t = $coll->transfer($params);

        $this->assertFalse(is_null($t));

        $disbursement = $coll->getDisbursement($t);

        $this->assertFalse(is_null($disbursement->getStatus()));
    }
}
