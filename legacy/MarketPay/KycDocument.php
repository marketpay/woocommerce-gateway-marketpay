<?php
namespace MarketPay;

/**
 * KYC document entity
 */
class KycDocument extends Libraries\Document
{
    /**
     * Document type
     * @var \MarketPay\KycDocumentType
     */
    public $Type;
    
    /**
     * Document status
     * @var \MarketPay\KycDocumentStatus
     */
    public $Status;
    
    /**
     * User identifier
     * @var type string
     */
    public $UserId;
}
