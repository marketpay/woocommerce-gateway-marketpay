<?php
namespace MarketPay;

/**
 * Client entity
 */
class Client extends Libraries\EntityBase
{
    /**
     * Client identifier
     * @var String
     */
    public $ClientId;
    
    /**
     * Name of client
     * @var String
     */
    public $Name;
    
    /**
     * Email of client
     * @var String
     */
    public $Email;
    
    /**
     * Password for client
     * @var String
     */
    public $Passphrase;
}
