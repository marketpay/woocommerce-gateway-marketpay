<?php

class marketpayWCAdmin
{
    private $options;
    private $mp; // This will store our mpAccess class instance
    private $allowed_currencies; // Loaded from conf.inc.php
    private $marketpayWCMain; // The marketpayWCMain object that instanciated us
    private $marketpayWCValidation; // Will hold user profile validation class

    /**
     * Class constructor
     *
     */
    public function __construct($marketpayWCMain = null)
    {
        $this->marketpayWCMain    = $marketpayWCMain;
        $this->options            = $marketpayWCMain->options;
        $this->mp                 = mpAccess::getInstance();
        $this->allowed_currencies = marketpayWCConfig::$allowed_currencies;

        /** Instantiate user profile field validations class **/
        $this->marketpayWCValidation = new marketpayWCValidation($this);
    }

    /**
     * Load our custom CSS stylesheet on appropriate admin screens
     *
     */
    public function load_admin_styles()
    {
        $screen = get_current_screen();

        if (
            $screen->id != 'toplevel_page_' . marketpayWCConfig::OPTION_KEY &&
            !($screen->id == 'woocommerce_page_wc-settings' && isset($_GET['section']) && 'wc_gateway_marketpay' == $_GET['section']) &&
            $screen->id != 'user-edit' &&
            !($screen->id == 'user' && $screen->action == 'add')
        ) {
            return;
        }

        wp_enqueue_style(
            'marketpay-admin',
            plugins_url('/assets/css/marketpay-admin.css', dirname(__FILE__)),
            false, '0.1.1'
        );

        wp_register_style(
            'jquery-ui',
            plugins_url('/assets/css/jquery-ui.css', dirname(__FILE__)),
            false, '1.8'
        );

        wp_enqueue_style('jquery-ui');
    }

    /**
     * Load our admin scripts on user edit and create page only
     *
     */
    public function enqueue_market_admin_scripts()
    {
        $screen = get_current_screen();

        if (
            $screen->id != 'user-edit' &&
            !($screen->id == 'user' && $screen->action == 'add')
        ) {
            return;
        }

        wp_enqueue_script(
            'wc-admin-scripts',
            plugins_url('/assets/js/admin-type-user.js', dirname(__FILE__)),
            array('jquery')
        );

        /** Initialize our admin script with third-party plugin independent data **/
        $vendor_role     = apply_filters('marketpay_vendor_role', 'vendor');
        $translate_array = array(
            'vendor_role' => $vendor_role,
        );

        wp_localize_script('wc-admin-scripts', 'translate_object', $translate_array);
    }

    /**
     * Add admin settings menu item
     * This is a WP 'admin_menu' action hook - must be a public method
     *
     */
    public function settings_menu()
    {
        add_menu_page(
            __('Marketpay', 'marketpay'),
            __('Marketpay', 'marketpay'),
            'manage_options', // Requires Administrator privilege by default,
            // @see: https://codex.wordpress.org/Roles_and_Capabilities
            marketpayWCConfig::OPTION_KEY,
            array($this, 'settings_screen'),
            plugins_url('/assets/img/mp-icon.png', dirname(__FILE__))
        );
    }

    /**
     * Add admin settings menu screen
     * @see: https://codex.wordpress.org/User:Wycks/Styling_Option_Pages
     * This is a WP add_menu_page() callback - must be a public method
     *
     */
    public function settings_screen()
    {
        /** Perform a Marketpay API connection test **/
        if (isset($this->options['prod_or_sandbox']))
        {
            $connection_test_result = $this->mp->connection_test();
        }

        /** Display a notice message in admin page header **/
        if (isset($connection_test_result) && is_array($connection_test_result))
        {
            echo '<div class="updated"><p>' .
            __('Marketpay API connected succesfully!', 'marketpay') .
                '</p></div>';
        }
        else
        {
            if (isset($this->options['prod_or_sandbox']))
            {
                echo '<div class="error"><p>' .
                __('Marketpay API Connection problem:', 'marketpay') . ' ' .
                __('the connection test returned an unexpected result', 'marketpay') .
                    '</p></div>';
            }

            if (marketpayWCConfig::DEBUG && isset($result))
            {
                var_dump($result);
            }
        }
        ?>
            <div class="wrap">
                <div id="icon-plugins" class="icon32"></div>
                <h2><?php _e('Marketpay Settings &amp; Status', 'marketpay');?></h2>
                <div class="description">
                <?php _e('Setup your Marketpay credentials &amp; check system configuration.', 'marketpay');?>
                </div>

                <br class="clear" />

                <form method="post" action="options.php">
                    <div class="mnt-options">
                        <?php settings_fields('mpwc-general');?>
                        <?php do_settings_sections(marketpayWCConfig::OPTION_KEY);?>
                        <?php submit_button();?>
                    </div>
                </form>

                <form>
                <div class="metabox-holder">
                    <div class="postbox-container marketpay-status">

                        <!-- /** Standard WP admin block ( div postbox / h3 hndle / div inside / p ) **/ -->
                        <div class="postbox" id="mp_status">
                            <h3 class="hndle"><?php _e('Marketpay status', 'marketpay');?></h3>
                            <div class="inside">
                                <?php if (isset($this->options['prod_or_sandbox'])): ?>
                                <?php $this->display_status($connection_test_result);?>
                                <?php else: ?>
                                <?php _e('The Marketpay payment gateway needs to be configured.', 'marketpay');?>
                                <?php endif;?>
                            </div><!--  // / inside -->
                        </div><!--  // / postbox -->

                    </div><!--  // / postbox-container -->
                </div><!--  // / metabox-holder -->
                </form>

            </div><!--  // / wrap -->
        <?php
    }

    /**
     * Add admin settings options
     * @see: https://codex.wordpress.org/Creating_Options_Pages
     * This is a WP 'admin_init' action hook - must be a public method
     *
     */
    public function register_mysettings()
    {
        add_settings_section(
            'mpwc-general', // Section ID
            __('General settings', 'marketpay'), // Section title
            null, // Optional callback
            marketpayWCConfig::OPTION_KEY// Page
        );

        add_settings_field(
            'prod_or_sandbox', // Field ID
            __('Production or sandbox', 'marketpay'), // Field Title
            array($this, 'prod_or_sandbox_field_callback'), // Callback
            marketpayWCConfig::OPTION_KEY, // Page
            'mpwc-general' // Section
        );

        add_settings_field(
            'sand_client_id', // Field ID
            __('Sandbox Client ID', 'marketpay'), // Field Title
            array($this, 'text_field_callback'), // Callback
            marketpayWCConfig::OPTION_KEY, // Page
            'mpwc-general', // Section
            array('field_id' => 'sand_client_id', 'label_for' => __('Sandbox Client ID', 'marketpay'))
        );

        add_settings_field(
            'sand_passphrase', // Field ID
            __('Sandbox passphrase', 'marketpay'), // Field Title
            array($this, 'text_field_callback'), // Callback
            marketpayWCConfig::OPTION_KEY, // Page
            'mpwc-general', // Section
            array('field_id' => 'sand_passphrase', 'label_for' => __('Sandbox passphrase', 'marketpay'))
        );

        add_settings_field(
            'prod_client_id', // Field ID
            __('Production Client ID', 'marketpay'), // Field Title
            array($this, 'text_field_callback'), // Callback
            marketpayWCConfig::OPTION_KEY, // Page
            'mpwc-general', // Section
            array('field_id' => 'prod_client_id', 'label_for' => __('Production Client ID', 'marketpay'))
        );

        add_settings_field(
            'prod_passphrase', // Field ID
            __('Production passphrase', 'marketpay'), // Field Title
            array($this, 'text_field_callback'), // Callback
            marketpayWCConfig::OPTION_KEY, // Page
            'mpwc-general', // Section
            array('field_id' => 'prod_passphrase', 'label_for' => __('Production passphrase', 'marketpay'))
        );

        add_settings_field(
            'default_buyer_status', // Field ID
            __('All buyers are', 'marketpay'), // Field Title
            array($this, 'select_field_callback'), // Callback
            marketpayWCConfig::OPTION_KEY, // Page
            'mpwc-general', // Section
            array('field_id' => 'default_buyer_status', 'label_for' => __('All buyers are', 'marketpay'))
        );

        add_settings_field(
            'default_vendor_status', // Field ID
            __('All vendors are', 'marketpay'), // Field Title
            array($this, 'select_field_callback'), // Callback
            marketpayWCConfig::OPTION_KEY, // Page
            'mpwc-general', // Section
            array('field_id' => 'default_vendor_status', 'label_for' => __('All vendors are', 'marketpay'))
        );

        add_settings_field(
            'default_business_type', // Field ID
            __('All businesses are', 'marketpay'), // Field Title
            array($this, 'select_field_callback'), // Callback
            marketpayWCConfig::OPTION_KEY, // Page
            'mpwc-general', // Section
            array('field_id' => 'default_business_type', 'label_for' => __('All businesses are', 'marketpay'))
        );

        add_settings_field(
            'webhook_key',
            ' ',
            array($this, 'hidden_field_callback'),
            marketpayWCConfig::OPTION_KEY,
            'mpwc-general',
            array('field_id' => 'webhook_key')
        );

        register_setting(
            'mpwc-general', // Section (Option group)
            marketpayWCConfig::OPTION_KEY, // Page (Option name)
            array($this, 'sanitize_settings')
        );
    }

    /**
     * Sanitize plugin settings fields
     * @param array $settings
     * @return array $settings
     * This is a WP register_setting() callback - must be a public method
     */
    public function sanitize_settings($settings)
    {
        $settings['prod_or_sandbox'] = ('prod' == $settings['prod_or_sandbox'] ? 'prod' : 'sandbox');
        $settings['sand_client_id']  = sanitize_text_field($settings['sand_client_id']);
        $settings['sand_passphrase'] = sanitize_text_field($settings['sand_passphrase']);

        return $settings;
    }

    /**
     * Display a hidden field in the plugin settings screen
     *
     * @param array $args
     */
    public function hidden_field_callback($args)
    {
        $html    = '';
        $f_id    = $args['field_id'];
        $options = $this->options;
        $value   = '';

        if (isset($options[$f_id]))
        {
            $value = esc_attr($options[$f_id]);
        }

        $html .= '<input type="hidden" id="' . $f_id . '" ' .
        'name="' . marketpayWCConfig::OPTION_KEY . '[' . $f_id . ']" ' .
            'value="' . $value . '" ' .
            '/>';

        echo $html;
    }

    /**
     * Display settings radio field to select prod or sandbox
     * This is a WP add_settings_field() callback - must be a public method
     *
     */
    public function prod_or_sandbox_field_callback()
    {
        $options = $this->options;
        $html    = '';

        $current = isset($options['prod_or_sandbox']) ? $options['prod_or_sandbox'] : 'sandbox';

        $html .= '<input type="radio" id="prod_or_sandbox_prod" name="' . marketpayWCConfig::OPTION_KEY . '[prod_or_sandbox]" value="prod"' . checked('prod', $current, false) . '/>';
        $html .= '<label for="prod_or_sandbox_prod">' . __('Production', 'marketpay') . '</label> ';

        $html .= '<input type="radio" id="prod_or_sandbox_sandbox" name="' . marketpayWCConfig::OPTION_KEY . '[prod_or_sandbox]" value="sandbox"' . checked('sandbox', $current, false) . '/>';
        $html .= '<label for="prod_or_sandbox_sandbox">' . __('Sandbox', 'marketpay') . '</label>';

        $html .= "
            <script>
            (function($) {
                $(document).ready(function() {
                    if( $('#prod_or_sandbox_prod').is(':checked') ){
                        envSwitch( 'prod' );
                    } else {
                        envSwitch( 'sandbox' );
                    }
                    $('#prod_or_sandbox_prod').on( 'change', function( e ){
                        envSwitch($(this).val());
                    });
                    $('#prod_or_sandbox_sandbox').on( 'change', function( e ){
                        envSwitch($(this).val());
                    });
                });
                function envSwitch( current ) {
                    switch( current ) {
                        case 'prod':
                            $('#sand_client_id').closest('tr').hide();
                            $('#sand_passphrase').closest('tr').hide();
                            $('#prod_client_id').closest('tr').show();
                            $('#prod_passphrase').closest('tr').show();
                            break;
                        case 'sandbox':
                            $('#sand_client_id').closest('tr').show();
                            $('#sand_passphrase').closest('tr').show();
                            $('#prod_client_id').closest('tr').hide();
                            $('#prod_passphrase').closest('tr').hide();
                            break;
                    }
                }
            })( jQuery );
            </script>
        ";

        echo $html;
    }

    /**
     * Display settings text fields
     * @param array $args
     * This is a WP add_settings_field() callback - must be a public method
     *
     */
    public function text_field_callback($args)
    {
        $type    = 'text';
        $value   = '';
        $options = $this->options;
        $html    = '';
        $f_id    = $args['field_id'];

        if (isset($options[$f_id]))
        {
            $value = esc_attr($options[$f_id]);
        }

        /** Redact passphrases **/
        if (preg_match('/pass/', $f_id))
        {
            $type  = 'password';
            $value = str_repeat('*', strlen($value));
        }

        $html .= '<input type="' . $type . '" id="' . $f_id . '" ' .
        'name="' . marketpayWCConfig::OPTION_KEY . '[' . $f_id . ']" ' .
            'value="' . $value . '" ' .
            'class="regular-text ltr" />';

        echo $html;
    }

    /**
     * Display settings checkbox fields
     * @param array $args
     * This is a WP add_settings_field() callback - must be a public method
     *
     */
    public function checkbox_field_callback($args)
    {
        if (!isset($options['per_item_wf'])) {
            $options['per_item_wf'] = '';
        }

        $options = $this->options;
        $html    = '';
        $f_id    = $args['field_id'];
        $current = isset($options[$f_id]) ? $options[$f_id] : '';

        $html .= '<input type="checkbox" id="' . $f_id . '" ' .
        'name="' . marketpayWCConfig::OPTION_KEY . '[' . $f_id . ']" ' .
        'value="yes" ' .
        checked('yes', $current, false) .
            ' class="" />';

        echo $html;
    }

    /**
     * Display settings select fields
     * @param array $args
     * This is a WP add_settings_field() callback - must be a public method
     *
     */
    public function select_field_callback($args)
    {
        $options = $this->options;

        if (!isset($options['default_buyer_status'])) {
            $options['default_buyer_status'] = 'individuals';
        }

        if (!isset($options['default_vendor_status'])) {
            $options['default_vendor_status'] = 'either';
        }

        if (!isset($options['default_business_type'])) {
            $options['default_business_type'] = 'either';
        }

        $html    = '';
        $f_id    = $args['field_id'];
        $current = isset($options[$f_id]) ? $options[$f_id] : '';

        $html .= '<select id="' . $f_id . '" ' .
        'name="' . marketpayWCConfig::OPTION_KEY . '[' . $f_id . ']">';

        if ('default_business_type' == $f_id) {
            $html .= "<option value='organisations' " . selected('organisations', $current, false) . '>' .
            __('Organisations', 'marketpay') . '</option>';
            $html .= "<option value='soletraders' " . selected('soletraders', $current, false) . '>' .
            __('Soletraders', 'marketpay') . '</option>';
        } else {
            $html .= "<option value='individuals' " . selected('individuals', $current, false) . '>' .
            __('Individuals', 'marketpay') . '</option>';
        }
        $html .= "<option value='businesses' " . selected('businesses', $current, false) . '>' .
        __('Businesses', 'marketpay') . '</option>';
        $html .= "<option value='either' " . selected('either', $current, false) . '>' .
        __('Either', 'marketpay') . '</option>';

        $html .= '</select>';

        echo $html;
    }

    /**
     * Check that a valid multivendor plugin is present
     *
     * @param string $wp_plugin_path
     * @return boolean
     *
     */
    public function test_plugin_multivendor_active($wp_plugin_path)
    {
        $plugin_active = apply_filters(
            'marketpay_vendors_plugin_test',
            is_plugin_active($wp_plugin_path)
        );

        return $plugin_active;
    }

    /**
     * Part of the health-check display
     *
     * @param unknown $connection_test_result
     */
    public function display_status($connection_test_result)
    {
        $status      = $this->mp->getStatus($this->marketpayWCMain);
        $plugin_data = get_plugin_data(dirname(dirname(__FILE__)) . '/woocommerce-gateway-marketpay.php');

        /** Test for an activated multivendor plugin **/
        $wc_plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . marketpayWCConfig::WC_PLUGIN_PATH);
        $wp_plugin_path = apply_filters(
            'marketpay_vendors_plugin_path',
            marketpayWCConfig::WV_PLUGIN_PATH
        );
        $plugin_active = $this->test_plugin_multivendor_active($wp_plugin_path);

        if ($plugin_active)
        {
            $wv_plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $wp_plugin_path);
        }
        else
        {
            $wv_plugin_data = null;
        }

        $currency = null;
        
        if (function_exists('get_woocommerce_currency'))
        {
            $currency = get_woocommerce_currency();
        }

        $guest_checkout = get_option('woocommerce_enable_guest_checkout') == 'yes' ? true : false;
        if ('prod' == $this->options['prod_or_sandbox']) {
            $which_passphrase = 'prod_passphrase';
        } else {
            $which_passphrase = 'sand_passphrase';
        }
        ?>
        <ul class="mp_checklist">
            <li class="mp_checklist_item">
                <?php _e('Current environment:', 'marketpay');?>
                <span class="mp_checklist_status neutral">
                    <?php if ($status['environment']): ?>
                        <?php _e('Production', 'marketpay');?>
                    <?php else: ?>
                        <?php _e('Sandbox', 'marketpay');?>
                    <?php endif;?>
                </span>
            </li>
            <li class="mp_checklist_item">
                <?php _e('Client ID:', 'marketpay');?>
                <?php if ($status['client_id']): ?>
                    <span class="mp_checklist_status success">
                    <?php _e('Present!', 'marketpay');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Missing :(', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <?php _e('Passphrase:', 'marketpay');?>
                <?php if (isset($this->options[$which_passphrase]) && !empty($this->options[$which_passphrase])): ?>
                    <span class="mp_checklist_status success">
                    <?php _e('Present!', 'marketpay');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Missing :(', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <?php _e('Marketpay API Connection:', 'marketpay');?>
                <?php if ($status['loaded'] || $connection_test_result): ?>
                    <span class="mp_checklist_status success">
                    <?php _e('Success!', 'marketpay');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Failure :(', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <?php _e('Marketpay-WooCommerce plugin version:', 'marketpay');?>
                <?php if (isset($plugin_data['Version'])): ?>
                    <span class="mp_checklist_status success">
                    <?php echo $plugin_data['Version']; ?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Unknown', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <?php _e('Required WooCommerce plugin present &amp; activated:', 'marketpay');?>
                <?php if (is_plugin_active(marketpayWCConfig::WC_PLUGIN_PATH)): ?>
                    <span class="mp_checklist_status success">
                    <?php _e('Success!', 'marketpay');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Failure :(', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <?php _e('WooCommerce plugin version:', 'marketpay');?>
                <?php if ($wc_plugin_data && is_array($wc_plugin_data) && isset($wc_plugin_data['Version'])): ?>
                    <span class="mp_checklist_status success">
                    <?php echo $wc_plugin_data['Version']; ?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Unknown', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <a href="?page=wc-settings&tab=checkout&section=wc_gateway_marketpay">
                <?php _e('Marketpay enabled as a WooCommerce payment gateway:', 'marketpay');?>
                </a>
                <?php if ('yes' == $status['enabled']): ?>
                    <span class="mp_checklist_status success">
                    <?php _e('Enabled', 'woocommerce');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Disabled', 'woocommerce');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <a href="?page=wc-settings&tab=checkout&section=wc_gateway_marketpay">
                <?php _e('At least one card type or payment method is enabled:', 'marketpay');?>
                </a>
                <?php if ($status['card_enabled']): ?>
                    <span class="mp_checklist_status success">
                    <?php _e('Success!', 'marketpay');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Failure :(', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <?php if ($status['bankwire_enabled']): ?>
            <li class="mp_checklist_item">
                <a href="?page=wc-settings&tab=checkout&section=wc_gateway_marketpay">
                <?php _e('Bankwire Direct payment is enabled:', 'marketpay');?>
                </a>
                <span class="mp_checklist_status success">
                <?php _e('Enabled', 'woocommerce');?>
                </span>
            </li>
            <li class="mp_checklist_item">
                <a href="?page=wc-settings&tab=checkout&section=wc_gateway_marketpay">
                <?php _e('The webhook for Bankwire Direct is registered:', 'marketpay');?>
                </a>
                <?php if ($status['webhook_status']): ?>
                    <span class="mp_checklist_status success">
                    <?php _e('Success!', 'marketpay');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Failure :(', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <?php endif;?>
            <li class="mp_checklist_item">
                <a href="?page=wc-settings&tab=checkout">
                <?php _e('WooCommerce guest checkout should be disabled', 'marketpay');?>
                </a>
                <?php if (!$guest_checkout): ?>
                    <span class="mp_checklist_status success">
                    <?php _e('Disabled', 'woocommerce');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Enabled', 'woocommerce');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <a href="?page=wc-settings&tab=general">
                <?php _e('Current WooCommerce currency is supported by Marketpay:', 'marketpay');?>
                </a>
                <?php if (in_array($currency, $this->allowed_currencies)): ?>
                    <span class="mp_checklist_status success">
                    <?php echo $currency; ?>
                    <?php _e('Supported', 'marketpay');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php echo $currency; ?>
                    <?php _e('Unsupported', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <?php printf(
                    __('Required %1$s plugin present &amp; activated:', 'marketpay'),
                    apply_filters(
                        'marketpay_vendors_plugin_name',
                        'WC-Vendors'
                    )
                ); ?>

                <?php if ($plugin_active): ?>
                    <span class="mp_checklist_status success">
                    <?php _e('Success!', 'marketpay');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Failure :(', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <?php printf(
                    __('%1$s plugin version:', 'marketpay'),
                    apply_filters(
                        'marketpay_vendors_plugin_name',
                        'WC-Vendors'
                    )
                );?>
                <?php if ($wv_plugin_data && is_array($wv_plugin_data) && isset($wv_plugin_data['Version'])): ?>
                    <span class="mp_checklist_status success">
                    <?php echo $wv_plugin_data['Version']; ?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Unknown', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <?php _e('PHP mcrypt library available:', 'marketpay');?>
                <?php if (function_exists("mcrypt_encrypt")): ?>
                    <span class="mp_checklist_status success">
                    <?php _e('Success!', 'marketpay');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Unavailable. Your passphrase will be stored as clear text in the WordPress database.', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <?php _e('Keyfile directory is writable:', 'marketpay');?>
                <?php if (is_writable(dirname($this->mp->get_tmp_dir()))): ?>
                    <span class="mp_checklist_status success">
                    <?php _e('Success!', 'marketpay');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Failure :(', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <?php _e('Temporary directory is writable:', 'marketpay');?>
                <?php if (is_writable($this->mp->get_tmp_dir())): ?>
                    <span class="mp_checklist_status success">
                    <?php _e('Success!', 'marketpay');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Failure :(', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
            <li class="mp_checklist_item">
                <a href="users.php?role=vendor">
                <?php _e('All active vendors have a Marketpay account:', 'marketpay');?>
                </a>
                <?php if (!$this->vendors_without_account()): ?>
                    <span class="mp_checklist_status success">
                    <?php _e('Success!', 'marketpay');?>
                    </span>
                <?php else: ?>
                    <span class="mp_checklist_status failure">
                    <?php _e('Failure :(', 'marketpay');?>
                    </span>
                <?php endif;?>
            </li>
        </ul>
        <?php
    }

    /**
     * Checks if any active vendors don't have an MP user account
     * (and thus we cannot create a wallet)
     *
     * @return boolean
     */
    private function vendors_without_account()
    {
        $vendor_role = apply_filters('marketpay_vendor_role', 'vendor');

        if ($vendors = get_users(array('role' => $vendor_role, 'fields' => 'ID')))
        {
            /** We store a different mp_user_id for production and sandbox environments **/
            $umeta_key = 'mp_user_id';

            if ( ! $this->mp->is_production()) $umeta_key .= '_sandbox';

            foreach ($vendors as $vendor)
            {
                if ( ! $mp_user_id = get_user_meta($vendor, $umeta_key, true)) return true;
            }

            return false;
        }

        return false; // No vendors yet
    }

    /**
     * Displays an admin error notice
     * as long as the production client id and passphrase of the plugin have not been set-up
     *
     * @see: https://codex.wordpress.org/Plugin_API/Action_Reference/admin_notices
     *
     */
    public function admin_notices()
    {
        if ( ! empty($this->options['prod_or_sandbox']) && 'prod' == $this->options['prod_or_sandbox'])
        {
            $which_passphrase = 'prod_passphrase';
            $which_client_id  = 'prod_client_id';
        }
        else
        {
            $which_passphrase = 'sand_passphrase';
            $which_client_id  = 'sand_client_id';
        }

        if (
            empty($this->options['prod_or_sandbox']) ||
            empty($this->options[$which_passphrase]) ||
            empty($this->options[$which_client_id]) ||
            !class_exists('woocommerce') ||
            !class_exists(apply_filters('marketpay_vendors_required_class', 'WC_Vendors'))
        ) {
            $class = 'notice notice-error';

            $message = __('The Marketpay payment gateway needs to be configured.', 'marketpay') .
            ' <a href="admin.php?page=' . marketpayWCConfig::OPTION_KEY . '">' .
            __('Please click here', 'marketpay') .
                '</a>.';

            printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
        }

        /** Costly checks will only be performed on some specific admin pages **/
        $enabled_screens = array(
            'dashboard',
            'woocommerce_page_wc-settings',
            'toplevel_page_marketpay_settings',
            'edit-shop_order',
            'edit-product',
        );

        $screen = get_current_screen();

        if (in_array($screen->id, $enabled_screens))
        {
            if (get_option('woocommerce_enable_guest_checkout') == 'yes')
            {
                $class   = 'notice notice-error';
                $message = __('Marketpay warning', 'marketpay') . '<br/>';
                $message .= __('WooCommerce guest checkout should be disabled', 'marketpay');
            
                printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
            }

            $status = $this->mp->getStatus($this->marketpayWCMain);

            if ('yes' != $status['enabled'])
            {
                $class   = 'notice notice-error';
                $message = __('Marketpay warning', 'marketpay') . '<br/>';
                $message .= __('Marketpay is disabled', 'marketpay');

                printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
            }

            $currency = null;

            if (function_exists('get_woocommerce_currency'))
            {
                $currency = get_woocommerce_currency();
            }

            if (!in_array($currency, $this->allowed_currencies))
            {
                $class   = 'notice notice-error';
                $message = __('Marketpay warning', 'marketpay') . '<br/>';
                $message .= __('The current WooCommerce currency is unsupported by Marketpay', 'marketpay');

                printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
            }
        }
    }

    /**
     * Add our admin dashboard widget
     * for displaying failed payout transactions and refused KYC docs
     *
     */
    public function add_dashboard_widget()
    {
        /** Only show this widget to site administrators **/
        if ( ! current_user_can('manage_options')) return;

        wp_add_dashboard_widget(
            'mp_failed_db',
            __('Marketpay failed transactions', 'marketpay'),
            array($this, 'failed_transaction_widget'),
            $control_callback = null
        );

        /** Force our widget to the top **/
        global $wp_meta_boxes;
        $normal_dashboard  = $wp_meta_boxes['dashboard']['normal']['core'];
        $our_widget_backup = array('mp_failed_db' => $normal_dashboard['mp_failed_db']);
        unset($normal_dashboard['mp_failed_db']);
        $sorted_dashboard                             = array_merge($our_widget_backup, $normal_dashboard);
        $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
    }

    /**
     * Our admin dashboard widget
     * for displaying failed payout transactions and refused KYC docs
     *
     */
    public function failed_transaction_widget()
    {
        if ( ! current_user_can('manage_options')) return;

        $mp_failed = $this->mp->get_failed_payouts();

        $ignored_failed_po = get_option('mp_ignored_failed_po', array());

        if ( ! empty($mp_failed['failed_payouts']))
        {
            foreach ($mp_failed['failed_payouts'] as $key => $failed_payout)
            {
                if (in_array($failed_payout->ResourceId, $ignored_failed_po))
                {
                    unset($mp_failed['failed_payouts'][$key]);
                }
            }
        }

        echo '<h3>' . __('Failed payouts', 'marketpay') . '</h3>';

        if (empty($mp_failed['failed_payouts']))
        {
            echo '<p><em>' . __('No failed payout', 'marketpay') . '</em></p>';
        }
        else
        {
            echo '<ul>';

            foreach ($mp_failed['failed_payouts'] as $failed_payout)
            {
                if (!$payout_a = get_transient('mp_failed_po_' . $failed_payout->ResourceId))
                {
                    $payout = $this->mp->get_payout($failed_payout->ResourceId);

                    if ($payout && is_object($payout))
                    {
                        $due_ids = array();

                        if (preg_match('/WC Order #(\d+)/', $payout->Tag, $matches))
                        {
                            $order_id = $matches[1];

                            global $wpdb;
                            $table_name = $wpdb->prefix . marketpayWCConfig::WV_TABLE_NAME;
                            $query      = "SELECT id FROM `{$table_name}` WHERE order_id = %d;";
                            $query   = $wpdb->prepare($query, $order_id);
                            $due_ids = $wpdb->get_col($query);
                        }

                        $payout_a = array(
                            'payout'  => $payout,
                            'due_ids' => $due_ids,
                        );

                        set_transient(
                            'mp_failed_po_' . $failed_payout->ResourceId,
                            $payout_a,
                            60 * 60 * 24
                        );
                    }
                }

                $payout = $payout_a['payout'];

                echo '<li class="mp_failed_po_' . $failed_payout->ResourceId . '">';
                echo date_i18n(get_option('date_format'), $failed_payout->Date) . '<br/>';
                echo $failed_payout->EventType . ' ';

                $tag = preg_replace(
                    '/WC Order #(\d+)/',
                    "<a href=\"post.php?post=$1&action=edit\">$0</a>",
                    $payout->Tag
                );
                echo $tag . ' ';

                $retry_payout_url = 'admin.php?page=pv_admin_commissions';
                $retry_payout_url = wp_nonce_url($retry_payout_url);

                $retry_payout_url .= '&action=mp_payout';

                foreach ($payout_a['due_ids'] as $id)
                {
                    $retry_payout_url .= '&id[]=' . $id;
                }

                $retry_payout_url .= '&mp_initial_transaction=' . $failed_payout->ResourceId;

                echo '<a class="ignore_mp_failed_po" data-id="' . $failed_payout->ResourceId . '" href="#">[' . __('Ignore', 'marketpay') . ']</a> ';
                echo '<a class="retry_mp_failed_po" href="' . $retry_payout_url . '">[' . __('Retry', 'marketpay') . ']</a> ';

                echo '</li>';
            }

            echo '</ul>';
        }

        $ignored_refused_kyc = get_option('mp_ignored_refused_kyc', array());

        if ( ! empty($mp_failed['refused_kycs']))
        {
            foreach ($mp_failed['refused_kycs'] as $key => $refused_kyc)
            {
                if (in_array($refused_kyc->ResourceId, $ignored_refused_kyc))
                {
                    unset($mp_failed['refused_kycs'][$key]);
                }
            }
        }

        echo '<hr><h3>' . __('Refused KYC documents', 'marketpay') . '</h3>';

        if (empty($mp_failed['refused_kycs']))
        {
            echo '<p><em>' . __('No refused KYC document', 'marketpay') . '</em></p>';
        }
        else
        {
            echo '<ul>';

            foreach ($mp_failed['refused_kycs'] as $refused_kyc)
            {
                if ( ! $kyc_doc_a = get_transient('mp_refused_kyc_' . $refused_kyc->ResourceId))
                {
                    $kyc_doc = $this->mp->get_kyc($refused_kyc->ResourceId);

                    $umeta_key = 'mp_user_id';

                    if ( ! $this->mp->is_production()) $umeta_key .= '_sandbox';

                    $wp_user_id = 0;
                    $wp_users   = get_users(array(
                        'meta_key'   => $umeta_key,
                        'meta_value' => $kyc_doc->UserId,
                    ));

                    if ($wp_users && is_array($wp_users)) $wp_user = $wp_users[0];

                    if ($kyc_doc && is_object($kyc_doc))
                    {
                        $kyc_doc_a = array(
                            'kyc_doc' => $kyc_doc,
                            'wp_user' => $wp_user,
                        );

                        set_transient(
                            'mp_refused_kyc_' . $refused_kyc->ResourceId,
                            $kyc_doc_a,
                            60 * 60 * 24
                        );
                    }
                }

                $kyc_doc = $kyc_doc_a['kyc_doc'];

                echo '<li class="mp_refused_kyc_' . $refused_kyc->ResourceId . '">';

                echo date_i18n(get_option('date_format'), $refused_kyc->Date) . '<br/>';
                echo $refused_kyc->EventType . ' ';
                echo $kyc_doc->Type . ' ';
                echo $kyc_doc->Status . ', ';
                echo $kyc_doc->RefusedReasonType . ' ';

                if ($wp_user_id = $kyc_doc_a['wp_user'])
                {
                    echo __('For WP user:', 'marketpay') . ' ';
                    echo '<a href="user-edit.php?user_id=' . $kyc_doc_a['wp_user']->ID . '">';
                    echo $kyc_doc_a['wp_user']->user_login . ' ';
                    echo '(' . $kyc_doc_a['wp_user']->display_name . ')';
                    echo '</a> ';
                }
                else
                {
                    echo __('For MP user:', 'marketpay') . ' ';
                    echo $kyc_doc->UserId . ' ';
                }

                $upload_url = $this->mp->getDBUploadKYCUrl($kyc_doc->UserId);
                echo '<a class="ignore_mp_refused_kyc" data-id="' . $refused_kyc->ResourceId . '" href="#">[' . __('Ignore', 'marketpay') . ']</a> ';
                echo '<a class="retry_mp_refused_kyc" target="_mp_db" href="' . $upload_url . '">[' . __('Upload another document', 'marketpay') . ']</a> ';

                echo '</li>';
            }
            echo '</ul>';
        }
        ?>
        <script>
        (function($) {
            $(document).ready(function() {
                $('.ignore_mp_failed_po').on( 'click', function( e ){
                    e.preventDefault();
                    resource_id = this.dataset.id;
                    $.post( ajaxurl, {
                        action: 'ignore_mp_failed_po',
                        id: resource_id
                    }, function( data ) {
                        if ( true === data ) {
                            class_id = 'li.mp_failed_po_' + resource_id;
                            $(class_id).hide('slow');
                        }
                    });
                });

                $('.ignore_mp_refused_kyc').on( 'click', function( e ){
                    e.preventDefault();
                    resource_id = this.dataset.id;
                    $.post( ajaxurl, {
                        action: 'ignore_mp_refused_kyc',
                        id: resource_id
                    }, function( data ) {
                        if( true === data ) {
                            class_id = 'li.mp_refused_kyc_' + resource_id;
                            $(class_id).hide('slow');
                        }
                    });
                });
            });
        })( jQuery );
        </script>
        <?php
    }

    /**
     * Displayed on user-edit and user-new profile admin page
     * Adds custom fields required by MP
     * (birthday, nationality, country, user status and business type, where needed)
     * This is a WP action hook tied to:
     * - 'show_user_profile'
     * - 'edit_user_profile'
     * - 'user_new_form'
     * Must therefore be a public method
     *
     * @see: http://wordpress.stackexchange.com/questions/4028/how-to-add-custom-form-fields-to-the-user-profile-page
     */
    public function user_edit_required($user)
    {
        wp_enqueue_script('jquery-ui-datepicker');
        $this->marketpayWCMain->localize_datepicker();

        $screen = get_current_screen();
        if ($screen->id == 'user' && $screen->action == 'add') {
            /** We are in the WP admin User -> Add = wp-admin/user-new.php **/

            /** Necessary scripts and CSS for WC's nice country/state drop-downs **/
            $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
            wp_enqueue_script(
                'wc-users',
                WC()->plugin_url() . '/assets/js/admin/users' . $suffix . '.js',
                array('jquery', 'wc-enhanced-select'),
                WC_VERSION,
                true
            );
            wp_localize_script(
                'wc-users',
                'wc_users_params',
                array(
                    'countries'              => json_encode(array_merge(WC()->countries->get_allowed_country_states(), WC()->countries->get_shipping_country_states())),
                    'i18n_select_state_text' => esc_attr__('Select an option&hellip;', 'woocommerce'),
                )
            );
            wp_enqueue_style(
                'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css',
                array(),
                WC_VERSION
            );
            /** **/

            $user_birthday = '';
            if (!empty($_POST['user_birthday'])) {
                $user_birthday = $_POST['user_birthday'];
            }

            $user_nationality = '';
            if (!empty($_POST['user_nationality'])) {
                $user_nationality = $_POST['user_nationality'];
            }

            $billing_country = '';
            if (!empty($_POST['billing_country'])) {
                $billing_country = $_POST['billing_country'];
            }

            $user_mp_status = '';
            /** Apply default user status where needed **/
            if (
                isset($this->options['default_buyer_status']) &&
                'businesses' == $this->options['default_buyer_status'] &&
                isset($this->options['default_vendor_status']) &&
                'businesses' == $this->options['default_vendor_status']
            ) {
                $user_mp_status = 'business';
            }

            if (!empty($_POST['user_mp_status'])) {
                $user_mp_status = $_POST['user_mp_status'];
            }

            $user_business_type = '';
            if (!empty($_POST['user_business_type'])) {
                $user_business_type = $_POST['user_business_type'];
            }

        } else {
            /** We are editing an existing user in the WP admin **/

            $user_birthday = esc_attr(get_the_author_meta('user_birthday', $user->ID));
            $user_birthday = date_i18n($this->marketpayWCMain->supported_format(get_option('date_format')), strtotime($user_birthday));

            $user_nationality = get_the_author_meta('user_nationality', $user->ID);

            $user_mp_status = get_the_author_meta('user_mp_status', $user->ID);

            /** Fix for users that did not get a needed default status when created **/
            if (
                !$user_mp_status &&
                isset($this->options['default_buyer_status']) &&
                'businesses' == $this->options['default_buyer_status'] &&
                isset($this->options['default_vendor_status']) &&
                'businesses' == $this->options['default_vendor_status']
            ) {
                $user_mp_status = 'business';
            }

            $user_business_type = get_the_author_meta('user_business_type', $user->ID);
        }

        /**
         * For country drop-down
         * @see: https://wordpress.org/support/topic/woocommerce-country-registration-field-in-my-account-page-not-working
         *
         */
        $countries_obj = new WC_Countries();
        $countries     = $countries_obj->__get('countries');
        ?>
          <h3><?php _e('Extra profile information for Marketpay', 'marketpay');?></h3>
          <table class="form-table">
            <tr>
              <th><label for="user_birthday"><?php _e('Birthday', 'marketpay');?> <span class="description required"><?php _e('(required)', 'marketpay');?></span></label></th>
              <td>
                <input type="text" name="user_birthday" id="user_birthday" class="regular-text calendar"
                    value="<?php echo $user_birthday; ?>" /><br />
                <span class="description"></span>
            </td>
            </tr>
            <tr>
              <th><label for="user_nationality"><?php _e('Nationality', 'marketpay');?> <span class="description required"><?php _e('(required)', 'marketpay');?></span></label></th>
              <td>
                <select class="nationality_select" name="user_nationality" id="user_nationality">
                <option value=""><?php _e('Select a country...', 'marketpay');?></option>
                <?php foreach ($countries as $key => $value):
            $selected = ($key == $user_nationality ? 'selected="selected"' : '');
            ?>
                            <option value="<?php echo $key ?>" <?php echo $selected; ?>><?php echo $value ?></option>
                            <?php endforeach;?>
                </select>
              </td>
            </tr>

            <?php if ($screen->id == 'user' && $screen->action == 'add'):
            /**
             * Only on the create new user screen:
             * The billing_country field is already present when editing an existing user
             *
             **/
            ?>
                            <tr>
                                <th><label for="billing_country"><?php _e('Country', 'marketpay');?> <span class="description required"></span></label></th>
                                <td>
                                <select class="billing_country_select js_field-country" name="billing_country" id="billing_country">
                                <option value=""><?php _e('Select a country...', 'marketpay');?></option>
                                <?php foreach ($countries as $key => $value):
                $selected = ($key == $billing_country ? 'selected="selected"' : '');
                ?>
                                                <option value="<?php echo $key ?>" <?php echo $selected; ?>><?php echo $value ?></option>
                                            <?php endforeach;?>
                                </select>
                                </td>
                            </tr>
                            <tr class="billing_state_field">
                                <th><label for="billing_state"><?php _e('State/County', 'woocommerce');?> <span class="description required"></span></label></th>
                                <td>
                                <input type="hidden" class="billing_state_select js_field-state" name="billing_state" id="billing_state" />
                                </td>
                            </tr>
                        <?php endif;?>

            <?php /* we always add the form invisible javascript will determine if we show it */?>
            <tr id="block_tr_user_mp_status">
                <th>
                    <label for="user_mp_status">
                        <?php _e('User status', 'marketpay');?>
                        <span class="description required"></span>
                    </label>
                </th>
                <td>
                    <input type="hidden" id="actual_user_mp_status" value="<?php echo $user_mp_status; ?>" />
                    <input type="hidden" id="actual_default_buyer_status" value="<?php echo $this->options['default_buyer_status']; ?>" />
                    <input type="hidden" id="actual_default_vendor_status" value="<?php echo $this->options['default_vendor_status']; ?>" />
                <select class="mp_status_select" name="user_mp_status" id="user_mp_status" disabled>
                    <option value=""><?php _e('Select option...', 'marketpay');?></option>
                    <option value="individual" <?php selected($user_mp_status, 'individual');?>><?php _e('Individual', 'marketpay');?></option>
                    <option value="business" <?php selected($user_mp_status, 'business');?>><?php _e('Business user', 'marketpay');?></option>
                </select>
                <input type="hidden" name="user_mp_status" id="hidden_user_mp_status" value="<?php echo $user_mp_status; ?>" />
                </td>
            </tr>
            <tr class="hide_business_type" id="block_tr_user_business_type">
                <th><label for="user_business_type"><?php _e('Business type', 'marketpay');?> <span class="description required"></span></label></th>
                <td>
                <input type="hidden" id="actual_default_business_type" value="<?php echo $this->options['default_business_type']; ?>" />
                <select class="mp_btype_select" name="user_business_type" id="user_business_type" disabled>
                    <option value=""><?php _e('Select option...', 'marketpay');?></option>
                    <option value="organisation" <?php selected($user_business_type, 'organisation');?>><?php _e('Organisation', 'marketpay');?></option>
                    <option value="business" <?php selected($user_business_type, 'business');?>><?php _e('Business', 'marketpay');?></option>
                    <option value="soletrader" <?php selected($user_business_type, 'soletrader');?>><?php _e('Soletrader', 'marketpay');?></option>
                </select>
                <input type="hidden" name="user_business_type" id="hidden_user_business_type" value="<?php echo $user_business_type; ?>" />
                <?php
$business_edit = 0;
        if ($screen->id == 'user-edit' && $screen->action != 'add') {
            $business_edit = 1;
        }?>
                <input type="hidden" name="business_type_edit" id="business_type_edit" value="<?php echo $business_edit; ?>" />
                </td>
            </tr>

            <?php if ($screen->id != 'user' || $screen->action != 'add'):
            /** Not on the create new user screen **/
            ?>
                            <?php if ($this->marketpayWCMain->is_vendor($user->ID)): ?>
                                <?php if (false && $user_mp_status): ?>
                                    <tr>
                                        <th><?php _e('User status', 'marketpay');?></th>
                                        <td><?php echo __($user_mp_status, 'marketpay'); ?></td>
                                    </tr>
                                    <?php if ('business' == $user_mp_status && $user_business_type): ?>
                                        <tr>
                                            <th><?php _e('Business type', 'marketpay');?></th>
                                            <td><?php echo __($user_business_type, 'marketpay'); ?></td>
                                        </tr>
                                    <?php endif;?>
                    <?php endif;?>
                    <tr>
                        <th><?php _e('Bank account data', 'marketpay');?></th>
                        <td>
                        <?php $this->marketpayWCMain->bank_account_form($user->ID);?>
                        </td>
                    </tr>
                    <?php $this->marketpayWCMain->marketpay_wallet_table();?>
                <?php else: ?>
                    <?php if (false && $user_mp_status): ?>
                        <tr>
                            <th><?php _e('User status', 'marketpay');?></th>
                            <td><?php echo __($user_mp_status, 'marketpay'); ?></td>
                        </tr>
                        <?php if ('business' == $user_mp_status && $user_business_type): ?>
                            <tr>
                                <th><?php _e('Business type', 'marketpay');?></th>
                                <td><?php echo __($user_business_type, 'marketpay'); ?></td>
                            </tr>
                        <?php endif;?>
                    <?php endif;?>
                    <?php $this->marketpayWCMain->marketpay_wallet_table();?>
                <?php endif;?>
            <?php endif;?>

          </table>
          <script>
            (function($) {
                $(document).ready(function() {
                    $('label[for=first_name],label[for=last_name],label[for=billing_country]').append(' <span class="description required"><?php _e('(required)', 'marketpay');?></span>');
                    $('input.calendar').datepicker(datepickerL10n);

                    if( 'business'==$('#user_mp_status').val() )
                        $('.hide_business_type').show();
                });
                $('#user_mp_status').on('change',function(e){
                    if( 'business'==$('#user_mp_status').val() ) {
                        $('.hide_business_type').show();
                    } else {
                        $('.hide_business_type').hide();
                    }
                });
            })( jQuery );
          </script>
        <?php
    }

    public function user_edit_save($user_id)
    {
        $saved = false;

        if (current_user_can('edit_user', $user_id))
        {
            $birthday = $this->marketpayWCMain->convertDate(sanitize_text_field($_POST['user_birthday']));

            update_user_meta($user_id, 'user_birthday', $birthday);
            update_user_meta($user_id, 'user_nationality', sanitize_text_field($_POST['user_nationality']));

            if (isset($_POST['billing_country'])) {
                update_user_meta($user_id, 'billing_country', sanitize_text_field($_POST['billing_country']));
            }

            if (isset($_POST['billing_state'])) {
                update_user_meta($user_id, 'billing_state', sanitize_text_field($_POST['billing_state']));
            }

            if (isset($_POST['user_mp_status'])) {
                update_user_meta($user_id, 'user_mp_status', sanitize_text_field($_POST['user_mp_status']));
            }

            if (isset($_POST['user_business_type'])) {
                update_user_meta($user_id, 'user_business_type', sanitize_text_field($_POST['user_business_type']));
            }

            $saved = true;
        }

        /** Update bank account data if set && valid **/
        $errors = new WP_Error;
        $this->marketpayWCMain->validate_bank_account_data($errors, null, $user_id);
        $e = $errors->get_error_code();

        if (empty($e))
        {
            $this->marketpayWCMain->save_account_form($user_id);
        }

        return $saved;
    }

    /**
     * Enforce user profile required fields
     *
     * hooked on the 'user_profile_update_errors' action by hooks.inc.php
     *
     * @param object $errors    | WP Errors object
     * @param unknown $update
     * @param unknown $user
     */
    public function user_edit_checks(&$errors, $update, $user)
    {
        $data_post      = $_POST;
        $list_post_keys = array(
            'first_name'         => 'single',
            'last_name'          => 'single',
            'user_birthday'      => 'date',
            'user_nationality'   => 'country',
            'billing_country'    => 'country',
            'user_mp_status'     => 'status',
            'user_business_type' => 'businesstype',
        );

        foreach ($list_post_keys as $key => $value)
        {
            $function_name = 'validate_' . $value;
            $data_to_send  = array(
                'data_post'    => $data_post,
                'key_field'    => $key,
                'wp_error'     => &$errors,
                'main_options' => $this->options,
                'double_test'  => array('user_birthday' => 1),
                'caller_func'  => 'user_edit_checks',
            );

            $this->marketpayWCValidation->$function_name($data_to_send);
        }

        if (is_wp_error($errors) && !$errors->get_error_code() && isset($user->ID))
        {
            $this->marketpayWCMain->on_shop_settings_saved($user->ID);
        }

        /** Bank account data **/
        if (isset($_POST['vendor_account_type']) && $_POST['vendor_account_type']) {
            $this->marketpayWCMain->validate_bank_account_data($errors, $update, $user);
        }

    }

    /**
     * Add our custom column to the user list admin screen
     * to show if they have an MP account for this environment
     *
     */
    public function manage_users_columns($columns)
    {
        $columns['mp_account'] = __('Marketpay Account', 'marketpay');
        return $columns;
    }

    /**
     * Make our custom column sortable
     *
     * @param array $columns
     * @return array
     *
     */
    public function manage_sortable_users_columns($columns)
    {
        $columns['mp_account'] = 'has_mp_account';
        return $columns;
    }

    /**
     * Content of our custom column
     *
     * @param string $value
     * @param string $column_name
     * @param int $wp_user_id
     * @return string
     *
     */
    public function users_custom_column($value, $column_name, $wp_user_id)
    {
        if ('mp_account' != $column_name) {
            return $value;
        }

        /** We store a different mp_user_id for production and sandbox environments **/
        $umeta_key = 'mp_user_id';
        if (!$this->mp->is_production()) {
            $umeta_key .= '_sandbox';
        }

        if ($mp_user_id = get_user_meta($wp_user_id, $umeta_key, true)) {
            return __('Yes', 'marketpay');
        } else {
            return __('No', 'marketpay');
        }
    }

    /**
     * Manage the sorting of our custom column
     *
     * @param object $query
     * @return object $query
     *
     */
    public function user_column_orderby($query)
    {
        if ('WP_User_Query' != get_class($query)) {
            return $query;
        }

        $vars = $query->query_vars;

        if (!isset($vars['orderby']) || 'has_mp_account' != $vars['orderby']) {
            return $query;
        }

        /** We store a different mp_user_id for production and sandbox environments **/
        $umeta_key = 'mp_user_id';
        if (!$this->mp->is_production()) {
            $umeta_key .= '_sandbox';
        }

        global $wpdb;
        $query->query_from .= " LEFT JOIN $wpdb->usermeta m ON ($wpdb->users.ID = m.user_id  AND m.meta_key = '$umeta_key')";
        $query->query_orderby = "ORDER BY m.meta_value " . $vars['order'];

        return $query;
    }

    /**
     * Display custom info on the order admin screen (DEBUG mode only)
     * (this part adds the meta box)
     * hooks $this->metabox_order_data()
     *
     */
    public function add_meta_boxes()
    {
        if ( ! marketpayWCConfig::DEBUG) {
            return;
        }

        foreach (wc_get_order_types('order-meta-boxes') as $type)
        {
            $order_type_object = get_post_type_object($type);
            add_meta_box(
                'woocommerce-order-mpdata',
                sprintf(__('%s Marketpay Data', 'marketpay'), $order_type_object->labels->singular_name),
                array($this, 'metabox_order_data'),
                $type,
                'normal',
                'high'
            );
        }
    }

    /**
     * Display custom info on the order admin screen
     * (this part does the display)
     * hooked by $this->add_meta_boxes()
     *
     */
    public function metabox_order_data($post)
    {
        $order = new WC_Order($post->ID);
        if (class_exists('WCV_Vendors')) {
            $dues = WCV_Vendors::get_vendor_dues_from_order($order, false);
            echo '<h3>WCV_Vendors::get_vendor_dues_from_order</h3><pre>';
            var_dump($dues);
            echo '</pre>';
            echo '<h3>marketpay_payment_type post_meta</h3><pre>';
            var_dump(get_post_meta($post->ID, 'marketpay_payment_type', true));
            echo '</pre>';
            echo '<h3>marketpay_payment_ref post_meta</h3><pre>';
            var_dump(get_post_meta($post->ID, 'marketpay_payment_ref', true));
            echo '</pre>';
        }
    }

    /**
     * Adds a new bulk action to the WV back-office Commissions screen
     * To make MP payments of commissions
     *
     * @param array $actions
     *
     **/
    public function addBulkActionInFooter()
    {
        ?>
        <script>
        (function($) {
            $(document).ready(function() {
                $('<option>').val('mp_payout').text('<?php _e('Marketpay Payout', 'marketpay');?>').appendTo("select[name='action']");
                $('<option>').val('mp_payout').text('<?php _e('Marketpay Payout', 'marketpay');?>').appendTo("select[name='action2']");
            });
        })( jQuery );
        </script>
        <?php
    }

    /**
     * Custom bulk action on the WV vendor commission admin screen
     * This will perform MP payouts to vendors if the vendor has an active
     * MP bank account registered. Otherwise an error will be displayed.
     * Due commissions will be applied.
     *
     */
    public function vendor_payouts()
    {
        $wp_list_table = _get_list_table('WP_Posts_List_Table');
        $action        = $wp_list_table->current_action();

        if ('mp_payout' != $action) {
            return;
        }

        if (!isset($_REQUEST['id']) || !$_REQUEST['id'] || !is_array($_REQUEST['id'])) {
            return;
        }

        /** Failed payouts can only be retried once **/
        if (!empty($_REQUEST['mp_initial_transaction'])) {
            $ressource_id         = $_REQUEST['mp_initial_transaction'];
            $mp_ignored_failed_po = get_option('mp_ignored_failed_po', array());
            if (in_array($ressource_id, $mp_ignored_failed_po)) {
                echo '<div class="error">';
                echo '<p>' . __('-Error: this commission payout has already been retried:', 'marketpay') . ' ' .
                    '#' . $ressource_id . '.</p>';
                echo '</div>';
                return;
            }
        }

        echo '<div class="updated">';
        echo '<p>' . __('Paying selected vendors...', 'marketpay') . '</p>';
        echo '</div>';

        $commission_ids = $_REQUEST['id'];
        foreach ($commission_ids as $pv_commission_id)
        {
            /**
             * The bulk action id parameter refers to an entry of WV's
             * custom pv_commission table.
             * We must query this table to get order and vendor info
             * @see /plugins/wc-vendors/classes/class-commission.php
             *
             */
            global $wpdb;
            $table_name = $wpdb->prefix . marketpayWCConfig::WV_TABLE_NAME;
            $query      = "
            SELECT product_id, order_id, vendor_id, status, total_due
            FROM `{$table_name}`
            WHERE id = %d;
            ";
            $query = $wpdb->prepare($query, $pv_commission_id);
            if ($row = $wpdb->get_row($query)) {
                $wp_user_id = $row->vendor_id;
            } else {
                echo '<div class="error">';
                echo '<p>' . __('-Error: bad wc-vendors commission ID:', 'marketpay') . ' ' .
                    '#' . $pv_commission_id . '.</p>';
                echo '</div>';
                continue;
            }

            $vendor_info  = get_userdata($wp_user_id);
            $pv_shop_name = get_user_meta($wp_user_id, 'pv_shop_name', true);
            if (!$pv_shop_name) {
                $pv_shop_name = $vendor_info->display_name;
            }

            $admin_link = 'user-edit.php?user_id=' . $wp_user_id;

            if (
                'due' != $row->status &&
                empty($_REQUEST['mp_initial_transaction'])
            ) {
                //TODO: translation string to convert as sprintf %s...
                echo '<div class="updated">';
                echo '<p>' . __('-Commission of', 'marketpay') . ' ' . $pv_shop_name . ' ' .
                __('on order', 'marketpay') . ' ' . $row->order_id . ' ' .
                __('is already marked as', 'marketpay') . ' ' . $row->status . '. ' .
                __('Skipping.', 'marketpay') . '</p>';
                echo '</div>';
                continue;
            }

            /** We store a different mp_account_id for production and sandbox environments **/
            $umeta_key = 'mp_account_id';
            if (!$this->mp->is_production()) {
                $umeta_key .= '_sandbox';
            }

            if (!$mp_account_id = get_user_meta($wp_user_id, $umeta_key, true)) {
                //TODO: translation string to convert as sprintf %s...
                echo '<div class="error">';
                echo '<p>' . __('-Warning: vendor', 'marketpay') . ' ' .
                '<a href="' . $admin_link . '">&laquo;' . $pv_shop_name . '&raquo;</a> ' .
                '(#' . $wp_user_id . ') ' .
                __('does not have a Marketpay bank account', 'marketpay') . '</p>';
                echo '</div>';

            } else {

                /**
                 * Initiate MP payout transaction
                 * @see: https://github.com/Marketpay/marketpay2-php-sdk/blob/master/demos/workflow/scripts/payout.php
                 *
                 */
                $order_id  = $row->order_id;
                $currency  = get_woocommerce_currency();
                $total_due = $row->total_due;
                $fees      = 0;
                $result    = $this->mp->payout($wp_user_id, $mp_account_id, $order_id, $currency, $total_due, $fees);

                if (
                    isset($result->Status) &&
                    ('SUCCEEDED' == $result->Status || 'CREATED' == $result->Status)
                ) {
                    //TODO: translation string to convert as sprintf %s...
                    $this->marketpayWCMain->set_commission_paid($pv_commission_id);
                    echo '<div class="updated">';
                    echo '<p>' . __('-Success: commission paid to vendor', 'marketpay') . ' ' .
                        '<a href="' . $admin_link . '">&laquo;' . $pv_shop_name . '&raquo;</a> ' .
                        '</p>';
                    echo '</div>';

                } else {
                    //TODO: translation string to convert as sprintf %s...
                    echo '<div class="error">';
                    echo '<p>' . __('-Error: vendor', 'marketpay') . ' ' .
                    '<a href="' . $admin_link . '">&laquo;' . $pv_shop_name . '&raquo;</a> ' .
                    '(#' . $wp_user_id . ') ' .
                    __('Marketpay payout transaction failed', 'marketpay') . '</p>';
                    if ($result->ResultMessage) {
                        echo '<p>' . $result->ResultMessage . '</p>';
                    }

                    echo '</div>';

                } //endif

                /**
                 * If this is a failed payout retry from the dashboard widget,
                 * hide the original transaction
                 *
                 */
                if (!empty($_REQUEST['mp_initial_transaction'])) {
                    $ressource_id         = $_REQUEST['mp_initial_transaction'];
                    $mp_ignored_failed_po = get_option('mp_ignored_failed_po', array());
                    if ($ressource_id && !in_array($ressource_id, $mp_ignored_failed_po)) {
                        $mp_ignored_failed_po[] = $ressource_id;
                        update_option('mp_ignored_failed_po', $mp_ignored_failed_po);
                    }
                }
            } //endif

        } //endforeach

    } //end function

    /**
     * If the bankwire payment method is enabled,
     * this will check that a webhook callback is registered with the MP API
     *
     */
    public function register_all_webhooks()
    {
        return true;

        if (
            !isset($_POST['woocommerce_marketpay_enabled_BANK_WIRE']) ||
            !1 == $_POST['woocommerce_marketpay_enabled_BANK_WIRE']
        ) {
            return;
        }

        if (!isset($this->options['webhook_key']) || !$this->options['webhook_key']) {
            $this->generate_webhook_key();
        }

        $success       = true;
        $error_notices = array();

        /** Check the PAYIN_NORMAL_SUCCEEDED hook **/
        $success1 = $this->register_webhook(mpAccess::PAYIN_SUCCESS_HK);

        /** Check the PAYIN_NORMAL_FAILED hook **/
        $success2 = $this->register_webhook(mpAccess::PAYIN_FAILED_HK);

        if ($success1 && $success2) {
            echo '<div class="updated"><p>' .
            __('The webhooks for Bankwire Direct payment are properly setup.', 'marketpay') .
                '</p></div>';

        } else {
            if ($error_notices) {
                foreach ($error_notices as $notice) {
                    echo $notice;
                }
            }

            echo '<div class="notice notice-error"><p>' .
            __('Marketpay Error: invalid webhook setup for Bankwire Direct', 'marketpay') .
                '</p></div>';
        }

        return $success;
    }

    /**
     * Register a webhook callback of the specified type with the MP API
     *
     * @param string $event_type
     */
    private function register_webhook($event_type)
    {
        $success = true;

        if ($hook = $this->mp->get_webhook_by_type($event_type)) {

            if (!$this->mp->hook_is_valid($hook)) {
                $error_notices[] = '<div class="notice notice-error"><p>' .
                sprintf(
                    __('Error: the Marketpay %1$s webhook is DISABLED or INVALID - please update it via %2$s', 'marketpay'),
                    $event_type,
                    '<a href="' . $this->mp->getDBWebhooksUrl() . '" target="_out">' .
                    __('the Dashboard', 'marketpay') .
                    '</a>'
                ) .
                    '</p></div>';

                $success = $this->mp->update_webhook(
                    $hook,
                    marketpayWCWebHooks::WEBHOOK_PREFIX,
                    $this->options['webhook_key'],
                    $event_type
                );
            }

            if ($success) {
                $inboundPayinWPUrl = site_url(
                    marketpayWCWebHooks::WEBHOOK_PREFIX . '/' .
                    $this->options['webhook_key'] . '/' .
                    $event_type
                );
                if ($hook->Url != $inboundPayinWPUrl) {
                    // $inboundPayinWPUrl being the URL does not match the URL that it should be for this WP setup
                    $error_notices[] = '<div class="notice notice-error"><p>' .
                    sprintf(
                        __('Error: the URL of the Marketpay %1$s webhook is not correct and should be %2$s - please update it via %3$s', 'marketpay'),
                        $event_type,
                        '<a href="' . $inboundPayinWPUrl . '">' . $inboundPayinWPUrl . '</a>',
                        '<a href="' . $this->mp->getDBWebhooksUrl() . '" target="_out">' .
                        __('the Dashboard', 'marketpay') .
                        '</a>'
                    ) .
                        '</p></div>';

                    $success = $this->mp->update_webhook(
                        $hook,
                        marketpayWCWebHooks::WEBHOOK_PREFIX,
                        $this->options['webhook_key'],
                        $event_type
                    );
                }
            }

        } else {
            $success = $this->mp->create_webhook(
                marketpayWCWebHooks::WEBHOOK_PREFIX,
                $this->options['webhook_key'],
                $event_type
            );
        }

        return $success;
    }

    /**
     * Generate a unique webhook endpoint that will be used for this site
     * This prevents outside persons to try and send webhooks to our site
     * without knowing that somewhat secret and unique key
     *
     */
    private function generate_webhook_key()
    {
        $this->options['webhook_key']                  = md5(time());
        $this->marketpayWCMain->options['webhook_key'] = $this->options['webhook_key'];
        update_option(marketpayWCConfig::OPTION_KEY, $this->options);
    }
}
?>