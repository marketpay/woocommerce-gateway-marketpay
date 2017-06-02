<?php

namespace MarketPay;

/**
 * Class represents an address.
 */
class Address extends Libraries\Dto
{
    
    /**
     * Address line 1.
     * @var String
     */
    public $AddressLine1;

    /**
     * Address line 2.
     * @var String
     */
    public $AddressLine2;

    /**
     * City.
     * @var String
     */
    public $City;

    /**
     * Region.
     * @var String
     */
    public $Region;

    /**
     * Postal code.
     * @var String
     */
    public $PostalCode;

    /**
     * Country.
     * @var String
     */
    public $Country;
}
