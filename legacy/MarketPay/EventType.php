<?php
namespace MarketPay;

/**
 * Event types
 */
class EventType
{
    const KycCreated = "KYC_CREATED";
    const KycSucceeded = "KYC_SUCCEEDED";
    const KycFailed = "KYC_FAILED";
    const KycValidationAsked  = "KYC_VALIDATION_ASKED";
    const PayinNormalCreated = "PAYIN_NORMAL_CREATED";
    const PayinNormalSucceeded = "PAYIN_NORMAL_SUCCEEDED";
    const PayinNormalFailed = "PAYIN_NORMAL_FAILED";
    const PayoutNormalCreated = "PAYOUT_NORMAL_CREATED";
    const PayoutNormalSucceeded = "PAYOUT_NORMAL_SUCCEEDED";
    const PayoutNormalFailed = "PAYOUT_NORMAL_FAILED";
    const TransferNormalCreated = "TRANSFER_NORMAL_CREATED";
    const TransferNormalSucceeded = "TRANSFER_NORMAL_SUCCEEDED";
    const TransferNormalFailed = "TRANSFER_NORMAL_FAILED";
    const PayinRefundCreated = "PAYIN_REFUND_CREATED";
    const PayinRefundSucceeded = "PAYIN_REFUND_SUCCEEDED";
    const PayinRefundFailed = "PAYIN_REFUND_FAILED";
    const PayoutRefundCreated = "PAYOUT_REFUND_CREATED";
    const PayoutRefundSucceeded = "PAYOUT_REFUND_SUCCEEDED";
    const PayoutRefundFailed = "PAYOUT_REFUND_FAILED";
    const TransferRefundCreated = "TRANSFER_REFUND_CREATED";
    const TransferRefundSucceeded = "TRANSFER_REFUND_SUCCEEDED";
    const TransferRefundFailed = "TRANSFER_REFUND_FAILED";
    
    const PayinRepudiationCreated = "PAYIN_REPUDIATION_CREATED";
    const PayinRepudiationSucceeded = "PAYIN_REPUDIATION_SUCCEEDED";
    const PayinRepudiationFailed = "PAYIN_REPUDIATION_FAILED";
    const DisputeDocumentCreated = "DISPUTE_DOCUMENT_CREATED";
    const DisputeDocumentValidationAsked = "DISPUTE_DOCUMENT_VALIDATION_ASKED";
    const DisputeDocumentSucceeded = "DISPUTE_DOCUMENT_SUCCEEDED";
    const DisputeDocumentFailed = "DISPUTE_DOCUMENT_FAILED";
    const DisputeCreated = "DISPUTE_CREATED";
    const DisputeSubmitted = "DISPUTE_SUBMITTED";
    const DisputeActionRequired = "DISPUTE_ACTION_REQUIRED";
    const DisputeFurtherActionRequired = "DISPUTE_FURTHER_ACTION_REQUIRED";
    const DisputeClosed = "DISPUTE_CLOSED";
    const DisputeSentToBank = "DISPUTE_SENT_TO_BANK";
    const TransferSettlementCreated = "TRANSFER_SETTLEMENT_CREATED";
    const TransferSettlementSucceeded = "TRANSFER_SETTLEMENT_SUCCEEDED";
    const TransferSettlementFailed = "TRANSFER_SETTLEMENT_FAILED";
}
