<?php
namespace MarketPay;

/**
 * Response entity
 */
class Response extends Libraries\Dto
{
    
    /**
     * Status code
     * @var string
     */
    public $StatusCode;
    
    /**
     * Content length
     * @var string
     */
    public $ContentLength;
    
    /**
     * Content type
     * @var string
     */
    public $ContentType;
    
    /**
     * Date
     * @var string
     */
    public $Date;
    
    /**
     * Entity or response data (JSON-serialized)
     * @var string
     */
    public $Resource;
}
