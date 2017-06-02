<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for disputes
 */
/**
 * Class ApiDisputes
 * @package MarketPay
 */
class ApiDisputes extends Libraries\ApiBase
{
    
    /**
     * Gets dispute
     * @param Int|GUID $disputeId Dispute identifier
     * @return \MarketPay\Dispute Dispute instance returned from API
     */
    public function Get($disputeId)
    {
        return $this->GetObject('disputes_get', $disputeId, '\MarketPay\Dispute');
    }
    
    /**
     * Get all disputes
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\Sorting $sorting Object to sorting data
     * @return array Array with disputes
     */
    public function GetAll(& $pagination = null, $sorting = null)
    {
        return $this->GetList('disputes_all', $pagination, '\MarketPay\Dispute', null, null, $sorting);
    }
    
    /**
     * Updates dispute's tag
     * @param \MarketPay\Dispute Dispute object to update
     * @return \MarketPay\Dispute Transfer instance returned from API
     */
    public function Update($dispute)
    {
        return $this->SaveObject('disputes_save_tag', $dispute, '\MarketPay\Dispute');
    }
    
    /**
     * Contests dispute
     * @param Int|GUID $disputeId Dispute identifier
     * @param \MarketPay\Money $contestedFunds Contested funds
     * @return \MarketPay\Dispute Dispute instance returned from API
     */
    public function ContestDispute($disputeId, $contestedFunds)
    {
        $dispute = new Dispute();
        $dispute->Id = $disputeId;
        $dispute->ContestedFunds = $contestedFunds;
        return $this->SaveObject('disputes_save_contest_funds', $dispute, '\MarketPay\Dispute');
    }
    
    /**
     * This method is used to resubmit a Dispute if it is reopened requiring more docs 
     * @param Int|GUID $disputeId Dispute identifier
     * @return \MarketPay\Dispute Dispute instance returned from API
     */
    public function ResubmitDispute($disputeId)
    {
        $dispute = new Dispute();
        $dispute->Id = $disputeId;
        return $this->SaveObject('disputes_save_contest_funds', $dispute, '\MarketPay\Dispute');
    }
    
    /**
     * Close dispute
     * @param Int|GUID $disputeId Dispute identifier
     * @return \MarketPay\Dispute Dispute instance returned from API
     */
    public function CloseDispute($disputeId)
    {
        $dispute = new Dispute();
        $dispute->Id = $disputeId;
        return $this->SaveObject('dispute_save_close', $dispute, '\MarketPay\Dispute');
    }
    
    /**
     * Gets dispute's transactions
     * @param Int|GUID $disputeId Dispute identifier
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\Sorting $sorting Object to sorting data
     * @return array List of Transaction instances returned from API
     */
    public function GetTransactions($disputeId, $pagination = null, $sorting = null)
    {
        return $this->GetList('disputes_get_transactions', $pagination, 'MarketPay\Transaction', $disputeId, null, $sorting);
    }
    
    /**
     * Gets dispute's documents for wallet
     * @param Int|GUID $walletId Wallet identifier
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\Sorting $sorting Object to sorting data
     * @return array List of dispute instances returned from API
     */
    public function GetDisputesForWallet($walletId, $pagination = null, $sorting = null)
    {
        return $this->GetList('disputes_get_for_wallet', $pagination, 'MarketPay\Dispute', $walletId, null, $sorting);
    }
    
    /**
     * Gets user's disputes
     * @param Int|GUID $userId User identifier
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\Sorting $sorting Object to sorting data
     * @return array List of Dispute instances returned from API
     */
    public function GetDisputesForUser($userId, $pagination = null, $sorting = null)
    {
        return $this->GetList('disputes_get_for_user', $pagination, 'MarketPay\Dispute', $userId, null, $sorting);
    }
    
    /**
     * Gets repudiation
     * @param Int|GUID $repudiationId Repudiation identifier
     * @return \MarketPay\Repudiation Repudiation instance returned from API
     */
    public function GetRepudiation($repudiationId)
    {
        return $this->GetObject('disputes_repudiation_get', $repudiationId, 'MarketPay\Repudiation');
    }
    
    /**
     * Creates settlement transfer
     * @param \MarketPay\SettlementTransfer $settlementTransfer Settlement transfer
     * @param Int|GUID $repudiationId Repudiation identifier
     * @return \MarketPay\Transfer Transfer instance returned from API
     */
    public function CreateSettlementTransfer($settlementTransfer, $repudiationId, $idempotencyKey = null)
    {
        return $this->CreateObject('disputes_repudiation_create_settlement', $settlementTransfer, '\MarketPay\Transfer', $repudiationId, null, $idempotencyKey);
    }
    
    /**
     * Gets settlement transfer
     * @param Int|GUID $settlementTransferId Settlement transfer identifier
     * @return \MarketPay\Transfer Transfer instance returned from API
     */
    public function GetSettlementTransfer($settlementTransferId)
    {
        return $this->GetObject('disputes_repudiation_get_settlement', $settlementTransferId, '\MarketPay\Transfer');
    }
   
    /**
     * Gets documents for dispute
     * @param Int|GUID $disputeId Dispute identifier
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\Sorting $sorting Object to sorting data
     * @return array List of DisputeDocument instances returned from API
     */
    public function GetDocumentsForDispute($disputeId, $pagination = null, $sorting = null)
    {
        return $this->GetList('disputes_document_get_for_dispute', $pagination, 'MarketPay\DisputeDocument', $disputeId, null, $sorting);
    }
        
    /**
     * Update dispute document
     * @param Int|GUID $disputeId Dispute identifier
     * @param \MarketPay\DisputeDocument $disputeDocument Dispute document to save
     * @return \MarketPay\DisputeDocument Document returned from API
     */
    public function UpdateDisputeDocument($disputeId, $disputeDocument)
    {
        return $this->SaveObject('disputes_document_save', $disputeDocument, '\MarketPay\DisputeDocument', $disputeId);
    }
        
    /**
     * Creates document for dispute
     * @param Int|GUID $disputeId Dispute identifier
     * @param \MarketPay\DisputeDocument $disputeDocument Dispute document to be created
     * @return \MarketPay\DisputeDocument Dispute document returned from API
     */
    public function CreateDisputeDocument($disputeId, $disputeDocument, $idempotencyKey = null)
    {
        return $this->CreateObject('disputes_document_create', $disputeDocument, '\MarketPay\DisputeDocument', $disputeId, null, $idempotencyKey);
    }
    
    /**
     * Creates document's page for dispute
     * @param Int|GUID $disputeId Dispute identifier
     * @param Int|GUID $disputeDocumentId Dispute document identifier
     * @param \MarketPay\DisputeDocumentPage $disputeDocumentPage Dispute document page object
     */
    public function CreateDisputeDocumentPage($disputeId, $disputeDocumentId, $disputeDocumentPage, $idempotencyKey = null)
    {
        try {
            $this->CreateObject('disputes_document_page_create', $disputeDocumentPage, null, $disputeId, $disputeDocumentId, $idempotencyKey);
        } catch (\MarketPay\Libraries\ResponseException $exc) {
            if ($exc->getCode() != 204) {
                throw $exc;
            }
        }
    }
    
    /**
     * Creates document's page for dispute from file
     * @param Int|GUID $disputeId Dispute identifier
     * @param Int|GUID $disputeDocumentId Dispute document identifier
     * @param string $file File path
     * @throws \MarketPay\Libraries\Exception
     */
    public function CreateDisputeDocumentPageFromFile($disputeId, $disputeDocumentId, $file, $idempotencyKey = null)
    {
        $filePath = $file;
        if (is_array($file)) {
            $filePath = $file['tmp_name'];
        }
        
        if (empty($filePath)) {
            throw new \MarketPay\Libraries\Exception('Path of file cannot be empty');
        }
        
        if (!file_exists($filePath)) {
            throw new \MarketPay\Libraries\Exception('File not exist');
        }
        
        $disputeDocumentPage = new \MarketPay\DisputeDocumentPage();
        $disputeDocumentPage->File = base64_encode(file_get_contents($filePath));
        
        if (empty($disputeDocumentPage->File)) {
            throw new \MarketPay\Libraries\Exception('Content of the file cannot be empty');
        }
        
        $this->CreateDisputeDocumentPage($disputeId, $disputeDocumentId, $disputeDocumentPage, $idempotencyKey);
    }
}
