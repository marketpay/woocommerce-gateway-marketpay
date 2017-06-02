<?php
namespace MarketPay;

/**
 * Class represents IBAN bank account type for in BankAccount entity
 */
class BankAccountDetailsIBAN extends Libraries\Dto implements BankAccountDetails
{
    /**
     * IBAN number
     * @var string
     */
    public $IBAN;
    
    /**
     * BIC
     * @var string
     */
    public $BIC;
}
