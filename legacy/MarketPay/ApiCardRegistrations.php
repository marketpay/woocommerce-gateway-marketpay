<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for card registrations
 */
class ApiCardRegistrations extends Libraries\ApiBase
{
    /**
     * Create new card registration
     * @param \MarketPay\CardRegistration $cardRegistration Card registration object to create
     * @return \MarketPay\CardRegistration Card registration object returned from API
     */
    public function Create($cardRegistration, $idempotencyKey = null)
    {
        return $this->CreateObject('cardregistration_create', $cardRegistration, '\MarketPay\CardRegistration', null, null, $idempotencyKey);
    }
    
    /**
     * Get card registration
     * @param int $cardRegistrationId Card Registration identifier
     * @return \MarketPay\CardRegistration Card registration  object returned from API
     */
    public function Get($cardRegistrationId)
    {
        return $this->GetObject('cardregistration_get', $cardRegistrationId, '\MarketPay\CardRegistration');
    }
    
    /**
     * Update card registration
     * @param \MarketPay\CardRegistration $cardRegistration Card registration object to save
     * @return \MarketPay\CardRegistration Card registration object returned from API
     */
    public function Update($cardRegistration)
    {
        return $this->SaveObject('cardregistration_save', $cardRegistration, '\MarketPay\CardRegistration');
    }
}
