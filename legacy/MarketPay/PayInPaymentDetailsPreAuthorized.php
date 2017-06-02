<?php
namespace MarketPay;

/**
 * Class represents Web type for execution option in PayIn entity
 */
class PayInPaymentDetailsPreAuthorized extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * The ID of the Preauthorization object
     * @var string
     */
    public $PreauthorizationId;
}
