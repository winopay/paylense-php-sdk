<?php

namespace Paylense;

use Paylense\models\ResourceFactory;
use Paylense\Util;

class Disbursements extends Payments
{
    /**
     * @param array|null        $params
     * @param array|string|null $options
     *
     * @return Disbursement The disbursement.
     */
    public function getDisbursement($disbursement_id, $params = null)
    {
        $url = $this->_baseUrl . "/disbursements" . $disbursement_id;

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
    public function transfer($params, $options = null)
    {
        
        self::_validateParams($params);

        $url = $this->_baseUrl . "/disbursements";
        
        $processingNumber = Util\Util::uuid();
        
        if (!$params['merchant_reference']) {
            $processingNumber = $params['merchant_reference'];
        }
        

        $data = [
            "processingNumber" => $processingNumber,
            "msisdn" => $params['account_number'],
            "narration" => $params['narration'],
            "amount" => $params['amount']];


        $disbursement = self::request('post', $url, $data, $this->getHeader());


        return $disbursement;
    }
}
