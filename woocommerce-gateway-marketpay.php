<?php
/*
Plugin Name: WooCommerce Marketpay Gateway
Plugin URI: https://wordpress.org/plugins/woocommerce-gateway-marketpay/
Description: Official WooCommerce checkout gateway for the <a href="https://marketpay.io/">Marketpay</a> payment solution dedicated to marketplaces.
Version: 2.2.1
Author: Ferran Figueredo
Author URI: https://lemonpay.me/
Text Domain: marketpay
Domain Path: /languages
License: GPL2
 */

$version = '2.2.1';

/** Custom classes includes **/
include_once dirname(__FILE__) . '/src/conf.inc.php'; // Configuration class
include_once dirname(__FILE__) . '/src/hooks.inc.php'; // Action and filter hooks class (will include the payment gateway class when appropriate)
include_once dirname(__FILE__) . '/src/plugin.inc.php'; // Plugin maintenance class
include_once dirname(__FILE__) . '/src/main.inc.php'; // Main plugin class
include_once dirname(__FILE__) . '/src/validation.inc.php'; // User profile field validation methods
include_once dirname(__FILE__) . '/src/marketpay.inc.php'; // Marketpay access methods
include_once dirname(__FILE__) . '/src/webhooks.inc.php'; // Incoming webhooks handler

// Ajax methods
if (is_admin() && defined('DOING_AJAX') && DOING_AJAX)
{
    include_once dirname(__FILE__) . '/src/ajax.inc.php';
}

// Admin specific methods
if (is_admin())
{
    include_once dirname(__FILE__) . '/src/admin.inc.php';
}

/** Main plugin class instantiation **/
global $mrkpp_o;

$mrkpp_o = new marketpayWCMain($version);