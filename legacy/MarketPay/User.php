<?php

namespace MarketPay;

/**
 * User entity
 */
abstract class User extends Libraries\EntityBase
{
    /**
     * Type of user
     * @var String
     */
    public $PersonType;
    
    /**
     * Email address
     * @var String
     */
    public $Email;
    
    /**
     * KYC Level (LIGHT or REGULAR)
     * @var String
     */
    public $KYCLevel;
    
    /**
     * Construct
     * @param string $personType String with type of person
     */
    protected function SetPersonType($personType)
    {
        $this->PersonType = $personType;
    }
    
    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'PersonType');
        
        return $properties;
    }
}
