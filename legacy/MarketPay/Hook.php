<?php
namespace MarketPay;

/**
 * Hooks and Notifications entity
 */
class Hook extends Libraries\EntityBase
{
    /**
     * This is the URL where your receive notification for each EventType
     * @var string
     */
    public $Url;
        
    /**
     * Status: ENABLED, DISABLED
     * @var string
     */
    public $Status;
    
    /**
     * Validity: VALID, INVALID
     * @var string
     */
    public $Validity;
    
    /**
     * EventType
     * @var EventType
     */
    public $EventType;
}
