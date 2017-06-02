<?php
/**
 * Marketpay WooCommerce plugin filter and action hooks class
 *
 * @author ferran@lemonpay.me
 * @see: https://github.com/marketpay/woocommerce-gateway-marketpay
 *
 **/
class marketpayWCHooks
{
    public static function set_hooks($marketpayWCMain, $marketpayWCAdmin = null)
    {

        /** SITE WIDE HOOKS **/

        /**
         * Site-wide WP hooks
         *
         */

        /** Load i18n **/
        add_action('plugins_loaded', array('marketpayWCPlugin', 'load_plugin_textdomain'));

        /** Load payment gateway class **/
        add_action('plugins_loaded', array('marketpayWCPlugin', 'include_payment_gateway'));

        /** Trigger event when user becomes vendor **/
        add_action('set_user_role', array($marketpayWCMain, 'on_set_user_role'), 10, 3);

        /** Trigger event when user registers (front & back-office) **/
        add_action('user_register', array($marketpayWCMain, 'on_user_register'), 10, 1); //<- not working for front-end reg
        /** Front-end registration; previous action on same hook hereunder **/
        //add_action( 'woocommerce_created_customer',        array( $marketpayWCMain, 'on_user_register' ), 11, 1 );

        /** Passphrase encryption **/
        add_filter('pre_update_option_' . marketpayWCConfig::OPTION_KEY, array($marketpayWCMain, 'encrypt_passphrase'), 10, 2);
        add_filter('option_' . marketpayWCConfig::OPTION_KEY, array($marketpayWCMain, 'decrypt_passphrase'), 10, 1);

        /**
         * Site-wide WC hooks
         *
         */

        /** Register MP payment gateway **/
        add_filter('woocommerce_payment_gateways', array('WC_Gateway_Marketpay', 'add_gateway_class'));

        /** Do wallet transfers when an order gets completed **/
        add_action('woocommerce_order_status_completed', array($marketpayWCMain, 'on_order_completed'), 10, 1);

        /**
         * Site-wide WV hooks
         *
         */

        /** Trigger event when WV store settings are updated **/
        add_action('wcvendors_shop_settings_saved', array($marketpayWCMain, 'on_shop_settings_saved'), 10, 1);

        /** FRONT END HOOKS **/

        /**
         * Front-end WP hooks
         *
         */

        /** Payline form template shortcode **/
        add_shortcode('marketpay_payform', array($marketpayWCMain, 'payform_shortcode'));

        /**
         * Front-end WC hooks
         *
         */

        /** Add required fields to the user registration form **/
        add_action('woocommerce_register_form_start', array($marketpayWCMain, 'wooc_extra_register_fields'));
        add_action('woocommerce_register_post', array($marketpayWCMain, 'wooc_validate_extra_register_fields'), 10, 3);
        add_action('woocommerce_created_customer', array($marketpayWCMain, 'wooc_save_extra_register_fields'), 10, 1);

        /** Add required fields on edit-account form **/
        add_action('woocommerce_edit_account_form', array($marketpayWCMain, 'wooc_extra_register_fields'));
        //add_action( 'user_profile_update_errors',        array( $marketpayWCMain, 'wooc_validate_extra_register_fields_user' ), 10, 3 );
        add_filter('woocommerce_save_account_details_required_fields', array($marketpayWCMain, 'wooc_account_details_required'));
        add_action('woocommerce_save_account_details', array($marketpayWCMain, 'wooc_save_extra_register_fields'), 10, 1);
        //for edit front
        add_action('woocommerce_save_account_details_errors', array($marketpayWCMain, 'wooc_validate_extra_register_fields_userfront'), 10, 2);

        /** Add required fields on checkout form **/
        add_filter('woocommerce_checkout_fields', array($marketpayWCMain, 'custom_override_checkout_fields'), 99999);
        add_action('woocommerce_checkout_process', array($marketpayWCMain, 'wooc_validate_extra_register_fields_checkout'));
        add_action('woocommerce_after_order_notes', array($marketpayWCMain, 'after_checkout_fields'));
        add_action('woocommerce_checkout_update_user_meta', array($marketpayWCMain, 'wooc_save_extra_register_fields'));

        /** Show MP wallets list on my-account page **/
        //add_action( 'woocommerce_before_my_account',     array( $marketpayWCMain, 'before_my_account' ) );

        /** Process order status after order payment completed **/
        add_action('template_redirect', array($marketpayWCMain, 'order_redirect'), 1, 1);
        add_action('woocommerce_thankyou', array($marketpayWCMain, 'order_received'), 1, 1);
        add_filter('woocommerce_add_notice', array($marketpayWCMain, 'intercept_messages_cancel_order'), 1, 1);

        /** When billing address is changed by customer **/
        add_action('woocommerce_customer_save_address', array($marketpayWCMain, 'on_shop_settings_saved'));

        /** When order received, on thankyou page, display bankwire references if necessary **/
        add_action('woocommerce_thankyou_marketpay', array($marketpayWCMain, 'display_bankwire_ref'), 10, 1);

        /**
         * Front-end WV hooks
         *
         */

        /** Bank account fields on the shop settings **/
        add_action('wcvendors_settings_after_paypal', array($marketpayWCMain, 'bank_account_form'));
        //add_action( 'wcvendors_shop_settings_saved', array( $marketpayWCMain, 'save_account_form' ) );
        add_action('wcvendors_shop_settings_saved', array($marketpayWCMain, 'shop_settings_saved'), 10, 1);
        //add_action( 'wcv_pro_store_settings_saved', array( $marketpayWCMain, 'save_account_form' ) );    // Support for WV Pro version's front-end store dashboard
        add_action('wcv_pro_store_settings_saved', array($marketpayWCMain, 'shop_settings_saved'), 10, 1);

        //@see: https://github.com/wcvendors/wcvendors/blob/8443c27704e59fd222ba8d65a6438e0251820910/classes/admin/class-admin-users.php#L382
        //this hook fires up randomly in the WV version we used for development
        //add_action( 'wcvendors_update_admin_user', array( $marketpayWCMain, 'shop_settings_admin_saved' ), 10, 1 );
        //this hook is present instead:
        add_action('wcvendors_shop_settings_admin_saved', array($marketpayWCMain, 'shop_settings_admin_saved'), 10, 1);

        /** Refuse item button in vendor dashboard order list **/
        add_filter('wcvendors_order_actions', array($marketpayWCMain, 'record_current_order'), 10, 2);
        add_filter('woocommerce_order_items_meta_display', array($marketpayWCMain, 'refuse_item_button'), 10, 2);

        /** BACK OFFICE HOOKS **/

        /**
         * Back-office WP hooks
         *
         */
        if (!is_admin()) {
            return;
        }

        /** Load admin CSS stylesheet **/
        add_action('admin_enqueue_scripts', array($marketpayWCAdmin, 'load_admin_styles'));

        /** Load admin JS script **/
        add_action('admin_enqueue_scripts', array($marketpayWCAdmin, 'enqueue_market_admin_scripts'));

        /** Add admin settings menu item **/
        add_action('admin_menu', array($marketpayWCAdmin, 'settings_menu'));

        /** Add admin settings options **/
        add_action('admin_init', array($marketpayWCAdmin, 'register_mysettings'));

        /** Custom admin notice if config is incomplete **/
        add_action('admin_notices', array($marketpayWCAdmin, 'admin_notices'));

        /** Failed payouts & refused KYCs admin dashboard widget **/
        add_action('wp_dashboard_setup', array($marketpayWCAdmin, 'add_dashboard_widget'));

        /** Add required fields to user-edit profile admin page **/
        add_action('show_user_profile', array($marketpayWCAdmin, 'user_edit_required'), 1);
        add_action('edit_user_profile', array($marketpayWCAdmin, 'user_edit_required'), 1);
        add_action('user_new_form', array($marketpayWCAdmin, 'user_edit_required'), 1);
        add_action('personal_options_update', array($marketpayWCAdmin, 'user_edit_save'), 100, 1);
        add_action('edit_user_profile_update', array($marketpayWCAdmin, 'user_edit_save'), 100, 1);
        add_action('user_register', array($marketpayWCAdmin, 'user_edit_save'), 9, 1);
        add_action('user_profile_update_errors', array($marketpayWCAdmin, 'user_edit_checks'), 10, 3);

        /** Custom column to show if users have an MP account **/
        add_filter('manage_users_columns', array($marketpayWCAdmin, 'manage_users_columns'));
        add_filter('manage_users_sortable_columns', array($marketpayWCAdmin, 'manage_sortable_users_columns'));
        add_filter('manage_users_custom_column', array($marketpayWCAdmin, 'users_custom_column'), 10, 3);
        add_filter('pre_user_query', array($marketpayWCAdmin, 'user_column_orderby'));

        /**
         * Back-office WC hooks
         *
         */

        /** Display custom info on the order admin screen **/
        add_action('add_meta_boxes', array($marketpayWCAdmin, 'add_meta_boxes'), 20);

        /** Register webhook when activating direct bankwire payment **/
        add_action('woocommerce_update_options_payment_gateways_marketpay', array($marketpayWCAdmin, 'register_all_webhooks'));

        /**
         * Back-office WV hooks
         *
         */

        /**
         * Add bulk action to pay commissions
         *
         */
        //add_filter( 'bulk_actions-woocommerce_page_pv_admin_commissions', array( $marketpayWCMain, 'bulk_actions' ), 10, 1 );
        add_action('admin_footer-woocommerce_page_pv_admin_commissions', array($marketpayWCAdmin, 'addBulkActionInFooter'));
        add_action('load-woocommerce_page_pv_admin_commissions', array($marketpayWCAdmin, 'vendor_payouts'));
    }
}
