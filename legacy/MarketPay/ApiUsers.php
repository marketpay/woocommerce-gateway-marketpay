<?php
namespace MarketPay;

/**
 * Class to management MarketPay API for users
 */
/**
 * Class ApiUsers
 * @package MarketPay
 */
class ApiUsers extends Libraries\ApiBase
{
    /**
     * Create a new user
     * @param UserLegal/UserNatural $user
     * @return UserLegal/UserNatural User object returned from API
     * @throws Libraries\Exception If occur Wrong entity class for user
     */
    public function Create($user, $idempotencyKey = null)
    {
        $className = get_class($user);
        if ($className == 'MarketPay\UserNatural') {
            $methodKey = 'users_createnaturals';
        } elseif ($className == 'MarketPay\UserLegal') {
            $methodKey = 'users_createlegals';
        } else {
            throw new Libraries\Exception('Wrong entity class for user');
        }
        
        $response = $this->CreateObject($methodKey, $user, null, null, null, $idempotencyKey);
        return $this->GetUserResponse($response);
    }
    
    /**
     * Get all users
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\Sorting $sorting Object to sorting data
     * @return array Array with users
     */
    public function GetAll(& $pagination = null, $sorting = null)
    {
        $usersList = $this->GetList('users_all', $pagination, null, null, null, $sorting);
        
        $users = array();
        if (is_array($usersList)) {
            foreach ($usersList as $user) {
                array_push($users, $this->GetUserResponse($user));
            }
        }
        return $users;
    }
    
    /**
     * Get natural or legal user by ID
     * @param Int|GUID $userId User identifier
     * @return UserLegal | UserNatural User object returned from API
     */
    public function Get($userId)
    {
        $response = $this->GetObject('users_get', $userId);
        return $this->GetUserResponse($response);
    }
    
    /**
     * Get natural user by ID
     * @param Int|GUID $userId User identifier
     * @return UserLegal|UserNatural User object returned from API
     */
    public function GetNatural($userId)
    {
        $response = $this->GetObject('users_getnaturals', $userId);
        return $this->GetUserResponse($response);
    }
    
    /**
     * Get legal user by ID
     * @param Int|GUID $userId User identifier
     * @return UserLegal|UserNatural User object returned from API
     */
    public function GetLegal($userId)
    {
        $response = $this->GetObject('users_getlegals', $userId);
        return $this->GetUserResponse($response);
    }
    
    /**
     * Save user
     * @param UserLegal|UserNatural $user
     * @return UserLegal|UserNatural User object returned from API
     * @throws Libraries\Exception If occur Wrong entity class for user
     */
    public function Update($user)
    {
        $className = get_class($user);
        if ($className == 'MarketPay\UserNatural') {
            $methodKey = 'users_savenaturals';
        } elseif ($className == 'MarketPay\UserLegal') {
            $methodKey = 'users_savelegals';
        } else {
            throw new Libraries\Exception('Wrong entity class for user');
        }
        
        $response = $this->SaveObject($methodKey, $user);
        return $this->GetUserResponse($response);
    }
    
    /**
     * Create bank account for user
     * @param int $userId User Id
     * @param \MarketPay\BankAccount $bankAccount Entity of bank account object
     * @return \MarketPay\BankAccount Create bank account object
     */
    public function CreateBankAccount($userId, $bankAccount, $idempotencyKey = null)
    {
        $type = $this->GetBankAccountType($bankAccount);
        return $this->CreateObject('users_createbankaccounts_' . $type, $bankAccount, '\MarketPay\BankAccount', $userId, null, $idempotencyKey);
    }
    
    /**
     * Get all bank accounts for user
     * @param int $userId User Id
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\Sorting $sorting Object to sorting data
     *
     * @return array Array with bank account entities
     */
    public function GetBankAccounts($userId, & $pagination = null, $sorting = null)
    {
        return $this->GetList('users_allbankaccount', $pagination, 'MarketPay\BankAccount', $userId, null, $sorting);
    }
    
    /**
     * Get bank account for user
     * @param int $userId User Id
     * @param int $bankAccountId Bank account Id
     *
     * @return \MarketPay\BankAccount Entity of bank account object
     */
    public function GetBankAccount($userId, $bankAccountId)
    {
        return $this->GetObject('users_getbankaccount', $userId, 'MarketPay\BankAccount', $bankAccountId);
    }
    
    /**
     * Get all wallets for user
     * @param int $userId User Id
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\Sorting $sorting Object to sorting data
     *
     * @return \MarketPay\Wallet[] Array with objects returned from API
     */
    public function GetWallets($userId, & $pagination = null, $sorting = null)
    {
        return $this->GetList('users_allwallets', $pagination, 'MarketPay\Wallet', $userId, null, $sorting);
    }
        
    /**
     * Get all transactions for user
     * @param int $userId User Id
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\FilterTransactions $filter Object to filter data
     * @param \MarketPay\Sorting $sorting Object to sorting data
     *
     * @return \MarketPay\Transaction[] Transactions for user returned from API
     */
    public function GetTransactions($userId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('users_alltransactions', $pagination, '\MarketPay\Transaction', $userId, $filter, $sorting);
    }
    
    /**
     * Get all cards for user
     * @param int $userId User Id
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\Sorting $sorting Object to sorting data
     *
     * @return \MarketPay\Card[] Cards for user returned from API
     */
    public function GetCards($userId, & $pagination = null, $sorting = null)
    {
        return $this->GetList('users_allcards', $pagination, '\MarketPay\Card', $userId, null, $sorting);
    }
    
    /**
     * Create new KYC document
     * @param int $userId User Id
     * @param \MarketPay\KycDocument $kycDocument
     * @return \MarketPay\KycDocument Document returned from API
     */
    public function CreateKycDocument($userId, $kycDocument, $idempotencyKey = null)
    {
        return $this->CreateObject('kyc_documents_create', $kycDocument, '\MarketPay\KycDocument', $userId, null, $idempotencyKey);
    }
    
    /**
     * Get all KYC documents for user
     * @param int $userId User Id
     * @param \MarketPay\Pagination $pagination Pagination object
     * @param \MarketPay\Sorting $sorting Object to sorting data
     * @param \MarketPay\FilterKycDocuments $filter Object to filter data
     * 
     * @return array Array with KYC documents entities
     */
    public function GetKycDocuments($userId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('users_allkycdocuments', $pagination, 'MarketPay\KycDocument', $userId, $filter, $sorting);
    }
    
    /**
     * Get KYC document
     * @param int $userId User Id
     * @param string $kycDocumentId Document identifier
     * @return \MarketPay\KycDocument Document returned from API
     */
    public function GetKycDocument($userId, $kycDocumentId)
    {
        return $this->GetObject('kyc_documents_get', $userId, '\MarketPay\KycDocument', $kycDocumentId);
    }
    
    /**
     * Save KYC document
     * @param int $userId User Id
     * @param \MarketPay\KycDocument $kycDocument Document to save
     * @return \MarketPay\KycDocument Document returned from API
     */
    public function UpdateKycDocument($userId, $kycDocument)
    {
        return $this->SaveObject('kyc_documents_save', $kycDocument, '\MarketPay\KycDocument', $userId);
    }
    
    /**
     * Create page for Kyc document
     * @param int $userId User Id
     * @param int $kycDocumentId KYC Document Id
     * @param \MarketPay\KycPage $kycPage KYC Page
     * @throws \MarketPay\Libraries\Exception
     */
    public function CreateKycPage($userId, $kycDocumentId, $kycPage, $idempotencyKey = null)
    {
        try {
            $this->CreateObject('kyc_page_create', $kycPage, null, $userId, $kycDocumentId, $idempotencyKey);
        } catch (\MarketPay\Libraries\ResponseException $exc) {
            if ($exc->getCode() != 204) {
                throw $exc;
            }
        }
    }
    
    /**
     * Create page for Kyc document from file
     * @param int $userId User Id
     * @param int $kycDocumentId KYC Document Id
     * @param string $file File path
     * @throws \MarketPay\Libraries\Exception
     */
    public function CreateKycPageFromFile($userId, $kycDocumentId, $file, $idempotencyKey = null)
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
        
        $kycPage = new \MarketPay\KycPage();
        $kycPage->File = base64_encode(file_get_contents($filePath));
        
        if (empty($kycPage->File)) {
            throw new \MarketPay\Libraries\Exception('Content of the file cannot be empty');
        }
        
        $this->CreateKycPage($userId, $kycDocumentId, $kycPage, $idempotencyKey);
    }
    
    /**
     * Get correct user object
     * @param object $response Response from API
     * @return UserLegal|UserNatural User object returned from API
     * @throws \MarketPay\Libraries\Exception If occur unexpected response from API
     */
    private function GetUserResponse($response)
    {
        if (isset($response->PersonType)) {
            $response->PersonType = strtoupper($response->PersonType);
            $response->Address = new \MarketPay\Address();
            switch ($response->PersonType) {
                case PersonType::Natural:
                    return $this->CastResponseToEntity($response, '\MarketPay\UserNatural');
                case PersonType::Legal:
                    return $this->CastResponseToEntity($response, '\MarketPay\UserLegal');
                default:
                    return $this->CastResponseToEntity($response, '\MarketPay\UserNatural');
            }
        } else {
            throw new Libraries\Exception('Unexpected response. Missing PersonType property');
        }
    }
    
    private function GetBankAccountType($bankAccount)
    {
        if (!isset($bankAccount->Details) || !is_object($bankAccount->Details)) {
            throw new Libraries\Exception('Details is not defined or it is not object type');
        }
        
        $className = str_replace('MarketPay\\BankAccountDetails', '', get_class($bankAccount->Details));
        return strtolower($className);
    }
}
