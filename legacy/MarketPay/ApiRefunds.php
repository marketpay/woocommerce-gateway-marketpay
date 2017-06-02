<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for refunds
 */
class ApiRefunds extends Libraries\ApiBase
{
    /**
     * Get refund object
     * @param string $refundId Refund Id
     * @return \MarketPay\Refund Refund object returned from API
     */
    public function Get($refundId)
    {
        return $this->GetObject('refunds_get', $refundId, '\MarketPay\Refund');
    }
}
