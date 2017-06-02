<?php
namespace MarketPay;

/**
 * Dispute document types
 */
class DisputeDocumentType
{
    const DeliveryProof = "DELIVERY_PROOF";
    const Invoice = "INVOICE";
    const RefundProof = "REFUND_PROOF";
    const UserCorrespondance = "USER_CORRESPONDANCE";
    const UserAcceptanceProof = "USER_ACCEPTANCE_PROOF";
    const ProductReplacementProof = "PRODUCT_REPLACEMENT_PROOF";
    const Other = "OTHER";
}
