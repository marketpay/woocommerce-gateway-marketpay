<?php
namespace MarketPay\Libraries;

/**
 * Configuration settings
 */
class Configuration
{
    /**
     * Client Id
     * @var string
     */
    public $ClientId;
    
    /**
     * Client password
     * @var string
     */
    public $ClientPassword;
    
    /**
     * Base URL to MarketPay API
     * @var string
     */
    /**Producion URL changes to {public $BaseUrl = 'https://api.marketpay.io';}**/
    public $BaseUrl = 'https://api.sandbox.marketpay.io';
    
    /**
    * Path to folder with temporary files (with permissions to write)
    */
    public $TemporaryFolder = null;
    
    /**
     * Absolute path to file holding one or more certificates to verify the peer with.
     * If empty - don't verifying the peer's certificate.
     * @var string
     */
    public $CertificatesFilePath = '';
    
    /**
     * [INTERNAL USAGE ONLY]
     * Switch debug mode: log all request and response data
     */
    public $DebugMode = false;
    
    /**
     * Set the logging class if DebugMode is enabled
     */
    public $LogClass = 'MarketPay\Libraries\Logs';
    
    
    /**
     * Set the cURL connection timeout limit (in seconds)
     */
    public $CurlConnectionTimeout = 30;
    
    /**
     * Set the cURL response timeout limit (in seconds)
     */
    public $CurlResponseTimeout = 80;
}
