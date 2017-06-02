<?php
namespace MarketPay;

/**
 * Bank Account entity
 */
class BankAccount extends Libraries\EntityBase
{
    /**
     * User identifier
     * @var LeetchiId
     */
    public $UserId;
    
    /**
     * Type of bank account
     * @var string
     */
    public $Type;
    
    /**
     * Owner name
     * @var string
     */
    public $OwnerName;
    
    /**
     * Owner address
     * @var Address 
     */
    public $OwnerAddress;
    
     /**
     * One of BankAccountDetails implementations, depending on $Type
     * @var object
     */
    public $Details;
    
    /**
     * Get array with mapping which property is object and what type of object 
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        
        $subObjects['OwnerAddress'] = '\MarketPay\Address';
        
        return $subObjects;
    }
    
    /**
     * Get array with mapping which property depends on other property  
     * @return array
     */
    public function GetDependsObjects()
    {
        return array(
            'Type' => array(
                '_property_name' => 'Details',
                'IBAN' => '\MarketPay\BankAccountDetailsIBAN',
                'GB' => '\MarketPay\BankAccountDetailsGB',
                'US' => '\MarketPay\BankAccountDetailsUS',
                'CA' => '\MarketPay\BankAccountDetailsCA',
                'OTHER' => '\MarketPay\BankAccountDetailsOTHER',
            )
        );
    }
    
    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'UserId');
        array_push($properties, 'Type');
        return $properties;
    }
}
