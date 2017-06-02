<?php
namespace MarketPay;

/**
 * Transaction entity.
 * Base class for: PayIn, PayOut, Transfer.
 */
class Transaction extends Libraries\EntityBase
{
    /**
     * Author Id
     * @var int
     */
    public $AuthorId;
    
    /**
     * Credited user Id
     * @var int
     */
    public $CreditedUserId;
    
    /**
     * Debited funds
     * @var \MarketPay\Money
     */
    public $DebitedFunds;
    
    /**
     * Credited funds
     * @var \MarketPay\Money
     */
    public $CreditedFunds;
    
    /**
     * Fees
     * @var \MarketPay\Money
     */
    public $Fees;
    
    /**
     * TransactionStatus {CREATED, SUCCEEDED, FAILED}
     * @var string
     */
    public $Status;
    
    /**
     * Result code
     * @var string
     */
    public $ResultCode;
    
    /**
     * The PreAuthorization result Message explaining the result code
     * @var string
     */
    public $ResultMessage;
    
    /**
     * Execution date;
     * @var date
     */
    public $ExecutionDate;
    
    /**
     * TransactionType {PAYIN, PAYOUT, TRANSFER}
     * @var string
     */
    public $Type;
    
    /**
     * TransactionNature { REGULAR, REFUND, REPUDIATION, SETTLEMENT }
     * @var string
     */
    public $Nature;
    
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
    
    /**
     * Get array with mapping which property is object and what type of object 
     * @return array
     */
    public function GetSubObjects()
    {
        return array(
            'DebitedFunds' => '\MarketPay\Money' ,
            'CreditedFunds' => '\MarketPay\Money' ,
            'Fees' => '\MarketPay\Money'
        );
    }
    
    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'Status');
        array_push($properties, 'ResultCode');
        array_push($properties, 'ExecutionDate');
        
        return $properties;
    }
}
