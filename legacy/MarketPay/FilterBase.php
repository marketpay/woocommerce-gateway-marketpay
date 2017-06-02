<?php
namespace MarketPay;

/**
 * Base filter object
 */
class FilterBase extends Libraries\Dto
{
    /**
     * Start date in unix format:
     * return only records that have CreationDate BEFORE this date
     * @var time
     */
    public $BeforeDate;
    
    /**
     * End date in unix format:
     * return only records that have CreationDate AFTER this date
     * @var time
     */
    public $AfterDate;
}
