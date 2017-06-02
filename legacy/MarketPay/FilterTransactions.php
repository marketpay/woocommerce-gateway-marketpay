<?php
namespace MarketPay;

/**
 * Filter for transaction list
 */
class FilterTransactions extends FilterBase
{
    /**
     * TransactionStatus {CREATED, SUCCEEDED, FAILED}
     * @var string
     */
    public $Status;
    
    /**
     * TransactionType {PAYIN, PAYOUT, TRANSFER}
     * @var string
     */
    public $Type;
    
    /**
     * TransactionNature {REGULAR, REFUND, REPUDIATION, SETTLEMENT}
     * @var string
     */
    public $Nature;
}
