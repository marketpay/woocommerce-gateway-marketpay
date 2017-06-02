<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for transfers
 */
class ApiTransfers extends Libraries\ApiBase
{
    /**
     * Create new transfer
     * @param \MarketPay\Transfer $transfer
     * @return \MarketPay\Transfer Transfer object returned from API
     */
    public function Create($transfer, $idempotencyKey = null)
    {
        return $this->CreateObject('transfers_create', $transfer, '\MarketPay\Transfer', null, null, $idempotencyKey);
    }
    
    /**
     * Get transfer
     * @param type $transferId Transfer identifier
     * @return \MarketPay\Transfer Transfer object returned from API
     */
    public function Get($transfer)
    {
        return $this->GetObject('transfers_get', $transfer, '\MarketPay\Transfer');
    }
    
    /**
     * Create refund for transfer object
     * @param type $transferId Transfer identifier
     * @param \MarketPay\Refund $refund Refund object to create
     * @return \MarketPay\Refund Object returned by REST API
     */
    public function CreateRefund($transferId, $refund, $idempotencyKey = null)
    {
        return $this->CreateObject('transfers_createrefunds', $refund, '\MarketPay\Refund', $transferId, null, $idempotencyKey);
    }
}
