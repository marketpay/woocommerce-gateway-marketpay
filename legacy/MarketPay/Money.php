<?php

namespace MarketPay;

/**
 * Class represents money value with currency
 */
class Money extends Libraries\Dto
{
    /**
     * Text with currency code with ISO 4217 standard
     * @var String
     */
    public $Currency;
    
    /**
     * The currency amount of money
     * @var Long
     */
    public $Amount;
}
