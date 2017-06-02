<?php
namespace MarketPay;

/**
 * Transfer entity
 */
class Transfer extends Transaction
{
    /**
     * Debited wallet Id
     * @var int
     */
    public $DebitedWalletId;
    
    /**
     * Credited wallet Id
     * @var int
     */
    public $CreditedWalletId;
}
