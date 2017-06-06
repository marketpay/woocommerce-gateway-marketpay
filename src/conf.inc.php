<?php
/**
 * Marketpay WooCommerce plugin configuration class
 *
 * @author ferran@lemonpay.me
 * @see: https://github.com/marketpay/woocommerce-gateway-marketpay
 *
 **/
class marketpayWCConfig
{
    /** Class constants **/
    const DEBUG          = false; // Turns debugging messages on or off (should be false for production)
    const WC_PLUGIN_PATH = 'woocommerce/woocommerce.php';
    const WV_PLUGIN_PATH = 'wc-vendors/class-wc-vendors.php';
    const WV_TABLE_NAME  = 'pv_commission'; // Name of the custom table created by the WV plugin
    const WV_OPTION_KEY  = 'wc_prd_vendor_options'; // Name of the option key where WV options are stored
    const KEY_FILE_NAME  = 'secret.key.php'; // Need to make it a PHP file in order to prevent it from being downloaded
    const OPTION_KEY     = 'marketpay_settings'; // Where our options are stored in the wp_options table

    /** Default plugin options (the ones that will be stored in marketpayWCConfig::OPTION_KEY) **/
    public static $defaults = array(
        'prod_or_sandbox'         => 'sandbox',
        'sand_client_id'          => '',
        'sand_passphrase'         => '',
        'prod_client_id'          => '',
        'prod_passphrase'         => '',
        'default_buyer_status'    => 'individuals',
        'default_vendor_status'   => 'either',
        'default_business_status' => 'either',
        'per_item_wf'             => '',
        'webhook_key'             => '',
        'plugin_version'          => '0.2.2',
    );

    /** Supported currencies **/
    public static $allowed_currencies = array(
        'EUR',
        'GBP'
    );

    /**
     * Bank accounts required fields configuration
     * @see: https://docs.marketpay.io/api-references/bank-accounts/
     *
     * i18n _e() is applied when displaying the labels
     *
     */
    public static $account_types = array(
        'IBAN'  => array(
            'vendor_iban' => array(
                'label'       => 'IBAN',
                'required'    => 1,
                'format'      => 'text:27',
                'placeholder' => '____ ____ ____ ____ ____',
                'redact'      => '4,4',
                'validate'    => '^[a-zA-Z]{2}\d{2}\s*(\w{4}\s*){2,7}\w{1,4}\s*$',
                'mp_property' => 'IBAN',
            ),
            'vendor_bic'  => array(
                'label'       => 'BIC',
                'required'    => 1,
                'format'      => 'text:11',
                'placeholder' => '___________',
                'redact'      => '0,2',
                'validate'    => '^[a-zA-Z]{6}\w{2}(\w{3})?$',
                'mp_property' => 'BIC',
            ),
        )
    );
}
