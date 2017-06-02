<?php
namespace MarketPay;

/**
 * Settlement transfer entity.
 */
class SettlementTransfer extends Libraries\EntityBase
{
    
    /**
     * The Id of the author of the original PayIn that was repudiated
     * @var string
     */
    public $AuthorId;
    
    /**
     * The funds debited from the debited wallet
     * @var \MarketPay\Money
     */
    public $DebitedFunds;
    
    /**
     * The amount you wish to charge for this settlement. 
     * This can be equal to 0, or more than 0 to charge for the settlement 
     * or less than 0 to refund some of the original Fees that were taken 
     * on the original settlement (eg DebitedFunds of 1000 and 
     * Fees of -200 will transfer 800 from the original wallet 
     * to the credit wallet, and transfer 200 from your Fees 
     * wallet to your Credit wallet
     * @var \MarketPay\Money
     */
    public $Fees;
    
    /**
     * Get array with mapping which property is object and what type of object 
     * @return array
     */
    public function GetSubObjects()
    {
        return array(
            'DebitedFunds' => '\MarketPay\Money' ,
            'Fees' => '\MarketPay\Money'
        );
    }
}
