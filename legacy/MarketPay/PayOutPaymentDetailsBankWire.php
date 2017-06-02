<?php
namespace MarketPay;

/**
 * Class represents BankWire type for mean of payment in PayOut entity
 */
class PayOutPaymentDetailsBankWire extends Libraries\Dto implements PayOutPaymentDetails
{
    /**
     * Bank account Id
     * @var string
     */
    public $BankAccountId;
    
    /**
     * A custom reference you wish to appear on the user’s bank statement
     * @var string
     */
    public $BankWireRef;
}
