<?php
namespace MarketPay;

/**
 * Refund entity
 */
class Refund extends Transaction
{
    /**
     * Initial transaction Id
     * @var string
     */
    public $InitialTransactionId;

    /**
     * Initial transaction Type {PAYIN, PAYOUT, TRANSFER}
     * @var string
     */
    public $InitialTransactionType;
    
    /**
     * Debited wallet Id
     * @var string
     */
    public $DebitedWalletId;
    
    /**
     * Credited wallet Id
     * @var string
     */
    public $CreditedWalletId;

    /**
     * Contains info about the reason for refund
     * @var \MarketPay\RefundReasonDetails
     */
    public $RefundReason;
    
    /**
     * Get array with mapping which property is object and what type of object
     *
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['RefundReason'] = '\MarketPay\RefundReasonDetails';
        
        return $subObjects;
    }
}
