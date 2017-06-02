<?php
namespace MarketPay\Libraries;

class UrlTool
{
    /**
     * Root/parent instance that holds the OAuthToken and Configuration instance
     * @var \MarketPay\MarketPayApi
     */
    private $_root;

    /**
     * Constructor
     * @param \MarketPay\MarketPayApi Root/parent instance that holds the OAuthToken and Configuration instance
     */
    public function __construct($root)
    {
        $this->_root = $root;
    }
    
    private function GetHost()
    {
        if (is_null($this->_root->Config->BaseUrl) || strlen($this->_root->Config->BaseUrl) == 0) {
            throw new Exception('Neither MarketPay_BaseUrl constant nor BaseUrl config setting is defined.');
        }
        
        $baseUrl = $this->_root->Config->BaseUrl;
        if (strpos($baseUrl, '/', strlen($baseUrl) - 1)) {
            $baseUrl = substr($baseUrl, 0, strlen($baseUrl) - 1);
        }
        
        return $baseUrl;
    }
    
    public function GetRestUrl($urlKey, $addClientId = true, $pagination = null, $additionalUrlParams = null)
    {
        $url = '/v2.01' . $urlKey;

        $paramsAdded = false;
        if (!is_null($pagination)) {
            $url .= '?page=' . $pagination->Page . '&per_page=' . $pagination->ItemsPerPage;
            $paramsAdded = true;
        }

        if (!is_null($additionalUrlParams)) {
            if (array_key_exists("sort", $additionalUrlParams)) {
                $url .= $paramsAdded ? '&' : '?';
                $url .= http_build_query($additionalUrlParams["sort"]);
                $paramsAdded = true;
            }
            
            if (array_key_exists("filter", $additionalUrlParams)) {
                $url .= $paramsAdded ? '&' : '?';
                $url .= http_build_query($additionalUrlParams["filter"]);
                $paramsAdded = true;
            }
        }

        return $url;
    }
    
    public function GetFullUrl($restUrl)
    {
        return $this->GetHost() . $restUrl;
    }
}
