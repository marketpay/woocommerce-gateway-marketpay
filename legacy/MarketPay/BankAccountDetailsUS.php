<?php
namespace MarketPay;

/**
 * Class represents US bank account type for in BankAccount entity
 */
class BankAccountDetailsUS extends Libraries\Dto implements BankAccountDetails
{
    /**
     * Account number
     * @var string
     */
    public $AccountNumber;
    
    /**
     * ABA
     * @var string
     */
    public $ABA;
    
    /**
     * DepositAccountType { CHECKING, SAVINGS }
     * @var string
     */
    public $DepositAccountType;
}
