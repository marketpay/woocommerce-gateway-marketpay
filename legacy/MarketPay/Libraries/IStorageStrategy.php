<?php
namespace MarketPay\Libraries;

/**
 * Storage strategy interface.
 */
interface IStorageStrategy
{
    /**
     * Gets the current authorization token.
     * @return \MarketPay\Libraries\OAuthToken Currently stored token instance or null.
     */
    public function Get();
    
    /**
     * Stores authorization token passed as an argument.
     * @param \MarketPay\Libraries\OAuthToken $token Token instance to be stored.
     */
    public function Store($token);
}
