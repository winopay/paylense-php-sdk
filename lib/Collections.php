<?php

namespace Paylense;

use Paylense\models\ResourceFactory;
use Paylense\Util;

class Collections extends Payments
{
    /**
     * @param array|null        $params
     * @param array|string|null $options
     *
     * @return Collection The collection.
     */
    public function getCollection($collection_id, $params = null)
    {
        $url = $this->_baseUrl . "/collections" . $collection_id;

        $response = self::request('get', $url, $params, $this->getHeader());

        $obj = ResourceFactory::requestToPayFromJson($response->json);

        return $obj;
    }


    /**
     * @param array|null        $params
     * @param array|string|null $options
     *
     * @return Charge The refunded charge.
     */
    public function requestToPay($params, $options = null)
    {

        self::_validateParams($params);
        
        $url = $this->_baseUrl . "/collections";

        $processingNumber = Util\Util::uuid();
        
        if (array_key_exists("merchant_reference", $params)) {
            $processingNumber = $params['merchant_reference'];
        }
        

        $data = [
            "processingNumber" => $processingNumber,
            "msisdn" => $params['account_number'],
            "narration" => $params['narration'],
            "amount" => $params['amount']];


        $collection = self::request('post', $url, $data, $this->getHeader());


        return $collection;
    }
}
