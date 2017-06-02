<?php

namespace MarketPay\Libraries;

/**
 * Abstract class for all documents
 */
abstract class Document extends EntityBase
{
    
    /**
     * Refused reason type
     * @var type string
     */
    public $RefusedReasonType;
    
    /**
     * Refused reason message
     * @var type string
     */
    public $RefusedReasonMessage;
    
    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'RefusedReasonType');
        array_push($properties, 'RefusedReasonMessage');
        array_push($properties, 'UserId');
        
        return $properties;
    }
}
