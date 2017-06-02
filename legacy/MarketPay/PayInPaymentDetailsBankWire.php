<?php
namespace MarketPay;

/**
 * Class represents BankWire type for mean of payment in PayIn entity
 */
class PayInPaymentDetailsBankWire extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Declared debited funds
     * @var \MarketPay\Money
     */
    public $DeclaredDebitedFunds;

    /**
     * Declared fees
     * @var \MarketPay\Money
     */
    public $DeclaredFees;

    /**
     * Bank account details
     * @var \MarketPay\BankAccount
     */
    public $BankAccount;
    
    /**
     * Wire reference
     * @var string
     */
    public $WireReference;
    
    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        return array(
            'DeclaredDebitedFunds' => '\MarketPay\Money' ,
            'DeclaredFees' => '\MarketPay\Money' ,
            'BankAccount' => '\MarketPay\BankAccount'
        );
    }
}
