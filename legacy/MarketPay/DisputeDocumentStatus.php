<?php
namespace MarketPay;

/**
 * Dispute document statuses
 */
class DisputeDocumentStatus
{
    const Created = "CREATED";
    const ValidationAsked = "VALIDATION_ASKED";
    const Validated = "VALIDATED";
    const Refused = "REFUSED";
}
