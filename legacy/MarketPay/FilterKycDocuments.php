<?php
namespace MarketPay;

/**
 * Filter for event list
 */
class FilterKycDocuments extends FilterBase
{
    
    /**
     * KycDocumentStatus {CREATED, VALIDATION_ASKED, VALIDATED, REFUSED}
     * @var string
     */
    public $Status;
    
    /**
     * KycDocumentType {IDENTITY_PROOF, REGISTRATION_PROOF, ARTICLES_OF_ASSOCIATION, SHAREHOLDER_DECLARATION, ADDRESS_PROOF}
     * @var string 
     */
    public $Type;
}
