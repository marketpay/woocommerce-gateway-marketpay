<?php

class marketpayWCPlugin
{
    /**
     * Upon plugin version number change
     *
     * @param string $old_version
     * @param string $new_version
     */
    public static function upgrade_plugin($old_version, $new_version, $options)
    {
        $options['plugin_version'] = $new_version;

        update_option(marketpayWCConfig::OPTION_KEY, $options);
    }

    /**
     * Upon plugin activation
     * must be a static function
     *
     * @see: http://codex.wordpress.org/Function_Reference/register_activation_hook
     *
     */
    public static function on_plugin_activation()
    {
        marketpayWCWebHooks::addRewriteRule();

        flush_rewrite_rules();
    }

    /**
     * Load the text translation files
     *
     */
    public static function load_plugin_textdomain()
    {
        load_plugin_textdomain('marketpay', false, plugin_basename(dirname(dirname(__FILE__))) . '/languages');
    }

    /**
     * Load the payment gateway class file after all plugin initializations
     * @see: https://developer.wordpress.org/plugins/internationalization/how-to-internationalize-your-plugin/#loading-text-domain
     *
     */
    public static function include_payment_gateway()
    {
        if (class_exists('WC_Payment_Gateway')) {
            include_once dirname(__FILE__) . '/gateway.inc.php';
        }
    }
}
