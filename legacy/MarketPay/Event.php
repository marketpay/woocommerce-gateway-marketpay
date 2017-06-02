<?php
namespace MarketPay;

/**
 * Event entity
 */
class Event extends Libraries\Dto
{
    /**
     * Resource ID
     * @var string
     */
    public $ResourceId;
    
    /**
     * Event type
     * @var \MarketPay\EventType
     */
    public $EventType;
        
    /**
     * Date of event
     * @var Date
     */
    public $Date;
}
