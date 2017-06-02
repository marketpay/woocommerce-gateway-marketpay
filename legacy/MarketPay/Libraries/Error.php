<?php

namespace MarketPay\Libraries;

/**
 * Class represents error object
 */
class Error
{
    /**
     * Error message
     * @var String
     * @access public
     */
    public $Message;
        
    /**
     * Array with errors information
     * @var KeyValueArray
     * @access public
     */
    public $Errors;
}
