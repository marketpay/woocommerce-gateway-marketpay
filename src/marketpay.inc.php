<?php
/**
 * Marketpay WooCommerce plugin Marketpay access class
 *
 * @author ferran@lemonpay.me
 * @see: https://github.com/marketpay/woocommerce-gateway-marketpay
 *
 * Comment shorthand notations:
 * WP = WordPress core
 * WC = WooCommerce plugin
 * WV = WC-Vendor plugin
 * DB = Marketpay dashboard
 *
 */

use Swagger\Client\ApiException;

class mpAccess
{
    /** Class constants **/
    const DEBUG            = false; // Turns debugging messages on or off (should be false for production)
    const TMP_DIR_NAME     = 'mp_tmp';
    const SANDBOX_API_URL  = 'https://api-sandbox.marketpay.io';
    const PROD_API_URL     = 'https://api.marketpay.io';
    const SANDBOX_DB_URL   = 'https://dashboard-sandbox.marketpay.io';
    const PROD_DB_URL      = 'https://dashboard.marketpay.io';
    const LOGFILENAME      = 'mp-transactions.log.php';
    const WC_PLUGIN_PATH   = 'woocommerce/woocommerce.php';
    const WV_PLUGIN_PATH   = 'wc-vendors/class-wc-vendors.php';
    const PAYIN_SUCCESS_HK = 'PAYIN_NORMAL_SUCCEEDED';
    const PAYIN_FAILED_HK  = 'PAYIN_NORMAL_FAILED';

    /** Class variables **/
    private $mp_loaded     = false;
    private $mp_production = false; // Sandbox environment is default
    private $mp_client_id  = '';
    private $mp_passphrase = '';
    private $mp_db_url     = '';
    private $logFilePath   = '';
    private $errorStatus   = false;
    private $errorMsg;
    private $legacyApi;
    private $marketPayApi = null;

    /**
     * @var Singleton The reference to *Singleton* instance of this class
     *
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     *
     */
    public static function getInstance()
    {
        if (null === static::$instance) static::$instance = new mpAccess();

        return static::$instance;
    }

    /**
     * Sets the Marketpay environment to either 'Production' or 'Sandbox'
     * @param unknown $environment
     *
     */
    public function setEnv(
        $prod_or_sandbox,
        $client_id,
        $passphrase,
        $default_buyer_status,
        $default_vendor_status,
        $default_business_type,
        $debug
    ) {
        if ('prod' != $prod_or_sandbox && 'sandbox' != $prod_or_sandbox) return false;

        $this->mp_client_id          = $client_id;
        $this->mp_passphrase         = $passphrase;
        $this->default_buyer_status  = $default_buyer_status;
        $this->default_vendor_status = $default_vendor_status;
        $this->default_business_type = $default_business_type;
        $this->mp_db_url             = self::SANDBOX_DB_URL;

        if ('prod' == $prod_or_sandbox)
        {
            $this->mp_production = true;
            $this->mp_db_url     = self::PROD_DB_URL;
        }

        $this->init();
    }

    /**
     * Returns class error status
     *
     * @return array $status
     *
     */
    public function getStatus($marketpayWCMain)
    {
        /** Checks that at least one card/payment method is enabled **/
        $card_enabled = false;

        if ($wc_settings = get_option('woocommerce_marketpay_settings'))
        {
            if (is_array($wc_settings) && isset($wc_settings['enabled']))
            {
                $enabled = $wc_settings['enabled'];

                foreach ($wc_settings as $key => $value)
                {
                    if (preg_match('/^enabled_/', $key) && 'yes' == $value) {
                        $card_enabled = true;
                    }
                }
            }
            else
            {
                $enabled = false;
            }
        }
        else
        {
            if (false === $wc_settings)
            {
                $enabled      = 'yes';
                $card_enabled = true;
            }
            else
            {
                $enabled = false;
            }
        }

        /** If Bankwire Direct payment is enabled, check that the incoming webhooks are registered **/
        $webhook_status = false;

        if ($wc_settings && isset($wc_settings['enabled_BANK_WIRE']) && 'yes' == $wc_settings['enabled_BANK_WIRE'])
        {
            $bankwire_enabled = true;

            $webhook_status = (
                $this->check_webhook($marketpayWCMain->options['webhook_key'], self::PAYIN_SUCCESS_HK) &&
                $this->check_webhook($marketpayWCMain->options['webhook_key'], self::PAYIN_FAILED_HK)
            );
        }
        else
        {
            $bankwire_enabled = false;
        }

        $status = array(
            'status'           => $this->errorStatus,
            'message'          => $this->errorMsg,
            'environment'      => $this->mp_production,
            'client_id'        => $this->mp_client_id,
            'loaded'           => $this->mp_loaded,
            'enabled'          => $enabled,
            'card_enabled'     => $card_enabled,
            'bankwire_enabled' => $bankwire_enabled,
            'webhook_status'   => $webhook_status,
        );

        return $status;
    }

    /**
     * Marketpay init
     * loads and instantiates the Marketpay API
     *
     */
    private function init()
    {
        /** Setup tmp directory **/
        $tmp_path = $this->set_tmp_dir();

        $this->logFilePath = $tmp_path . '/' . self::LOGFILENAME;

        /** Initialize log file if not present **/
        if ( ! file_exists($this->logFilePath))
        {
            file_put_contents($this->logFilePath, '<?php header("HTTP/1.0 404 Not Found"); echo "File not found."; exit; /*');
        }

        /** Add a .htaccess to mp_tmp dir for added security **/
        $htaccess_path = $tmp_path . '/' . '.htaccess';

        if ( ! file_exists($htaccess_path))
        {
            file_put_contents($htaccess_path, "order deny,allow\ndeny from all\nallow from 127.0.0.1");
        }

        $htaccess_path = dirname($tmp_path) . '/' . '.htaccess';

        if ( ! file_exists($htaccess_path))
        {
            file_put_contents($htaccess_path, "order deny,allow\ndeny from all\nallow from 127.0.0.1");
        }

        /** Instantiate MP API **/
        $plugin_dir = dirname(dirname(__FILE__));

        require_once $plugin_dir . '/legacy/MarketPay/Autoloader.php';
        require_once $plugin_dir . '/vendor/autoload.php';

        require_once 'mock-storage.inc.php';

        $this->legacyApi = new MarketPay\MarketPayApi();

        $this->legacyApi->Config->ClientId        = $this->mp_client_id;
        $this->legacyApi->Config->ClientPassword  = $this->mp_passphrase;
        $this->legacyApi->Config->BaseUrl         = $this->mp_production ? self::PROD_API_URL : self::SANDBOX_API_URL;
        $this->legacyApi->Config->TemporaryFolder = $tmp_path . '/';
        $this->legacyApi->Config->Debug           = self::DEBUG;

        $this->legacyApi->OAuthTokenManager->RegisterCustomStorageStrategy(new \MarketPay\WPPlugin\MockStorageStrategy());

        return true;
    }

    public function marketPayApi()
    {
        if ( ! is_null($this->marketPayApi)) return $this->marketPayApi;

        $mp_base_url = $this->mp_production ? self::PROD_API_URL : self::SANDBOX_API_URL;
        $mp_client_id = $this->mp_client_id;
        $mp_passphrase = $this->mp_passphrase;

        /** Use Legacy API to get response token **/
        $token = $this->legacyApi->OAuthTokenManager->getToken(
            md5($mp_base_url . $mp_client_id . $mp_passphrase)
        );

        /** MarketPay API configuration **/
        $config = new Swagger\Client\Configuration;

        $config->setHost($mp_base_url);
        $config->setApiKey($mp_client_id, $mp_passphrase);
        $config->setDebug(self::DEBUG);
        $config->setAccessToken($token->access_token);
        $config->setDefaultConfiguration($config);

        $this->marketPayApi = new Swagger\Client\ApiClient($config);

        $this->marketPayApi->RedsysPayIns   = new Swagger\Client\Api\PayInsRedsysApi($this->marketPayApi);
        $this->marketPayApi->BankwirePayIns = new Swagger\Client\Api\PayInsBankwireApi($this->marketPayApi);
        $this->marketPayApi->Kyc            = new Swagger\Client\Api\KycApi($this->marketPayApi);

        return $this->marketPayApi;
    }

    /**
     * Setup temporary directory
     *
     * @return string
     */
    private function set_tmp_dir()
    {
        $uploads         = wp_upload_dir();
        $uploads_path    = $uploads['basedir'];
        $prod_or_sandbox = 'sandbox';

        if ($this->mp_production) $prod_or_sandbox = 'prod';

        $tmp_path = $uploads_path . '/' . self::TMP_DIR_NAME . '/' . $prod_or_sandbox;

        wp_mkdir_p($tmp_path);

        return $tmp_path;
    }

    /**
     * Simple API connection test
     * @see: https://gist.github.com/hobailey/105c53717b8547ba66d7
     *
     */
    public function connection_test()
    {
        if ( ! self::getInstance()->mp_loaded) $this->init();

        try
        {
            $result = $this->legacyApi->Users->GetAll();

            $this->mp_loaded = true;

            return $result;
        }
        catch (MarketPay\Libraries\ResponseException $e)
        {
            echo '<div class="error"><p>' . __('Marketpay API returned:', 'marketpay') . ' ';
            MarketPay\Libraries\Logs::Debug('MarketPay\ResponseException Code', $e->GetCode());
            MarketPay\Libraries\Logs::Debug('Message', $e->GetMessage());
            MarketPay\Libraries\Logs::Debug('Details', $e->GetErrorDetails());
            echo '</p></div>';
        }
        catch (MarketPay\Libraries\Exception $e)
        {
            echo '<div class="error"><p>' . __('Marketpay API returned:', 'marketpay') . ' ';
            MarketPay\Libraries\Logs::Debug('MarketPay\Exception Message', $e->GetMessage());
            echo '</p></div>';
        }
        catch (Exception $e)
        {
            $error_message = __('Error:', 'marketpay') .
            ' ' . $e->getMessage();
            error_log(
                current_time('Y-m-d H:i:s', 0) . ': ' . $error_message . "\n\n",
                3,
                $this->logFilePath
            );

            echo '<div class="error"><p>' . __('Marketpay API returned:', 'marketpay') . ' ';
            echo '&laquo;' . $error_message . '&raquo;</p></div>';
        }

        return false;
    }

    /**
     * Checks if wp_user already has associated mp account
     * if not, creates an mp user account
     *
     * @param string $wp_user_id
     *
     */
    public function set_mp_user($wp_user_id, $p_type = 'NATURAL')
    {
        $umeta_key = 'mp_user_id';

        if ( ! $this->mp_production) $umeta_key .= '_sandbox';

        $legal_p_type = null;
        $vendor_role  = apply_filters('marketpay_vendor_role', 'vendor');

        if ( ! $mp_user_id = get_user_meta($wp_user_id, $umeta_key, true))
        {
            if ( ! $wp_userdata = get_userdata($wp_user_id)) return false;

            /** Vendor or buyer ? **/
            if (
                (
                    isset($_POST['apply_for_vendor']) &&
                    ($_POST['apply_for_vendor'] == 1 || $_POST['apply_for_vendor'] == '1')
                ) ||
                isset($wp_userdata->wp_capabilities['pending_vendor']) ||
                (
                    is_array($wp_userdata->wp_capabilities) &&
                    in_array('pending_vendor', $wp_userdata->wp_capabilities, true)
                ) ||
                isset($wp_userdata->wp_capabilities[$vendor_role]) ||
                (
                    is_array($wp_userdata->wp_capabilities) &&
                    in_array($vendor_role, $wp_userdata->wp_capabilities, true)
                ) ||
                'BUSINESS' == $p_type
            ) {

                /** Vendor **/
                if ( ! empty($this->default_vendor_status))
                {
                    if ('either' == $this->default_vendor_status)
                    {
                        $user_mp_status = get_user_meta($wp_user_id, 'user_mp_status', true); //Custom usermeta

                        // Can't create a MP user in this case
                        if ( ! $user_mp_status) return false;

                        if ('business' == $user_mp_status)    $p_type = 'BUSINESS';
                        if ('individual' == $user_mp_status)  $p_type = 'NATURAL';

                        if ( ! $p_type) return false;
                    }
                    else
                    {
                        if ('businesses' == $this->default_vendor_status)  $p_type = 'BUSINESS';
                        if ('individuals' == $this->default_vendor_status) $p_type = 'NATURAL';

                        if ( ! $p_type) return false;
                    }
                }
                else
                {
                    $p_type = 'BUSINESS';
                }
            }
            else
            {
                if ( ! empty($this->default_buyer_status))
                {
                    if ('either' == $this->default_buyer_status)
                    {
                        $user_mp_status = get_user_meta($wp_user_id, 'user_mp_status', true);

                        // Can't create a MP user in this case
                        if ( ! $user_mp_status) return false;

                        if ('business' == $user_mp_status)   $p_type = 'BUSINESS';
                        if ('individual' == $user_mp_status) $p_type = 'NATURAL';

                        if ( ! $p_type) return false;
                    }
                    else
                    {
                        if ('businesses' == $this->default_buyer_status)  $p_type = 'BUSINESS';
                        if ('individuals' == $this->default_buyer_status) $p_type = 'NATURAL';

                        if (!$p_type) return false;
                    }
                }
                else
                {
                    $p_type = 'NATURAL';
                }
            }

            if ('BUSINESS' == $p_type)
            {
                if ('either' == $this->default_business_type)
                {
                    $user_business_type = get_user_meta($wp_user_id, 'user_business_type', true);

                    // Can't create a MP user in this case
                    if ( ! $user_business_type) return false;

                    if ('business'     == $user_business_type) $legal_p_type = 'BUSINESS';
                    if ('organisation' == $user_business_type) $legal_p_type = 'ORGANIZATION';
                    if ('soletrader'   == $user_business_type) $legal_p_type = 'SOLETRADER';

                    if ( ! $legal_p_type) return false;
                }
                else
                {
                    if ('businesses'    == $this->default_business_type) $legal_p_type = 'BUSINESS';
                    if ('organisations' == $this->default_business_type) $legal_p_type = 'ORGANIZATION';
                    if ('soletraders'   == $this->default_business_type) $legal_p_type = 'SOLETRADER';

                    if ( ! $legal_p_type) return false;
                }
            }

            /** Required fields **/
            $b_date = strtotime(get_user_meta($wp_user_id, 'user_birthday', true)); // Custom usermeta
            if ($offset = get_option('gmt_offset')) {
                $b_date += ($offset * 60 * 60);
            }

            $natio = get_user_meta($wp_user_id, 'user_nationality', true); // Custom usermeta
            $iddoc = get_user_meta($wp_user_id, 'kyc_id_document', true); // Custom usermeta
            $kycfi = get_user_meta($wp_user_id, 'kyc_document', true); // Custom usermeta
            $ctry  = get_user_meta($wp_user_id, 'billing_country', true); // WP usermeta

            if (!$vendor_name = get_user_meta($wp_user_id, 'pv_shop_name', true)) // WC-Vendor plugin usermeta
            {
                $vendor_name = $wp_userdata->nickname;
            }

            // Get Document File
            $docfile = null;
            if ($kycdoc = get_user_meta($wp_user_id, 'kyc_document', true))
            {
                $docfile = new SplFileObject(get_attached_file($kycdoc));
            }

            if ($marketUser = $this->createMarketUser(
                $p_type,
                $legal_p_type,
                $wp_userdata->first_name,
                $wp_userdata->last_name,
                $b_date,
                $natio,
                $ctry,
                $wp_userdata->user_email,
                $vendor_name,
                $wp_user_id,
                $iddoc,
                $kycfi
            )) {
                $mp_user_id = $marketUser->Id;

                /** We store a different mp_user_id for production and sandbox environments **/
                $umeta_key = 'mp_user_id';
                if (!$this->mp_production) {
                    $umeta_key .= '_sandbox';
                }

                update_user_meta($wp_user_id, $umeta_key, $mp_user_id);

                /** Store effective user_mp_status **/
                $user_mp_status     = 'individual';
                $user_business_type = '';
                if ('BUSINESS' == $p_type) {
                    $user_mp_status     = 'business';
                    $user_business_type = 'business';
                    if ('ORGANIZATION' == $legal_p_type) {
                        $user_business_type = 'organisation';
                    }

                    if ('SOLETRADER' == $legal_p_type) {
                        $user_business_type = 'soletrader';
                    }

                }
                update_user_meta($wp_user_id, 'user_mp_status', $user_mp_status);
                update_user_meta($wp_user_id, 'user_business_type', $user_business_type);
            }
            else
            {
                return false;
            }
        }
        elseif (($user_ptype = $this->getDBUserPType($mp_user_id)) != $p_type)
        {
            if (false === $user_ptype) return false;

            if ('BUSINESS' == $p_type && 'LEGAL' == $user_ptype) return $mp_user_id;
        }

        return $mp_user_id;
    }

    /**
     * Checks if mp_user already has associated wallet(s)
     * if not,creates a default wallet
     *
     * @param string $mp_user_id - Required
     *
     */
    public function set_mp_wallet($mp_user_id)
    {
        if ( ! $mp_user_id) return false;

        /** Check existing MP user & user type **/
        if ( ! $marketUser = $this->legacyApi->Users->Get($mp_user_id)) return false;

        if ('BUSINESS' == $marketUser->PersonType || 'LEGAL' == $marketUser->PersonType)
        {
            $account_type = 'Business';
        }
        elseif ('NATURAL' == $marketUser->PersonType)
        {
            $account_type = 'Individual';
        }
        else
        {
            return false;
        }

        $currency = get_woocommerce_currency();

        if ( ! $wallets = $this->legacyApi->Users->GetWallets($mp_user_id))
        {
            $result  = $this->create_the_wallet($mp_user_id, $account_type, $currency);
            $wallets = $this->legacyApi->Users->GetWallets($mp_user_id);
        }

        /** Check that one wallet has the right currency, otherwise create a new one **/
        $found = false;
        foreach ($wallets as $wallet)
        {
            if ($wallet->Currency == get_woocommerce_currency()) $found = true;
        }

        if ( ! $found)
        {
            $result  = $this->create_the_wallet($mp_user_id, $account_type, $currency);
            $wallets = $this->legacyApi->Users->GetWallets($mp_user_id);
        }

        return $wallets;
    }

    /**
     * Create a new MP wallet
     *
     * @param int $mp_user_id
     * @param string $account_type
     * @param string $currency
     */
    private function create_the_wallet($mp_user_id, $account_type, $currency)
    {
        $Wallet              = new \MarketPay\Wallet();
        $Wallet->Owners      = array($mp_user_id);
        $Wallet->Description = "WooCommerce $account_type $currency Wallet";
        $Wallet->Currency    = $currency;

        return $this->legacyApi->Wallets->Create($Wallet);
    }

    /**
     * Register a user's bank account in MP profile
     * @see: https://github.com/Marketpay/marketpay2-php-sdk/blob/master/demos/workflow/scripts/bankaccount.php
     *
     * @param inst $mp_user_id
     * @param string $type
     * @param string $name
     * @param string $address1
     * @param string $address2
     * @param string $city
     * @param string $region
     * @param string $country
     * @param array $account_data
     *
     */
    public function save_bank_account(
        $mp_user_id,
        $wp_user_id,
        $existing_account_id,
        $type,
        $name,
        $address1,
        $address2,
        $city,
        $postcode,
        $region,
        $country,
        $account_data = array(),
        $account_types
    ) {
        /** If there is an existing bank account, fetch it first to get the redacted info we did not store **/
        $ExistingBankAccount = null;

        if ($existing_account_id)
        {
            try
            {
                $ExistingBankAccount = $this->legacyApi->Users->GetBankAccount($mp_user_id, $existing_account_id);
            }
            catch (Exception $e)
            {
                $ExistingBankAccount = null;
            }
        }

        $BankAccount         = new \MarketPay\BankAccount();
        $BankAccount->Type   = $type;
        $BankAccount->UserId = $mp_user_id;

        $detail_class_name    = 'MarketPay\BankAccountDetails' . $type;
        $BankAccount->Details = new $detail_class_name();

        foreach ($account_types[$type] as $field_name => $field_data)
        {
            if (
                !empty($ExistingBankAccount) &&
                $type == $ExistingBankAccount->Type && (
                    empty($account_data[$field_name]) ||
                    preg_match('/\*\*/', $account_data[$field_name])
                )
            ) {
                /** Replace redacted data with data from existing bank account **/
                $BankAccount->Details->{$field_data['mp_property']} = $ExistingBankAccount->Details->{$field_data['mp_property']};
            }
            else
            {
                if (isset($account_data[$field_name]))
                {
                    $BankAccount->Details->{$field_data['mp_property']} = $account_data[$field_name];
                }
            }
        }

        $BankAccount->OwnerName                  = $name;
        $BankAccount->OwnerAddress               = new \MarketPay\Address();
        $BankAccount->OwnerAddress->AddressLine1 = $address1;
        $BankAccount->OwnerAddress->AddressLine2 = $address2;
        $BankAccount->OwnerAddress->City         = $city;
        $BankAccount->OwnerAddress->Country      = $country;
        $BankAccount->OwnerAddress->PostalCode   = $postcode;

        unset($BankAccount->OwnerAddress->Region);

        // Mandatory for some countries
        if (isset($region) && $region)
        {
            $BankAccount->OwnerAddress->Region = $region;
        }

        $BankAccount->Tag = 'wp_user_id:' . $wp_user_id;
        $BankAccount->CreationDate = time();

        try
        {
            $BankAccount = $this->legacyApi->Users->CreateBankAccount($mp_user_id, $BankAccount);
        }
        catch (Exception $e)
        {
            $backlink = '<a href="javascript:history.back();">' . __('back', 'marketpay') . '</a>';
            wp_die(__('Error: Invalid bank account data.', 'marketpay') . ' ' . $backlink);
        }

        return $BankAccount->Id;
    }

    /**
     * Create Marketpay User + first wallet
     *
     * @param string $p_type        | must be "BUSINESS" or "NATURAL" - Required
     * @param string $f_name        | first name - Required
     * @param string $l_name        | last name - Required
     * @param int $b_date            | birthday (unix timestamp - ex 121271) - Required
     * @param string $natio            | nationality (2-letter UC country code - ex "FR") - Required
     * @param string $ctry            | country (2-letter UC country code - ex "FR") - Required
     * @param string $email            | e-mail address - Required
     * @param string $vendor_name    | name of business - Required only if $p_type=='BUSINESS'
     * @param int $wp_user_id        | WP User ID
     *
     * @return MarketpPayUser $marketUser
     *
     */
    private function createMarketUser(
        $p_type,
        $legal_p_type = null,
        $f_name,
        $l_name,
        $b_date,
        $natio,
        $ctry,
        $email,
        $vendor_name = null,
        $wp_user_id,
        $kyc_id_doc,
        $kyc_doc
    ) {
        global $creation_mp_on;
        $creation_mp_on = true;

        /** All fields are required **/
        if (!$p_type || !$f_name || !$l_name || !$b_date || !$natio || !$ctry || !$email || !$kyc_id_doc)
        {
            if (self::DEBUG)
            {
                echo __('Error: some required fields are missing in createMarketUser', 'marketpay') . '<br/>';
                echo "$p_type || !$f_name || !$l_name || !$b_date || !$natio || !$ctry || !$email<br/>";
            }

            return false;
        }

        /** Initialize user data **/
        if ('BUSINESS' == $p_type)
        {
            if ( ! $vendor_name) return false;

            $marketUser                                        = new \MarketPay\UserLegal();
            $marketUser->Name                                  = $vendor_name; //Required
            $marketUser->LegalPersonType                       = $legal_p_type; //Required
            $marketUser->LegalRepresentativeFirstName          = $f_name; //Required
            $marketUser->LegalRepresentativeLastName           = $l_name; //Required
            $marketUser->LegalRepresentativeBirthday           = $b_date; //Required
            $marketUser->LegalRepresentativeNationality        = $natio; //Required
            $marketUser->LegalRepresentativeCountryOfResidence = $ctry; //Required
        }
        else
        {
            $marketUser                     = new \MarketPay\UserNatural();
            $marketUser->PersonType         = $p_type;
            $marketUser->FirstName          = $f_name;
            $marketUser->LastName           = $l_name;
            $marketUser->Birthday           = $b_date;
            $marketUser->Nationality        = $natio;
            $marketUser->CountryOfResidence = $ctry;
        }

        $marketUser->Email        = $email; //Required
        $marketUser->Tag          = 'wp_user_id:' . $wp_user_id;
        $marketUser->CreationDate = time();

        /** Send the request **/
        try
        {
            $marketUser = $this->legacyApi->Users->Create($marketUser);
            $mp_user_id = $marketUser->Id;

            if ('BUSINESS' == $p_type)
            {
                $kycUser = new Swagger\Client\Model\KycUserLegalPut([
                    'legal_person_type'                         => $legal_p_type,
                    'name'                                      => $vendor_name,
                    'legal_representative_birthday'             => $b_date,
                    'legal_representative_country_of_residence' => $ctry,
                    'legal_representative_nationality'          => $natio,
                    'legal_representative_email'                => $email,
                    'legal_representative_first_name'           => $f_name,
                    'legal_representative_last_name'            => $l_name,
                    'tag'                                       => 'wp_user_id:' . $wp_user_id
                ]);

                try
                {
                    $this->marketPayApi()->Kyc->kycPutLegal($mp_user_id, $kycUser);
                }
                catch (Exception $e)
                {
                    //
                }
            }
            else
            {
                $kycUser = new Swagger\Client\Model\KycUserNaturalPut([
                    'email'                => $email,
                    'first_name'           => $f_name,
                    'last_name'            => $l_name,
                    'birthday'             => $b_date,
                    'nationality'          => $natio,
                    'country_of_residence' => $ctry,
                    'id_card'              => $kyc_id_doc,
                    'tag'                  => 'wp_user_id:' . $wp_user_id
                ]);

                try
                {
                    $this->marketPayApi()->Kyc->kycPostNatural($mp_user_id, $kycUser);
                }
                catch (Exception $e)
                {
                    //
                }

                // UPLOAD DOCUMENT
                $splFileObject = null;
                if ($docfile = get_attached_file($kycdoc))
                {
                    $splFileObject = new SplFileObject($docfile);
                }

                try
                {
                    if ( ! is_null($splFileObject))
                    {
                        $this->marketPayApi()->Kyc->kycPostDocument('USER_IDENTITY_PROOF', $splFileObject, $mp_user_id);
                    }

                    $this->marketPayApi()->Kyc->kycPutRequest($mp_user_id, new Swagger\Client\Model\KycIdentificationRequest);
                }
                catch (ApiException $e)
                {
                    //
                }
            }
        }
        catch (Exception $e)
        {
            $error_message = $e->getMessage();

            error_log(current_time('Y-m-d H:i:s', 0) . ': ' . $error_message . "\n\n", 3, $this->logFilePath);

            $msg = '<div class="error"><p>' . __('Error:', 'marketpay') . ' ';
            $msg .= __('Marketpay API returned:', 'marketpay') . ' ';
            $msg .= '&laquo;' . $error_message . '&raquo;</p></div>';

            echo $msg;

            return false;
        }

        /** If new user has no wallet yet, create one **/
        $this->set_mp_wallet($mp_user_id);

        return $marketUser;
    }

    /**
     * Update MP User account info
     *
     * $p_type
     * @param int $mp_user_id
     * @param array $usermeta
     *
     */
    public function update_user($mp_user_id, $usermeta = array())
    {
        global $creation_mp_on;

        if (isset($creation_mp_on) && $creation_mp_on == true) return;

        if ( ! $mp_user_id) return;

        /** Get existing MP user **/
        if ( ! $marketUser = $this->legacyApi->Users->Get($mp_user_id)) return;

        /** marketUser basic object cleanup **/
        foreach ($marketUser as $key => $value)
        {
            if (null == $value) unset($marketUser->$key);
        }

        $needs_updating = false;

        if ('NATURAL' == $marketUser->PersonType)
        {
            try
            {
                $kycUser = $this->marketPayApi()->Kyc->kycGetNatural($mp_user_id);
            }
            catch (ApiException $e)
            {
                $kycUser = new Swagger\Client\Model\KycUserValidationLevelNaturalResponse();
            }

            if (
                isset($usermeta['first_name']) &&
                $usermeta['first_name'] &&
                $marketUser->FirstName != $usermeta['first_name'] &&
                $kycUser->getFirstName() != $usermeta['first_name']
            ) {
                $kycUser->setFirstName($usermeta['first_name']);

                $marketUser->FirstName = $usermeta['first_name'];
                $needs_updating        = true;
            }

            if (
                isset($usermeta['last_name']) &&
                $usermeta['last_name'] &&
                $marketUser->LastName != $usermeta['last_name'] &&
                $kycUser->getLastName() != $usermeta['last_name']
            ) {
                $kycUser->setLastName($usermeta['last_name']);

                $marketUser->LastName = $usermeta['last_name'];
                $needs_updating       = true;
            }

            if (
                isset($usermeta['address_1']) &&
                $usermeta['address_1'] && (
                    $marketUser->Address->AddressLine1 != $usermeta['address_1'] ||
                    $marketUser->Address->City != $usermeta['city'] ||
                    $marketUser->Address->PostalCode != $usermeta['postal_code'] ||
                    $marketUser->Address->Country != $usermeta['billing_country']
                ) && (
                    $kycUser->getAddress()->getAddressLine1() != $usermeta['address_1'] ||
                    $kycUser->getAddress()->getCity() != $usermeta['city'] ||
                    $kycUser->getAddress()->getPostalCode() != $usermeta['postal_code'] ||
                    $kycUser->getAddress()->getCountry() != $usermeta['billing_country']
                )
            ) {
                $kycUser->setAddress(new Swagger\Client\Model\Address([
                    'address_line1' => $usermeta['address_1'],
                    'city'          => $usermeta['city'],
                    'region'        => $usermeta['billing_state'],
                    'postal_code'   => $usermeta['postal_code'],
                    'country'       => $usermeta['billing_country']
                ]));

                $marketUser->Address->AddressLine1 = $usermeta['address_1'];
                $marketUser->Address->City         = $usermeta['city'];
                $marketUser->Address->PostalCode   = $usermeta['postal_code'];
                $marketUser->Address->Country      = $usermeta['billing_country'];
                $marketUser->Address->Region       = $usermeta['billing_state'];

                $needs_updating = true;
            }

            if (
                isset($usermeta['billing_country']) &&
                $usermeta['billing_country'] &&
                $marketUser->CountryOfResidence != $usermeta['billing_country'] &&
                $kycUser->getCountryOfResidence() != $usermeta['billing_countr']
            ) {
                $kycUser->setCountryOfResidence($usermeta['billing_country']);

                $marketUser->CountryOfResidence = $usermeta['billing_country'];
                $needs_updating                 = true;
            }

            if (isset($usermeta['user_birthday']))
            {
                $timestamp = strtotime($usermeta['user_birthday']);

                if ($offset = get_option('gmt_offset')) $timestamp += ($offset * 60 * 60);
            }

            if (
                isset($usermeta['user_birthday']) &&
                $usermeta['user_birthday'] &&
                $marketUser->Birthday != $timestamp &&
                $kycUser->getBirthday() != $timestamp
            ) {
                $kyc->setBirthday($timestamp);

                $marketUser->Birthday = $timestamp;
                $needs_updating       = true;
            }

            if (
                isset($usermeta['user_nationality']) &&
                $usermeta['user_nationality'] &&
                $marketUser->Nationality != $usermeta['user_nationality'] &&
                $kycUser->getNationality() != $usermeta['get_nationality']
            ) {
                $kycUser->setNationality($usermeta['user_nationality']);

                $marketUser->Nationality = $usermeta['user_nationality'];
                $needs_updating          = true;
            }

            if (
                isset($usermeta['kyc_id_document']) &&
                $usermeta['kyc_id_document'] &&
                $kycUser->getIdCard() != $usermeta['kyc_id_document']
            ) {
                $kycUser->setIdCard($usermeta['kyc_id_document']);

                $needs_updating = true;
            }

            if (
                isset($usermeta['kyc_document']) &&
                $usermeta['kyc_document'] &&
                ! in_array($usermeta['kyc_document'], $kycUser->getIdCardDocument()->getDocumentIds())
            ) {
                $splFileObject = null;
                if ($docfile = get_attached_file($usermeta['kyc_document']))
                {
                    $splFileObject = new SplFileObject($docfile);
                }

                try
                {
                    if ( ! is_null($splFileObject))
                    {
                        $this->marketPayApi()->Kyc->kycPostDocument('USER_IDENTITY_PROOF', $splFileObject, $marketUser->Id);
                    }

                    $this->marketPayApi()->Kyc->kycPutRequest($marketUser->Id, new Swagger\Client\Model\KycIdentificationRequest);
                }
                catch (ApiException $e)
                {
                    //
                }
            }

            if (
                isset($usermeta['user_email']) &&
                $usermeta['user_email'] &&
                $marketUser->Email != $usermeta['user_email'] &&
                $kycUser->getEmail() != $usermeta['user_email']
            ) {
                $kycUser->setEmail($usermeta['user_email']);

                $marketUser->Email = $usermeta['user_email'];
                $needs_updating    = true;
            }

            if ($needs_updating)
            {
                $this->marketPayApi()->Kyc->kycPostNatural($mp_user_id, $kycUser);
            }
        }
        else
        {
            try
            {
                $kycUser = $this->marketPayApi()->Kyc->kycGetLegal($mp_user_id);
            }
            catch (ApiException $e)
            {
                $kycUser = new Swagger\Client\Model\KycUserValidationLevelLegalResponse();
            }

            /** Business / legal user **/
            if (
                isset($usermeta['pv_shop_name']) &&
                $usermeta['pv_shop_name'] &&
                $marketUser->Name != $usermeta['pv_shop_name'] &&
                $kycUser->getName() != $usermeta['pv_shop_name']
            ) {
                $kycUser->setName($usermeta['pv_shop_name']);

                $marketUser->Name = $usermeta['pv_shop_name'];
                $needs_updating   = true;
            }

            if (
                isset($usermeta['first_name']) &&
                $usermeta['first_name'] &&
                $marketUser->LegalRepresentativeFirstName != $usermeta['first_name'] &&
                $kycUser->getLegalRepresentativeFirstName() != $usermeta['first_name']
            ) {
                $kyc->setLegalRepresentativeFirstName($usermeta['first_name']);

                $marketUser->LegalRepresentativeFirstName = $usermeta['first_name'];
                $needs_updating                           = true;
            }

            if (
                isset($usermeta['last_name']) &&
                $usermeta['last_name'] &&
                $marketUser->LegalRepresentativeLastName != $usermeta['last_name'] &&
                $kycUser->getLegalRepresentativeLastName() != $usermeta['last_name']
            ) {
                $kycUser->setLegalRepresentativeLastName($usermeta['last_name']);

                $marketUser->LegalRepresentativeLastName = $usermeta['last_name'];
                $needs_updating                          = true;
            }

            if (
                isset($usermeta['address_1']) &&
                $usermeta['address_1'] && (
                    $marketUser->LegalRepresentativeAddress->AddressLine1 != $usermeta['address_1'] ||
                    $marketUser->LegalRepresentativeAddress->City != $usermeta['city'] ||
                    $marketUser->LegalRepresentativeAddress->PostalCode != $usermeta['postal_code'] ||
                    $marketUser->LegalRepresentativeAddress->Country != $usermeta['billing_country']
                ) && (
                    $kycUser->getLegalRepresentativeAddress()->getAddressLine1() != $usermeta['address_1'] ||
                    $kycUser->getLegalRepresentativeAddress()->getCity() != $usermeta['city'] ||
                    $kycUser->getLegalRepresentativeAddress()->getPostalCode() != $usermeta['postal_code'] ||
                    $kycUser->getLegalRepresentativeAddress()->getCountry() != $usermeta['billing_country']
                )
            ) {
                $kycUser->setLegalRepresentativeAddress(new Swagger\Client\Model\Address([
                    'address_line1' => $usermeta['address_1'],
                    'city'          => $usermeta['city'],
                    'region'        => $usermeta['billing_state'],
                    'postal_code'   => $usermeta['postal_code'],
                    'country'       => $usermeta['billing_country']
                ]));

                $marketUser->LegalRepresentativeAddress->AddressLine1 = $usermeta['address_1'];
                $marketUser->LegalRepresentativeAddress->City         = $usermeta['city'];
                $marketUser->LegalRepresentativeAddress->PostalCode   = $usermeta['postal_code'];
                $marketUser->LegalRepresentativeAddress->Country      = $usermeta['billing_country'];
                $marketUser->LegalRepresentativeAddress->Region       = $usermeta['billing_state'];

                $needs_updating = true;
            }

            if (
                isset($usermeta['billing_country']) &&
                $usermeta['billing_country'] &&
                $marketUser->LegalRepresentativeCountryOfResidence != $usermeta['billing_country'] &&
                $kycUser->getLegalRepresentativeCountryOfResidence() != $usermeta['billing_country']
            ) {
                $kycUser->setLegalRepresentativeCountryOfResidence($usermeta['billing_country']);

                $marketUser->LegalRepresentativeCountryOfResidence = $usermeta['billing_country'];
                $needs_updating                                    = true;
            }

            if (isset($usermeta['user_birthday'])) {
                $timestamp = strtotime($usermeta['user_birthday']);
                if ($offset = get_option('gmt_offset')) {
                    $timestamp += ($offset * 60 * 60);
                }
            }

            if (
                isset($usermeta['user_birthday']) &&
                $usermeta['user_birthday'] &&
                $marketUser->LegalRepresentativeBirthday != $timestamp &&
                $kycUser->getLegalRepresentativeBirthday() != $timestamp
            ) {
                $kycUser->setLegalRepresentativeBirthday($timestamp);

                $marketUser->LegalRepresentativeBirthday = $timestamp;
                $needs_updating                          = true;
            }

            if (
                isset($usermeta['user_nationality']) &&
                $usermeta['user_nationality'] &&
                $marketUser->LegalRepresentativeNationality != $usermeta['user_nationality'] &&
                $kycUser->getLegalRepresentativeNationality() != $usermeta['user_nationality']
            ) {
                $kycUser->setLegalRepresentativeNationality($usermeta['user_nationality']);

                $marketUser->LegalRepresentativeNationality = $usermeta['user_nationality'];
                $needs_updating                             = true;
            }

            if (
                isset($usermeta['user_email']) &&
                $usermeta['user_email'] &&
                $marketUser->Email != $usermeta['user_email'] &&
                $kycUser->getLegalRepresentativeEmail() != $usermeta['user_email']
            ) {
                $kycUser->setLegalRepresentativeEmail($usermeta['user_email']);

                $marketUser->Email = $usermeta['user_email'];
                $needs_updating    = true;
            }

            if (isset($usermeta['user_business_type']) && $usermeta['user_business_type'] != '')
            {
                if ('business' == $usermeta['user_business_type'] || 'businesses' == $usermeta['user_business_type'])
                {
                    $legal_p_type = 'BUSINESS';
                }

                if ('organisation' == $usermeta['user_business_type'] || 'organisations' == $usermeta['user_business_type'])
                {
                    $legal_p_type = 'ORGANIZATION';
                }

                if ('soletrader' == $usermeta['user_business_type'] || 'soletraders' == $usermeta['user_business_type'])
                {
                    $legal_p_type = 'SOLETRADER';
                }

                $kycUser->setLegalPersonType($legal_p_type);

                $marketUser->LegalPersonType = $legal_p_type;
                $needs_updating              = true;
            }

            if ($needs_updating)
            {
                $this->marketPayApi()->Kyc->kycPutLegal($mp_user_id, $kycUser);
            }
        }

        if ($needs_updating)
        {
            /** marketUser address objects cleanup **/
            if (
                isset($marketUser->Address) && (
                    !$marketUser->Address->AddressLine1 ||
                    !$marketUser->Address->City ||
                    !$marketUser->Address->PostalCode ||
                    !$marketUser->Address->Country
                )
            ) {
                unset($marketUser->Address);
            }

            if (
                isset($marketUser->HeadquartersAddress) && (
                    !$marketUser->HeadquartersAddress->AddressLine1 ||
                    !$marketUser->HeadquartersAddress->City ||
                    !$marketUser->HeadquartersAddress->PostalCode ||
                    !$marketUser->HeadquartersAddress->Country
                )
            ) {
                unset($marketUser->HeadquartersAddress);
            }

            if (
                isset($marketUser->LegalRepresentativeAddress) && (
                    !$marketUser->LegalRepresentativeAddress->AddressLine1 ||
                    !$marketUser->LegalRepresentativeAddress->City ||
                    !$marketUser->LegalRepresentativeAddress->PostalCode ||
                    !$marketUser->LegalRepresentativeAddress->Country
                )
            ) {
                unset($marketUser->LegalRepresentativeAddress);
            }

            $result = $this->legacyApi->Users->Update($marketUser);
        }
    }

    /**
     * Generate URL for card payin button
     * @see: https://github.com/Marketpay/marketpay2-php-sdk/blob/master/demos/workflow/scripts/payin-card-web.php
     *
     */
    public function card_payin_url(
        $order_id,
        $wp_user_id,
        $amount,
        $currency = 'EUR',
        $fees,
        $return_url,
        $locale,
        $mp_card_type = 'REDSYS',
        $mp_template_url = ''
    ) {
        /** Get mp_user_id and mp_wallet_id from wp_user_id **/
        $mp_user_id = $this->set_mp_user($wp_user_id);
        $wallets    = $this->set_mp_wallet($mp_user_id);

        if ( ! $wallets && ! (defined('DOING_AJAX') && DOING_AJAX))
        {
            $my_account = '<a href="' . wc_customer_edit_account_url() . '" title="' . __('My Account', 'marketpay') . '">' . __('My Account', 'marketpay') . '</a>';

            wp_die(sprintf(__('Your profile info needs to be completed. Please go to %s and fill-in all required fields.', 'marketpay'), $my_account));
        }

        /** Take first wallet with right currency **/
        foreach ($wallets as $wallet)
        {
            if ($wallet->Currency == $currency) $mp_wallet_id = $wallet->Id;
        }

        /** If no wallet abort **/
        if ( ! isset($mp_wallet_id) || !$mp_wallet_id) return false;

        $reference = new Swagger\Client\Model\RedsysPayByWebPost([
            'tag' => 'WC Order #' . $order_id,
            'credited_wallet_id' => $mp_wallet_id,
            'success_url' => $return_url,
            'cancel_url' => $return_url,
            'debited_funds' => new Swagger\Client\Model\Money([
                'currency' => $currency,
                'amount' => $amount
            ]),
            'fees' => new Swagger\Client\Model\Money([
                'currency' => $currency,
                'amount' => $fees
            ]),
            'language' => $locale
        ]);

        try
        {
            $result = $this->marketPayApi()->RedsysPayIns->payInsRedsysRedsysPostPaymentByWeb(null, $reference);

            $mp_template_url .= '?' . http_build_query(array(
                'url' => urlencode($result->getUrl()),
                'Ds_SignatureVersion' => urlencode($result->getDsSignatureVersion()),
                'Ds_MerchantParameters' => urlencode($result->getDsMerchantParameters()),
                'Ds_Signature' => urlencode($result->getDsSignature())
            ));

            /** Return the RedirectUrl and the transaction_id **/
            return array(
                'redirect_url'   => $mp_template_url,
                'transaction_id' => $result->getPayInId(),
            );
        }
        catch (ApiException $e)
        {
            if (self::DEBUG)
            {
                echo __('Error: ApiException on create_payin_url', 'marketpay') . '<br/>';
                echo $e->getMessage() . "<br/>";
            }

            return false;
        }
    }

    /**
     * Get WireReference and BankAccount data for a bank_wire payment
     *
     */
    public function bankwire_payin_ref(
        $order_id, // Used to fill-in the "Tag" optional info
        $wp_user_id, // WP User ID
        $amount, // Amount
        $currency = 'EUR', // Currency
        $fees // Fees
    ) {
        /** Get mp_user_id and mp_wallet_id from wp_user_id **/
        $mp_user_id = $this->set_mp_user($wp_user_id);
        $wallets    = $this->set_mp_wallet($mp_user_id);

        if ( ! $wallets && ! (defined('DOING_AJAX') && DOING_AJAX))
        {
            $my_account = '<a href="' . wc_customer_edit_account_url() . '" title="' . __('My Account', 'marketpay') . '">' . __('My Account', 'marketpay') . '</a>';

            wp_die(sprintf(__('Your profile info needs to be completed. Please go to %s and fill-in all required fields.', 'marketpay'), $my_account));
        }

        /** Take first wallet with right currency **/
        foreach ($wallets as $wallet)
        {
            if ($wallet->Currency == $currency) $mp_wallet_id = $wallet->Id;
        }

        /** If no wallet abort **/
        if ( ! isset($mp_wallet_id) || !$mp_wallet_id) return false;

        try
        {
            $reference = new \Swagger\Client\Model\PayInBankwirePost([
                'tag' => 'WC Order #' . $order_id,
                'credited_wallet_id' => $mp_wallet_id,
                'debited_funds' => new Swagger\Client\Model\Money([
                    'amount' => $amount,
                    'currency' => $currency
                ]),
                'fees' => new Swagger\Client\Model\Money([
                    'amount' => $fees,
                    'currency' => $currency
                ])
            ]);

            $return = $this->marketPayApi()->BankwirePayIns->payInsBankwireBankwirePaymentByDirect($reference);

            return json_decode($return->__toString());
        }
        catch (ApiException $e)
        {
            return false;
        }
    }

    /**
     * Processes card payin refund
     * @see: https://github.com/Marketpay/marketpay2-php-sdk/blob/master/demos/workflow/scripts/refund-payin.php
     *
     */
    public function card_refund($order_id, $mp_transaction_id, $wp_user_id, $amount, $currency, $reason)
    {
        $reference = new Swagger\Client\Model\RedsysRefundPost([
            'tag' => 'WC Order #' . $order_id . ' - ' . $reason . ' - ValidatedBy:' . wp_get_current_user()->user_login,
            'debited_funds' => new Swagger\Client\Model\Money([
                'currency' => $currency,
                'amount' => $amount
            ]),
            'fees' => new Swagger\Client\Model\Money([
                'currency' => $currency,
                'amount' => 0
            ])
        ]);

        $result = $this->marketPayApi()->RedsysPayIns->payInsRedsysRedsysPostRefund(
            $mp_transaction_id,
            $reference
        );

        return $result;
    }

    /**
     * Perform MP wallet-to-wallet transfer with retained fees
     *
     * @see: https://github.com/Marketpay/marketpay2-php-sdk/blob/master/demos/workflow/scripts/transfer.php
     *
     * @param int $order_id
     * @param int $mp_transaction_id
     * @param int $wp_user_id
     * @param int $vendor_id
     * @param string $mp_amount        | money amount
     * @param string $mp_fees        | money amount
     * @param string $mp_currency
     * @return object Transfer result
     *
     */
    public function wallet_trans($order_id, $mp_transaction_id, $wp_user_id, $vendor_id, $mp_amount, $mp_fees, $mp_currency)
    {
        $mp_user_id   = $this->set_mp_user($wp_user_id);
        $mp_vendor_id = $this->set_mp_user($vendor_id);

        /** Get the user wallet that was used for the transaction **/
        $transaction       = $this->marketPayApi()->RedsysPayIns->payInsRedsysRedsysGetPayment($mp_transaction_id);
        $mp_user_wallet_id = $transaction->getCreditedWalletId();

        /** Get the vendor wallet **/
        $wallets = $this->set_mp_wallet($mp_vendor_id);

        /** Take first wallet with right currency **/
        foreach ($wallets as $wallet)
        {
            if ($wallet->Currency == $mp_currency)  $mp_vendor_wallet_id = $wallet->Id;
        }

        $Transfer                         = new MarketPay\Transfer();
        $Transfer->AuthorId               = $mp_user_id;
        $Transfer->DebitedFunds           = new MarketPay\Money();
        $Transfer->DebitedFunds->Currency = $mp_currency;
        $Transfer->DebitedFunds->Amount   = ($mp_amount * 100);
        $Transfer->Fees                   = new MarketPay\Money();
        $Transfer->Fees->Currency         = $mp_currency;
        $Transfer->Fees->Amount           = ($mp_fees * 100);
        $Transfer->DebitedWalletId        = $mp_user_wallet_id;
        $Transfer->CreditedWalletId       = $mp_vendor_wallet_id;
        $Transfer->Tag                    = 'WC Order #' . $order_id . ' - ValidatedBy:' . wp_get_current_user()->user_login;
        $Transfer->CreationDate           = time();

        $result = $this->legacyApi->Transfers->Create($Transfer);

        return $result;
    }

    /**
     * Get a list of failed payout transactions
     * For display in the dedicated admin dashboard widget
     *
     * @see: https://gist.github.com/hobailey/ae06c3ef51c1245132a7
     *
     */
    public function get_failed_payouts()
    {
        $pagination = new \MarketPay\Pagination(1, 100);

        $filter            = new \MarketPay\FilterEvents();
        $filter->EventType = \MarketPay\EventType::PayoutNormalFailed;

        $sorting = new \MarketPay\Sorting();
        $sorting->AddField("Date", \MarketPay\SortDirection::DESC);

        try
        {
            $failed_payouts = $this->legacyApi->Events->GetAll($pagination, $filter, $sorting);
        }
        catch (Exception $e)
        {
            $failed_payouts = array();
        }

        /** get refused kyc docs **/
        $pagination = new \MarketPay\Pagination(1, 100);

        $filter            = new \MarketPay\FilterEvents();
        $filter->EventType = \MarketPay\EventType::KycFailed;

        $sorting = new \MarketPay\Sorting();
        $sorting->AddField("Date", \MarketPay\SortDirection::DESC);

        try
        {
            $refused_kycs = $this->legacyApi->Events->GetAll($pagination, $filter, $sorting);
        }
        catch (Exception $e)
        {
            $refused_kycs = array();
        }

        return array(
            'failed_payouts' => $failed_payouts,
            'refused_kycs'   => $refused_kycs,
        );
    }

    /**
     * To check if the MP API is running in production or sandbox environment
     *
     * @return boolean
     */
    public function is_production()
    {
        return $this->mp_production;
    }

    /**
     * Get temporary folder path
     *
     */
    public function get_tmp_dir()
    {
        if ( ! $this->mp_loaded) return $this->set_tmp_dir();

        return $this->legacyApi->Config->TemporaryFolder;
    }

    /**
     * Get payin info (to confirm payment executed)
     *
     * @param int $transaction_id
     *
     */
    public function get_payin($transaction_id, $mp_payment_type = 'card')
    {
        try
        {
            if ($mp_payment_type == 'bank_wire')
            {
                return $this->marketPayApi()->BankwirePayIns->payInsBankwireBankwireGetPayment($transaction_id);
            }

            return $this->marketPayApi()->RedsysPayIns->payInsRedsysRedsysGetPayment($transaction_id);
        }
        catch (Exception $e)
        {
            return null;
        }
    }

    /**
     * Get the URL to access a User's MP dashboard page
     *
     * @param int $mp_user_id
     * @return string URL
     *
     */
    public function getDBUserUrl($mp_user_id)
    {
        return $this->mp_db_url . '/Users/' . $mp_user_id;
    }

    /**
     * Get the URL to access a Wallet's MP Payout Operation page
     *
     * @param int $mp_wallet_id
     * @return string URL
     *
     */
    public function getDBPayoutUrl($mp_wallet_id)
    {
        return $this->mp_db_url . '/Operations/PayOut?walletId=' . $mp_wallet_id;
    }

    /**
     * Get the URL to upload a KYC Document for that user
     *
     * @param string $mp_user_id
     * @return string URL
     */
    public function getDBUploadKYCUrl($mp_user_id)
    {
        return $this->mp_db_url . '/Operations/UploadKycDocument?userId=' . $mp_user_id;
    }

    /**
     * Get the URL of the webhooks dashboard
     *
     * @return string URL
     */
    public function getDBWebhooksUrl()
    {
        return $this->mp_db_url . '/Notifications';
    }

    /**
     * Gets the profile type of an existing MP user account
     *
     * @param int $mp_user_id
     * @return string|boolean
     */
    private function getDBUserPType($mp_user_id)
    {
        try
        {
            $marketUser = $this->legacyApi->Users->Get($mp_user_id);
        }
        catch (Exception $e)
        {
            $error_message = $e->getMessage();

            error_log(
                current_time('Y-m-d H:i:s', 0) . ': ' . $error_message . "\n\n",
                3,
                $this->logFilePath
            );

            echo '<div class="error"><p>' . __('Error:', 'marketpay') . ' ' .
            __('Marketpay API returned:', 'marketpay') . ' ';
            echo '&laquo;' . $error_message . '&raquo;</p></div>';
        }

        if (isset($marketUser) && $marketUser)
        {
            return $marketUser->PersonType;
        }
        else
        {
            return false;
        }
    }

    /**
     * Will create BUSINESS type account for Customers that become Vendors
     *
     * NOT USED
     *
     * @param int $wp_user_id    | WP user ID
     * @param string $p_type    | MP profile type
     */
    private function switchDBUserPType($wp_user_id, $p_type)
    {
        /**
         * We only switch accounts when a Customer becomes a Vendor,
         * ie vendors that become customers keep their existing vendor account
         *
         */
        if ('BUSINESS' != $p_type) return;

        /** We will creata a new MP BUSINESS account for that user **/

        /** We store a different mp_user_id for production and sandbox environments **/
        $umeta_key = 'mp_user_id';

        if ( ! $this->mp_production) $umeta_key .= '_sandbox';

        delete_user_meta($wp_user_id, $umeta_key);

        $this->set_mp_user($wp_user_id, 'BUSINESS');
    }

    /**
     * MP payout transaction (for vendors)
     * @see: https://github.com/Marketpay/marketpay2-php-sdk/blob/master/demos/workflow/scripts/payout.php
     *
     * @param int $wp_user_id
     * @param int $mp_account_id
     * @param int $order_id
     * @param string $currency
     * @param float $amount
     * @param float $fees
     * @return boolean
     *
     */
    public function payout($wp_user_id, $mp_account_id, $order_id, $currency, $amount, $fees)
    {
        /** The vendor **/
        $mp_vendor_id = $this->set_mp_user($wp_user_id);

        /** Get the vendor wallet **/
        $wallets = $this->set_mp_wallet($mp_vendor_id);

        /** Take first wallet with right currency **/
        foreach ($wallets as $wallet)
        {
            if ($wallet->Currency == $currency) $mp_vendor_wallet_id = $wallet->Id;
        }

        if ( ! $mp_vendor_wallet_id) return false;

        $PayOut                                      = new \MarketPay\PayOut();
        $PayOut->AuthorId                            = $mp_vendor_id;
        $PayOut->DebitedWalletID                     = $mp_vendor_wallet_id;
        $PayOut->DebitedFunds                        = new \MarketPay\Money();
        $PayOut->DebitedFunds->Currency              = $currency;
        $PayOut->DebitedFunds->Amount                = $amount * 100;
        $PayOut->Fees                                = new \MarketPay\Money();
        $PayOut->Fees->Currency                      = $currency;
        $PayOut->Fees->Amount                        = $fees * 100;
        $PayOut->PaymentType                         = "BANK_WIRE";
        $PayOut->MeanOfPaymentDetails                = new \MarketPay\PayOutPaymentDetailsBankWire();
        $PayOut->MeanOfPaymentDetails->BankAccountId = $mp_account_id;
        $PayOut->MeanOfPaymentDetails->BankWireRef   = 'ID ' . $order_id;
        $PayOut->Tag                                 = 'Commission for WC Order #' . $order_id . ' - ValidatedBy:' . wp_get_current_user()->user_login;
        $PayOut->CreationDate                        = time();

        $result = $this->legacyApi->PayOuts->Create($PayOut);

        return $result;
    }

    /**
     * Retrieve info about an existing (past) payout
     *
     * @param int $payOutId
     * @return object \MarketPay\PayOut
     */
    public function get_payout($payOutId)
    {
        return $this->legacyApi->PayOuts->Get($payOutId);
    }

    /**
     * Retrieve info about an existing KYV document
     *
     * @param int $kycDocumentId
     * @return object \MarketPay\KycDocument
     */
    public function get_kyc($kycDocumentId)
    {
        return $this->legacyApi->KycDocuments->Get($kycDocumentId);
    }

    /**
     * Returns plugin's log file path
     *
     */
    public function get_logfilepath()
    {
        return apply_filters('marketpay_logfilepath', $this->logFilePath);
    }

    /**
     * Get a webhook registered in the MP API by its type.
     * Return false if not present.
     *
     */
    public function get_webhook_by_type($webhook_type)
    {
        $pagination = new \MarketPay\Pagination(1, 100); //get the first page with 100 elements per page

        try
        {
            $list = $this->legacyApi->Hooks->GetAll($pagination);
        }
        catch (Exception $e)
        {
            return false;
        }

        foreach ($list as $hook)
        {
            if ($hook->EventType == $webhook_type) return $hook;
        }

        return false;
    }

    /**
     * Check that a Marketpay incoming webhook is enabled & valid
     *
     * @param object $hook - Marketpay Hook object
     * @return boolean
     */
    public function hook_is_valid($hook)
    {
        if ($hook->Status != 'ENABLED') return false;
        if ($hook->Validity != 'VALID') return false;

        return true;
    }

    /**
     * Registers a new webhook with the Marketpay API
     * creates the webhook and returns its Id if successful, false otherwise
     *
     */
    public function create_webhook($webhook_prefix, $webhook_key, $event_type)
    {
        $inboundPayinWPUrl = site_url($webhook_prefix . '/' . $webhook_key . '/' . $event_type);

        $hook              = new \MarketPay\Hook();
        $hook->Url         = $inboundPayinWPUrl;
        $hook->Status      = 'ENABLED';
        $hook->Validity    = 'VALID';
        $hook->EventType   = $event_type;

        try
        {
            $result = $this->legacyApi->Hooks->Create($hook);
        }
        catch (Exception $e)
        {
            return false;
        }

        if ($result->Id) return $result->Id;

        return false;
    }

    /**
     * Updates an existing webhook of the Marketpay API
     * returns its Id if successful, false otherwise
     *
     */
    public function update_webhook($existing_hook, $webhook_prefix, $webhook_key, $event_type)
    {
        $inboundPayinWPUrl = site_url($webhook_prefix . '/' . $webhook_key . '/' . $event_type);
        $hook              = new \MarketPay\Hook();
        $hook->Url         = $inboundPayinWPUrl;
        $hook->Status      = 'ENABLED';
        $hook->Validity    = 'VALID';
        $hook->EventType   = $event_type;
        $hook->Id          = $existing_hook->Id;

        try
        {
            $result = $this->legacyApi->Hooks->Update($hook);
        }
        catch (Exception $e)
        {
            return false;
        }

        if ($result->Id) return $result->Id;

        return false;
    }

    /**
     * Check that a webhook of the specified type is registered
     *
     * @param string $event_type
     * @return boolean
     */
    private function check_webhook($webhook_key, $event_type)
    {
        if ($hook = $this->get_webhook_by_type($event_type))
        {
            if ( ! empty($webhook_key) && $this->hook_is_valid($hook))
            {
                $inboundPayinWPUrl = site_url(
                    marketpayWCWebHooks::WEBHOOK_PREFIX . '/' .
                    $webhook_key . '/' .
                    $event_type
                );

                if ($inboundPayinWPUrl == $hook->Url) return true;
            }
        }

        return false;
    }
}
