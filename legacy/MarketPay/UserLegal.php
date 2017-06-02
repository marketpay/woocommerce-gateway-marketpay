<?php
namespace MarketPay;

/**
 * UserLegal entity
 */
class UserLegal extends User
{
    /**
     * Name of user
     * @var String
     */
    public $Name;
    
    /**
     * Type for legal user. Possible: ‘BUSINESS’, ’ORGANIZATION’
     * @var String
     */
    public $LegalPersonType;
    
    /**
     * 
     * @var Address 
     */
    public $HeadquartersAddress;
    
    /**
     *
     * @var String
     */
    public $LegalRepresentativeFirstName;
    
    /**
     *
     * @var String
     */
    public $LegalRepresentativeLastName;
    
    /**
     * 
     * @var Address 
     */
    public $LegalRepresentativeAddress;
    
    /**
     *
     * @var String
     */
    public $LegalRepresentativeEmail;
    
    /**
     *
     * @var Unix timestamp
     */
    public $LegalRepresentativeBirthday;
    
    /**
     *
     * @var String
     */
    public $LegalRepresentativeNationality;
    
    /**
     *
     * @var String
     */
    public $LegalRepresentativeCountryOfResidence;
        
    /**
     *
     * @var String
     */
    public $ProofOfIdentity;
    
    /**
     *
     * @var String
     */
    public $Statute;
    
    /**
     *
     * @var String
     */
    public $ProofOfRegistration;
    
    /**
     *
     * @var String
     */
    public $ShareholderDeclaration;
    
    /**
     * Construct
     */
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->SetPersonType(PersonType::Legal);
    }
    
    /**
     * Get array with mapping which property is object and what type of object 
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        
        $subObjects['HeadquartersAddress'] = '\MarketPay\Address';
        $subObjects['LegalRepresentativeAddress'] = '\MarketPay\Address';
        
        return $subObjects;
    }
    
    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'Statute');
        array_push($properties, 'ProofOfRegistration');
        array_push($properties, 'ShareholderDeclaration');
        
        return $properties;
    }
}
