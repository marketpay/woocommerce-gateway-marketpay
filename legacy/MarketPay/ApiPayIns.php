<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for pay-ins
 */
class ApiPayIns extends Libraries\ApiBase
{
    /**
     * Create new pay-in object
     * @param \MarketPay\PayIn $payIn \MarketPay\PayIn object
     * @return \MarketPay\PayIn Object returned from API
     */
    public function Create($payIn, $idempotencyKey = null)
    {
        $paymentKey = $this->GetPaymentKey($payIn);
        $executionKey = $this->GetExecutionKey($payIn);
        return $this->CreateObject('payins_' . $paymentKey . '-' . $executionKey . '_create', $payIn, '\MarketPay\PayIn', null, null, $idempotencyKey);
    }
    
    /**
     * Get pay-in object
     * @param $payInId Pay-in identifier
     * @return \MarketPay\PayIn Object returned from API
     */
    public function Get($payInId)
    {
        return $this->GetObject('payins_get', $payInId, '\MarketPay\PayIn');
    }
    
    /**
     * Create refund for pay-in object
     * @param type $payInId Pay-in identifier
     * @param \MarketPay\Refund $refund Refund object to create
     * @return \MarketPay\Refund Object returned by REST API
     */
    public function CreateRefund($payInId, $refund, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_createrefunds', $refund, '\MarketPay\Refund', $payInId, null, $idempotencyKey);
    }
    
    /**
     * WARNING!!
     * It's temporary entity and it will be removed in the future.
     * Please, contact with support before using these features or if you have any questions.
     *
     * Create new temporary immediate pay-in
     * @param \MarketPay\TemporaryImmediatePayIn $immediatePayIn Immediate pay-in object to create
     * @return \MarketPay\TemporaryImmediatePayIn Immediate pay-in object returned from API
     */
    public function CreateTemporaryImmediatePayIn($immediatePayIn, $idempotencyKey = null)
    {
        return $this->CreateObject('temp_immediatepayins_create', $immediatePayIn, '\MarketPay\TemporaryImmediatePayIn', null, null, $idempotencyKey);
    }
    
    private function GetPaymentKey($payIn)
    {
        if (!isset($payIn->PaymentDetails) || !is_object($payIn->PaymentDetails)) {
            throw new Libraries\Exception('Payment is not defined or it is not object type');
        }
        
        $className = str_replace('MarketPay\\PayInPaymentDetails', '', get_class($payIn->PaymentDetails));
        return strtolower($className);
    }
    
    private function GetExecutionKey($payIn)
    {
        if (!isset($payIn->ExecutionDetails) || !is_object($payIn->ExecutionDetails)) {
            throw new Libraries\Exception('Execution is not defined or it is not object type');
        }
        
        $className = str_replace('MarketPay\\PayInExecutionDetails', '', get_class($payIn->ExecutionDetails));
        return strtolower($className);
    }
}
