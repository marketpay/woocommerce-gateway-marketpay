<?php
namespace MarketPay;

/**
 * Class represents Web type for execution option in PayIn entity
 */
class PayInExecutionDetailsDirect extends Libraries\Dto implements PayInExecutionDetails
{
    /**
     * SecureMode { DEFAULT, FORCE }
     * @var string
     */
    public $SecureMode;
    
    /**
     * SecureModeReturnURL
     * @var string
     */
    public $SecureModeReturnURL;
    
    /**
     * SecureModeRedirectURL
     * @var string
     */
    public $SecureModeRedirectURL;
    
     /**
     * SecureModeNeeded
     * @var string
     */
    public $SecureModeNeeded;
}
