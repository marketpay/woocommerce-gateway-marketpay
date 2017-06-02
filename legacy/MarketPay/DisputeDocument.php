<?php
namespace MarketPay;

/**
 * Dispute document entity
 */
class DisputeDocument extends Libraries\Document
{
    
    /**
     * Type of dispute document
     * @var \MarketPay\DisputeDocumentType
     */
    public $Type;
    
    /**
     * Status of dispute document
     * @var \MarketPay\DisputeDocumentStatus
     */
    public $Status;
}
