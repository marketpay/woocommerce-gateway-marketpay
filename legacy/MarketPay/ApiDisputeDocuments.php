<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for dispute documents
 */
/**
 * Class ApiDisputeDocuments
 * @package MarketPay
 */
class ApiDisputeDocuments extends Libraries\ApiBase
{
    
    /**
     * Gets dispute's document
     * @param Int|GUID $documentId Dispute's document identifier
     * @return \MarketPay\DisputeDocument Dispute's document object returned from API
     */
    public function Get($documentId)
    {
        return $this->GetObject('disputes_document_get', $documentId, 'MarketPay\DisputeDocument');
    }
    /**
     * Gets dispute's documents for client
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\Sorting $sorting Object to sorting data
     * @return array List of dispute documents returned from API
     */
    public function GetAll($pagination = null, $sorting = null)
    {
        return $this->GetList('disputes_document_all', $pagination, 'MarketPay\DisputeDocument', null, null, $sorting);
    }
}
