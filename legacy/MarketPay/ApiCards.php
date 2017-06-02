<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for cards
 */
class ApiCards extends Libraries\ApiBase
{
    /**
     * Get card
     * @param int $cardId Card identifier
     * @return \MarketPay\Card object returned from API
     */
    public function Get($cardId)
    {
        return $this->GetObject('card_get', $cardId, '\MarketPay\Card');
    }
    
    /**
     * Update card
     * @param \MarketPay\Card $card Card object to save
     * @return \MarketPay\Card Card object returned from API
     */
    public function Update($card)
    {
        return $this->SaveObject('card_save', $card, '\MarketPay\Card');
    }
    
    /**
     * WARNING!!
     * It's temporary entity and it will be removed in the future.
     * Please, contact with support before using these features or if you have any questions.
     *
     * Create new temporary payment card
     * @param \MarketPay\TemporaryPaymentCard $paymentCard Payment card object to create
     * @return \MarketPay\TemporaryPaymentCard Card registration object returned from API
     */
    public function CreateTemporaryPaymentCard($paymentCard, $idempotencyKey = null)
    {
        return $this->CreateObject('temp_paymentcards_create', $paymentCard, '\MarketPay\TemporaryPaymentCard', null, null, $idempotencyKey);
    }
    
    /**
     * WARNING!!
     * It's temporary entity and it will be removed in the future.
     * Please, contact with support before using these features or if you have any questions.
     *
     * Get temporary payment card
     * @param string $paymentCardId Card identifier
     * @return \MarketPay\TemporaryPaymentCard object returned from API
     */
    public function GetTemporaryPaymentCard($paymentCardId)
    {
        return $this->GetObject('temp_paymentcards_get', $paymentCardId, '\MarketPay\TemporaryPaymentCard');
    }
}
