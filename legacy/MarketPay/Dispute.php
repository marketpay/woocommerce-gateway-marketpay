<?php
namespace MarketPay;

/**
 * Dispute entity
 */
class Dispute extends Libraries\EntityBase
{
    
    /**
     * Identifier of the transaction that was disputed
     * @var string
     */
    public $InitialTransactionId;

    /**
     * The type of transaction that is disputed
     * @var string
     */
    public $InitialTransactionType;

     /**
     * The type of dispute
     * @var \MarketPay\DisputeType
     */
    public $DisputeType;

    /**
     * The date by which you must submit docs if they wish to contest the dispute
     * @var date
     */
    public $ContestDeadlineDate;

    /**
     * Dispute's reason
     * @var \MarketPay\DisputeReason
     */
    public $DisputeReason;

    /**
     * Disputed funds
     * @var \MarketPay\Money
     */
    public $DisputedFunds;

    /**
     * Contested funds
     * @var \MarketPay\Money
     */
    public $ContestedFunds;

    /**
     * The current status of the dispute
     * @var \MarketPay\DisputeStatus
     */
    public $Status;

    /**
     * Free text used when reopening the dispute
     * @var string
     */
    public $StatusMessage;

    /**
     * The outcome of the dispute – will be null until closed, and then one of WON, LOST or VOID
     * @var string
     */
    public $ResultCode;

    /**
     * The field that may be used to give more info about the end result
     * @var string
     */
    public $ResultMessage;
    
    /**
     * Get array with mapping which property is object and what type of object 
     * @return array
     */
    public function GetSubObjects()
    {
        return array(
            'DisputeReason' => '\MarketPay\DisputeReason',
            'DisputedFunds' => '\MarketPay\Money',
            'ContestedFunds' => '\MarketPay\Money'
            );
    }
    
    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'InitialTransactionId');
        array_push($properties, 'InitialTransactionType');
        array_push($properties, 'DisputeType');
        array_push($properties, 'ContestDeadlineDate');
        array_push($properties, 'DisputeReason');
        array_push($properties, 'DisputedFunds');
        array_push($properties, 'Status');
        array_push($properties, 'StatusMessage');
        array_push($properties, 'ResultCode');
        array_push($properties, 'ResultMessage');
        
        return $properties;
    }
}
