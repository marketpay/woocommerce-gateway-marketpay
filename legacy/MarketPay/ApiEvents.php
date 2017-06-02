<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for cards
 */
class ApiEvents extends Libraries\ApiBase
{
    /**
     * Get events
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\FilterEvents $filter Object to filter data
     * @param \MarketPay\Sorting $sorting Object to sorting data
     *
     * @return \MarketPay\Event[] Events list
     */
    public function GetAll(& $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('events_all', $pagination, '\MarketPay\Event', null, $filter, $sorting);
    }
}
