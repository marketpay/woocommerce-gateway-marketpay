<?php
/** Can't be called outside WP **/
if (!defined('ABSPATH')) {
    exit;
}

/**
 * WooCommerce Payment Gateway class for Marketpay
 *
 * @author ferran@lemonpay.me
 * @see: https://github.com/marketpay/woocommerce-gateway-marketpay
 *
 */
class WC_Gateway_Marketpay extends WC_Payment_Gateway
{
    public static $log_enabled = false;

    public static $log = false;

    private $supported_locales = array(
        'es',
    );

    private $allowed_currencies = array(
        'EUR',
        'GBP'
    );

    private $available_card_types = array(
        'REDSYS' => 'Pay with Credit Card',
        'BANK_WIRE' => 'Pay with Bank Wire'
    );

    private $default_card_types = array(
        'REDSYS',
        'BANK_WIRE'
    );

    /**
     * Class constructor (required)
     *
     */
    public function __construct()
    {
        $this->wcGatewayInit();
        $this->init_form_fields();
        $this->init_settings();

        /** Admin hooks **/
        if ( ! is_admin()) return;

        /** Inherited class hook, mandatory **/
        add_action(
            'woocommerce_update_options_payment_gateways_' . $this->id,
            array($this, 'process_admin_options')
        );
    }

    /**
     * Register the WC Payment gateway
     *
     * @param array $methods
     * @return array $methods
     *
     */
    public static function add_gateway_class($methods)
    {
        $methods[] = 'WC_Gateway_Marketpay';

        return $methods;
    }

    /**
     * Performs all initialization for a standard WooCommerce payment gateway
     *
     */
    private function wcGatewayInit()
    {
        $form_fields = array();

        $form_fields['enabled'] = array(
            'title'   => __('Enable/Disable', 'marketpay'),
            'type'    => 'checkbox',
            'label'   => __('Enable Marketpay Payment', 'marketpay'),
            'default' => 'yes',
        );

        /** Fields to choose available credit card types **/
        $first = true;

        foreach ($this->available_card_types as $type => $label)
        {
            $default = 'no';

            if ('RedsysPayByWebPost' == $type)
            {
                $default = 'yes';
            }

            $star = '<span class="note star" title="' . __('Needs activation', 'marketpay') . '">*</span>';

            if (in_array($type, $this->default_card_types))
            {
                $star = '';
            }

            $title = $first ? __('Choose available credit card types:', 'marketpay') : '';

            if ('BANK_WIRE' == $type)
            {
                $title = __('Choose available direct payment types:', 'marketpay');
            }

            $form_fields['enabled_' . $type] = array(
                'title'   => $title,
                'type'    => 'checkbox',
                'label'   => sprintf(__('Enable %s payment', 'marketpay'), __($label, 'marketpay')) . $star,
                'default' => $default,
                'class'   => 'mp_payment_method',
            );

            $first = false;
        }

        $args = array(
            'sort_column' => 'menu_order',
            'sort_order'  => 'ASC',
        );

        $options = array(null => ' ');
        $pages   = get_pages($args);

        foreach ($pages as $page)
        {
            $prefix             = str_repeat('&nbsp;', count(get_post_ancestors($page)) * 3);
            $options[$page->ID] = $prefix . $page->post_title;
        }

        $form_fields['custom_template_page_id'] = array(
            'title'             => __('Use this page for payment template', 'marketpay'),
            'description'       => __('The page needs to be secured with https', 'marketpay'),
            'id'                => 'custom_template_page_id',
            'type'              => 'select',
            'label'             => __('Use this page for payment template', 'marketpay'),
            'default'           => '',
            'class'             => 'wc-enhanced-select-nostd',
            'css'               => 'min-width:300px;',
            'desc_tip'          => __('Page contents:', 'woocommerce') . ' [' . apply_filters('marketpay_payform_shortcode_tag', 'marketpay_payform') . ']',
            'placeholder'       => __('Select a page&hellip;', 'woocommerce'),
            'options'           => $options,
            'custom_attributes' => array(
                'placeholder' => __('Select a page&hellip;', 'woocommerce')
            ),
        );

        $this->id                 = 'marketpay';
        $this->icon               = '';
        $this->has_fields         = true;
        $this->method_title       = __('Marketpay', 'marketpay');
        $this->method_description = __('We enable escrow payments in the sharing economy', 'marketpay');
        $this->title              = __('Default payment methods', 'marketpay');
        $this->form_fields        = $form_fields;
        $this->supports           = array('refunds');
    }

    /**
     * Payform health-check
     *
     */
    public function validate_custom_template_page_id_field($key)
    {
        // get the posted value
        $value = $_POST[$this->plugin_id . $this->id . '_' . $key];

        if ( ! $value) return $value;

        if ($page = get_post($value))
        {
            if ( ! preg_match('/[marketpay_payform]/', $page->post_content))
            {
                /** Add the shortcode **/
                $page->post_content = $page->post_content . '[marketpay_payform]';

                wp_update_post($page);
            }
        }

        return $value;
    }

    /**
     * Error notice display function
     *
     */
    private function error_notice_display($msg)
    {
        $class   = 'notice notice-error';
        $message = __($msg, 'marketpay');

        printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
    }

    /**
     * Logging method.
     * @param string $message
     */
    public static function log($message)
    {
        if (self::$log_enabled)
        {
            if (empty(self::$log))
            {
                self::$log = new WC_Logger();
            }

            self::$log->add('marketpay', $message);
        }
    }

    /**
     * Check if the gateway is available for use
     *
     * @return bool
     */
    public function is_available()
    {
        $is_available = ('yes' === $this->enabled) ? true : false;

        /** This payment method can't be used for unsupported curencies **/
        $currency = get_woocommerce_currency();

        if ( ! in_array($currency, $this->allowed_currencies))
        {
            $is_available = false;
        }

        /** This payment method can't be used if a Vendor does not have a MP account **/
        if ($items = WC()->cart->cart_contents)
        {
            foreach ($items as $item)
            {
                $item_object = $item['data'];
                $vendor_id   = get_post($item_object->get_id())->post_author;

                /** We store a different mp_user_id for production and sandbox environments **/
                $umeta_key = 'mp_user_id';

                if ( ! mpAccess::getInstance()->is_production()) $umeta_key .= '_sandbox';

                if ( ! get_user_meta($vendor_id, $umeta_key, true))
                {
                    $is_available = false;
                }
            }
        }

        return $is_available;
    }

    /**
     * Injects some jQuery to improve credit card selection admin
     *
     */
    public function admin_options()
    {
        parent::admin_options(); ?>

        <script>
            (function($) {
                $(document).ready(function() {
                    if ($('#woocommerce_marketpay_enabled').is(':checked')) {
                        //enable checkboxes
                        checkboxSwitch( true );
                    } else {
                        //disable checkboxes
                        checkboxSwitch( false );
                    }

                    $('#woocommerce_marketpay_enabled').on('change', function(e) {
                        checkboxSwitch($(this).is(':checked'));
                    });

                    $('.mp_payment_method.readonly').live('click', function(e) {
                        e.preventDefault();
                        //console.log('clicked');
                    });
                });

                function checkboxSwitch( current ) {
                    if (current) {
                        $('.mp_payment_method').removeAttr('readonly').removeClass('readonly');
                    } else {
                        $('.mp_payment_method').attr('readonly', true).addClass('readonly');
                    }
                }
            })( jQuery );
        </script>
        <?php
    }

    /**
     * Display our payment-related fields
     *
     */
    public function payment_fields()
    {
        if ( ! empty($_POST['mp_card_type']))
        {
            $selected = $_POST['mp_card_type'];
        }
        elseif ( ! empty($_POST['post_data']))
        {
            parse_str($_POST['post_data'], $post_data);

            if ( ! empty($post_data['mp_card_type']))
            {
                $selected = $post_data['mp_card_type'];
            }
        }
        else
        {
            $selected = '';
        } ?>

        <div class="mp_payment_fields">
            <?php if ('yes' == $this->get_option('enabled_BANK_WIRE')): ?>
                <div class="mp_pay_method_wrap">
                    <div class="mp_card_dropdown_wrap">
                        <input type="radio" name="mp_payment_type" class="mp_payment_type card" value="card" checked="checked" />
                        <label for="mp_payment_type"><?php _e('Online payment', 'marketpay');?>&nbsp;</label>
            <?php endif;?>

            <?php if (count($this->available_card_types) > 1): ?>
                <select name="mp_card_type" id="mp_card_type">
                    <?php foreach ($this->available_card_types as $type => $label): ?>
                        <?php if ('yes' == $this->get_option('enabled_' . $type)): ?>
                            <?php if ('BANK_WIRE' == $type) continue; ?>
                            <option value="<?php echo $type; ?>" <?php selected($type, $selected);?>>
                                <?php _e($label, 'marketpay');?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach;?>
                </select>
            <?php else: ?>
                <input type="hidden" name="mp_card_type" value="<?php echo array_keys($this->available_card_types)[0]; ?>">
            <?php endif; ?>

            <?php if ('yes' == $this->get_option('enabled_BANK_WIRE')): ?>
                    </div>
                    <div class="mp_spacer">&nbsp;</div>
                    <div class="mp_direct_dropdown_wrap">
                        <input type="radio" name="mp_payment_type" value="bank_wire" />
                        <label for="mp_payment_type"><?php _e('Use a direct bank wire', 'marketpay');?></label>
                    </div>
                </div>
            <?php endif;?>

            <script>
                (function($) {
                    $(document).ready(function() {
                        $('#mp_card_type').on('change click', function( e ){
                            $('.mp_payment_type.card').attr('checked','checked');
                        });
                    });
                })( jQuery );
            </script>
        </div>
        <?php
    }

    /**
     * Redirects to MP card payment form
     *
     * @param int $order_id
     * @return array status
     */
    public function process_payment($order_id)
    {
        if (isset($_POST['mp_card_type']) && $_POST['mp_card_type'])
        {
            $mp_card_type = $_POST['mp_card_type'];
        }
        else
        {
            $mp_card_type = 'REDSYS';
        }

        if ('BANK_WIRE' == $mp_card_type || (isset($_POST['mp_payment_type']) && 'bank_wire' == $_POST['mp_payment_type']))
        {
            return $this->process_bank_wire($order_id);
        }

        $order = wc_get_order($order_id);

        if ( ! $wp_user_id = get_current_user_id())
        {
            $wp_user_id = WC_Session_Handler::generate_customer_id();
        }

        $return_url = $this->get_return_url($order);

        $locale                            = 'EN';
        list($locale_minor, $locale_major) = preg_split('/_/', get_locale());

        if (in_array($locale_minor, $this->supported_locales))
        {
            $locale = strtoupper($locale_minor);
        }

        $mp_template_url = false;

        if ($custom_template_page_id = $this->get_option('custom_template_page_id')) 
        {
            if ($url = get_permalink($custom_template_page_id)) $mp_template_url = $url;
        }

        $return = mpAccess::getInstance()->card_payin_url(
            $order_id, // Used to fill-in the "Tag" optional info
            $wp_user_id, // WP User ID
            ($order->get_total() * 100), // Amount
            $order->get_currency(), // Currency
            0, // Fees
            $return_url, // Return URL
            $locale, // For "Culture" attribute
            $mp_card_type, // CardType
            $mp_template_url // Optional template URL
        );

        if (false === $return)
        {
            $error_message = __('Could not create the Marketpay payment URL', 'marketpay');

            wc_add_notice(__('Payment error:', 'marketpay') . ' ' . $error_message, 'error');

            return;
        }

        $transaction_id = $return['transaction_id'];

        update_post_meta($order_id, 'marketpay_payment_type', 'card');
        update_post_meta($order_id, 'marketpay_payment_ref', $return);
        update_post_meta($order_id, 'mp_transaction_id', $transaction_id);

        /** update the history of transaction ids for this order **/
        if (($transaction_ids = get_post_meta($order_id, 'mp_transaction_ids', true)) && is_array($transaction_ids))
        {
            $transaction_ids[] = $transaction_id;
        }
        else
        {
            $transaction_ids = array($transaction_id);
        }

        update_post_meta($order_id, 'mp_transaction_ids', $transaction_ids);

        return array(
            'result'   => 'success',
            'redirect' => $return['redirect_url'],
        );
    }

    /**
     * Process Direct Bank Wire payment types
     *
     */
    private function process_bank_wire($order_id)
    {
        $order = wc_get_order($order_id);

        if ( ! $wp_user_id = get_current_user_id())
        {
            $wp_user_id = WC_Session_Handler::generate_customer_id();
        }

        $return_url = $this->get_return_url($order);

        $ref = mpAccess::getInstance()->bankwire_payin_ref(
            $order_id, // Used to fill-in the "Tag" optional info
            $wp_user_id, // WP User ID
            ($order->get_total() * 100), // Amount
            $order->get_currency(), // Currency
            0 // Fees
        );

        if ( ! $ref)
        {
            $error_message = __('Marketpay Bankwire Direct payin failed', 'marketpay');

            wc_add_notice(__('Payment error:', 'marketpay') . ' ' . $error_message, 'error');

            return;
        }

        $transaction_id = $ref->getId();

        update_post_meta($order_id, 'marketpay_payment_type', 'bank_wire');
        update_post_meta($order_id, 'marketpay_payment_ref', $ref);
        update_post_meta($order_id, 'mp_transaction_id', $transaction_id);

        /** update the history of transaction ids for this order **/
        if (($transaction_ids = get_post_meta($order_id, 'mp_transaction_ids', true)) && is_array($transaction_ids))
        {
            $transaction_ids[] = $transaction_id;
        }
        else
        {
            $transaction_ids = array($transaction_id);
        }

        update_post_meta($order_id, 'mp_transaction_ids', $transaction_ids);

        return array(
            'result'   => 'success',
            'redirect' => $return_url,
        );
    }

    /**
     * Process refund.
     *
     * If the gateway declares 'refunds' support, this will allow it to refund.
     * a passed in amount.
     *
     * @param  int $order_id
     * @param  float $amount
     * @param  string $reason
     * @return bool|WP_Error True or false based on success, or a WP_Error object.
     */
    public function process_refund($order_id, $amount = null, $reason = '')
    {
        if ( ! $mp_transaction_id = get_post_meta($order_id, 'mp_transaction_id', true))
        {
            $this->log('Refund Failed: No MP transaction ID');

            return new WP_Error('error', __('Refund Failed: No transaction ID', 'woocommerce'));
        }

        /** If there is a recorded successful transaction id, take it instead **/
        if ($mp_success_transaction_id = get_post_meta($order_id, 'mp_success_transaction_id', true))
        {
            $mp_transaction_id = $mp_success_transaction_id;
        }

        $order      = new WC_Order($order_id);
        $wp_user_id = $order->customer_user;

        $result = mpAccess::getInstance()->card_refund(
            $order_id, // Order_id
            $mp_transaction_id, // transaction_id
            $wp_user_id, // wp_user_id
            ($amount * 100), // Amount
            $order->order_currency, // Currency
            $reason // Reason
        );

        if ($result && 'SUCCEEDED' == $result->Status)
        {
            $this->log('Refund Result: ' . print_r($result, true));

            $order->add_order_note(sprintf(
                __('Refunded %s - Refund ID: %s', 'woocommerce'),
                ($result->CreditedFunds->Amount / 100),
                $result->Id
            ));

            return true;
        }
        else
        {
            $this->log('Refund Failed: ' . $result->ResultCode . ' - ' . $result->ResultMessage);

            return new WP_Error('error', sprintf(
                __('Refund failed: %s - %s', 'marketpay'),
                $result->ResultCode,
                $result->ResultMessage
            ));
        }
    }
}
?>