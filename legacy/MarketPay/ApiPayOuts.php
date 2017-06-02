<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for pay-outs
 */
class ApiPayOuts extends Libraries\ApiBase
{
    /**
     * Create new pay-out
     * @param PayOut $payOut
     * @return \MarketPay\PayOut Object returned from API
     */
    public function Create($payOut, $idempotencyKey = null)
    {
        $paymentKey = $this->GetPaymentKey($payOut);
        return $this->CreateObject('payouts_' . $paymentKey . '_create', $payOut, '\MarketPay\PayOut', null, null, $idempotencyKey);
    }
    
    /**
     * Get pay-out object
     * @param $payOutId PayOut identifier
     * @return \MarketPay\PayOut Object returned from API
     */
    public function Get($payOutId)
    {
        return $this->GetObject('payouts_get', $payOutId, '\MarketPay\PayOut');
    }
    
    private function GetPaymentKey($payOut)
    {
        if (!isset($payOut->MeanOfPaymentDetails) || !is_object($payOut->MeanOfPaymentDetails)) {
            throw new Libraries\Exception('Mean of payment is not defined or it is not object type');
        }
        
        $className = str_replace('MarketPay\\PayOutPaymentDetails', '', get_class($payOut->MeanOfPaymentDetails));
        return strtolower($className);
    }
}
