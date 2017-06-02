<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for hooks and notifications
 */
class ApiHooks extends Libraries\ApiBase
{
    /**
     * Create new hook
     * @param Hook $hook
     * @return \MarketPay\Hook Hook object returned from API
     */
    public function Create($hook, $idempotencyKey = null)
    {
        return $this->CreateObject('hooks_create', $hook, '\MarketPay\Hook', null, null, $idempotencyKey);
    }
    
    /**
     * Get hook
     * @param type $hookId Hook identifier
     * @return \MarketPay\Hook Wallet object returned from API
     */
    public function Get($hookId)
    {
        return $this->GetObject('hooks_get', $hookId, '\MarketPay\Hook');
    }
    
    /**
     * Save hook
     * @param type $hook Hook object to save
     * @return \MarketPay\Hook Hook object returned from API
     */
    public function Update($hook)
    {
        return $this->SaveObject('hooks_save', $hook, '\MarketPay\Hook');
    }
    
    /**
     * Get all hooks
     * @param \MarketPay\Pagination $pagination Pagination object
     * @return \MarketPay\Hook[] Array with objects returned from API
     */
    public function GetAll(& $pagination = null)
    {
        return $this->GetList('hooks_all', $pagination, '\MarketPay\Hook');
    }
}
