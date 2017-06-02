<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for wallets
 */
class ApiWallets extends Libraries\ApiBase
{
    /**
     * Create new wallet
     * @param Wallet $wallet
     * @return \MarketPay\Wallet Wallet object returned from API
     */
    public function Create($wallet, $idempotencyKey = null)
    {
        return $this->CreateObject('wallets_create', $wallet, '\MarketPay\Wallet', null, null, $idempotencyKey);
    }
    
    /**
     * Get wallet
     * @param int $walletId Wallet identifier
     * @return \MarketPay\Wallet Wallet object returned from API
     */
    public function Get($walletId)
    {
        return $this->GetObject('wallets_get', $walletId, '\MarketPay\Wallet');
    }
    
    /**
     * Save wallet
     * @param Wallet $wallet Wallet object to save
     * @return \MarketPay\Wallet Wallet object returned from API
     */
    public function Update($wallet)
    {
        return $this->SaveObject('wallets_save', $wallet, '\MarketPay\Wallet');
    }

    /**
     * Get transactions for the wallet
     * @param type $walletId Wallet identifier
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\FilterTransactions $filter Object to filter data
     * @param \MarketPay\Sorting $sorting Object to sorting data
     * @return \MarketPay\Transaction[] Transactions for wallet returned from API
     */
    public function GetTransactions($walletId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('wallets_alltransactions', $pagination, '\MarketPay\Transaction', $walletId, $filter, $sorting);
    }
}
