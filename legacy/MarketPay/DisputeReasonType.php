<?php
namespace MarketPay;

/**
 * Dispute reason types
 */
class DisputeReasonType
{
    const Duplicate = "DUPLICATE";
    const Fraud = "FRAUD";
    const ProductUnacceptable = "PRODUCT_UNACCEPTABLE";
    const Unknown = "UNKNOWN";
    const Other = "OTHER";
    const RefundConversionRate = "REFUND_CONVERSION_RATE";
}
