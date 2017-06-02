<?php
namespace MarketPay;

/**
 * Dispute statuses
 */
class DisputeStatus
{
    const Created = "CREATED";
    const PendingClientAction = "PENDING_CLIENT_ACTION";
    const Submitted = "SUBMITTED";
    const PendingBankAction = "PENDING_BANK_ACTION";
    const ReopenedPendingClientAction = "REOPENED_PENDING_CLIENT_ACTION";
    const Closed = "CLOSED";
}
