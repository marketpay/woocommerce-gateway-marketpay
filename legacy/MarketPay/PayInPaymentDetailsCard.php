<?php
namespace MarketPay;

/**
 * Class represents Card type for mean of payment in PayIn entity
 */
class PayInPaymentDetailsCard extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * CardType { CB_VISA_MASTERCARD, AMEX }
     * @var string
     */
    public $CardType;
    
    /**
     * CardId
     * @var string
     */
    public $CardId;
}
