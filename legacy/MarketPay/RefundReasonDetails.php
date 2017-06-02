<?php
namespace MarketPay;

/**
 * Class represents RefundReason details in Refund entity
 */
class RefundReasonDetails extends Libraries\Dto
{
    /**
     * Message about the reason for refund
     * @var string
     */
    public $RefundReasonMessage;
    
    /**
     * Type of refund reason
     * @var string
     */
    public $RefundReasonType;
}
