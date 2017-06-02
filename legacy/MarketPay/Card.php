<?php
namespace MarketPay;

/**
 * Card entity
 */
class Card extends Libraries\EntityBase
{
    /**
     * Expiration date
     * @var string
     */
    public $ExpirationDate;
    
    /**
     * Alias
     * @var string
     */
    public $Alias;
    
    /**
     * CardProvider
     * @var string
     */
    public $CardProvider;
    
    /**
     * UserId
     * @var string
     */
    public $UserId;
    
    /**
     * Card type
     * @var string
     */
    public $CardType;
    
    /**
     * Product
     * @var string
     */
    public $Product ;
    
    /**
     * Bank code
     * @var string
     */
    public $BankCode;
    
    /**
     * Country
     * @var string 
     */
    public $Country;
    
    /**
     * Active
     * @var bool
     */
    public $Active;
    
    /**
     * Currency
     * @var string
     */
    public $Currency;
    
    /**
     * Validity
     * @var \MarketPay\CardValidity
     */
    public $Validity;
}
