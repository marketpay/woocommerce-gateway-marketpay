<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for responses
 * See 
 */

 /**
 * Class ApiResponses
 * @package MarketPay
 */
class ApiResponses extends Libraries\ApiBase
{

    /**
     * Get response from previous call by idempotency key
     * @param object $idempotencyKey Idempotency key
     * @return \MarketPay\Response Entity of Response object
     */
    public function Get($idempotencyKey)
    {
        return $this->GetObject('responses_get', $idempotencyKey, 'MarketPay\Response');
    }
}
