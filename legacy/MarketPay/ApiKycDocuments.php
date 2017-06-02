<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for KYC document list
 */
class ApiKycDocuments extends Libraries\ApiBase
{
    /**
     * Get all KYC documents
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\Sorting $sorting Object to sorting data
     * @param \MarketPay\FilterKycDocuments $filter Object to filter data
     * @return \MarketPay\KycDocument[] Array with objects returned from API
     */
    public function GetAll(& $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('kyc_documents_all', $pagination, '\MarketPay\KycDocument', null, $filter, $sorting);
    }
    
     /**
     * Get KYC document
     * @param string $kycDocumentId Document identifier
     * @return \MarketPay\KycDocument Document returned from API
     */
    public function Get($kycDocumentId)
    {
        return $this->GetObject('kyc_documents_get_alt', $kycDocumentId, '\MarketPay\KycDocument');
    }
}
