<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for pre-authorization process
 */
class ApiCardPreAuthorizations extends Libraries\ApiBase
{
    /**
     * Create new pre-authorization object
     * @param \MarketPay\CardPreAuthorization $cardPreAuthorization PreAuthorization object to create
     * @return \MarketPay\CardPreAuthorization PreAuthorization object returned from API
     */
    public function Create($cardPreAuthorization, $idempotencyKey = null)
    {
        return $this->CreateObject('preauthorization_create', $cardPreAuthorization, '\MarketPay\CardPreAuthorization', null, null, $idempotencyKey);
    }
    
    /**
     * Get pre-authorization object
     * @param int $cardPreAuthorizationId PreAuthorization identifier
     * @return \MarketPay\CardPreAuthorization Card registration  object returned from API
     */
    public function Get($cardPreAuthorizationId)
    {
        return $this->GetObject('preauthorization_get', $cardPreAuthorizationId, '\MarketPay\CardPreAuthorization');
    }
    
    /**
     * Update pre-authorization object
     * @param \MarketPay\CardPreAuthorization $preAuthorization PreAuthorization object to save
     * @return \MarketPay\CardPreAuthorization PreAuthorization object returned from API
     */
    public function Update($cardPreAuthorization)
    {
        return $this->SaveObject('preauthorization_save', $cardPreAuthorization, '\MarketPay\CardPreAuthorization');
    }
}
