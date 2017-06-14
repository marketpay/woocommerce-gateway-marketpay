<?php
/**
 * Incoming webhooks handling methods for Marketpay WooCommerce Plugin
 *
 */
class marketpayWCWebHooks
{

    const WEBHOOK_PREFIX = 'marketpay_webhooks';
    const LOGGING        = false; // This should be set to FALSE on production servers for security reasons
    const WARN_VENDORS   = false; // Shoud be set to FALSE: vendors usually can't do anything about failed payins

    /** Generic plugin variables **/
    private $marketpayWCMain; // The marketpayWCMain object that instanciated us
    private $mp; // This will store our mpAccess class instance
    private $logFilePath = ''; // This will store the path to our log file

    /** Webhook object properties **/
    private $event_type;
    private $payload;
    private $headers;

    /**
     * Class constructor
     *
     */
    public function __construct($marketpayWCMain = null)
    {
        $this->marketpayWCMain = $marketpayWCMain;
        $this->mp              = mpAccess::getInstance();
        $this->logFilePath     = $this->mp->get_logfilepath();

        /** Create our own URL endpoints for processing incoming Marketpay webhooks **/
        add_filter('query_vars', array($this, 'addQueryVars'));
        add_action('parse_request', array($this, 'parseRequests'), 1);
        add_action('init', array($this, 'addRewriteRule'));
        add_action('wp_loaded', array($this, 'flush_rules'));
    }

    /**
     * Add our RewriteRule
     * (webhook endpoints)
     *
     */
    public function addRewriteRule()
    {
        add_rewrite_rule('^' . self::WEBHOOK_PREFIX . '(/.*)?$', 'index.php?__mpwcwh=1', 'top');
    }

    public function addQueryVars($vars)
    {
        $vars[] = '__mpwcwh';

        return $vars;
    }

    public function parseRequests()
    {
        global $wp;
        if (
            (isset($wp->query_vars['pagename']) && preg_match('#^' . self::WEBHOOK_PREFIX . '(/.*)?$#', $wp->query_vars['pagename'])) ||
            isset($wp->query_vars['__mpwcwh'])
        ) {
            $this->handleRequest();
        }
    }

    public function flush_rules()
    {
        $rules = get_option('rewrite_rules');

        if ( ! isset($rules['^' . self::WEBHOOK_PREFIX . '(/.*)?$'])) flush_rewrite_rules();
    }

    /**
     * Handle incoming Marketpay webhooks
     *
     */
    private function handleRequest()
    {
        $this->error_log("\n\nHandling webhook-type URL received at: " . current_time('Y-m-d H:i:s', 0));

        $this->event_type = $this->get_webhook_suffix();
        $this->payload    = $this->get_webhook_content();
        $this->headers    = $this->get_request_headers();

        if ( ! $this->is_authentic()) $this->exit_with_404();

        $this->error_log('Webhook is authentic Ok.');

        /** When setting up the link from MP dashboard RessourceId is empty **/
        if ('' == $this->payload['RessourceId']) $this->reply_to_dashboard_setup();

        try
        {
            $payin = $this->mp->get_payin($this->payload['RessourceId']);
        }
        catch (Exception $e)
        {
            $error_message = 'Error:' . ' ' . $e->getMessage();

            $this->error_log(
                'webhook get_payin debug error @' . current_time('Y-m-d H:i:s', 0) . ': ' .
                $error_message . ' for RessourceId: ' . $this->payload['RessourceId'] . "\n"
            );

            $this->warn_owner(sprintf(
                __('Marketpay Payin API error for Resource ID: %1$s', 'marketpay') . ' ' .
                __('It could be that the Marketpay environment (sandbox or production) has changed since this payment was issued.', 'marketpay'),
                $this->payload['RessourceId']
            ));

            $this->exit_with_404();
        }

        if ( ! $payin)
        {
            $this->warn_owner(sprintf(
                __('Marketpay Payin not found for Resource ID: %1$s', 'marketpay'),
                $this->payload['RessourceId']
            ));

            $this->exit_with_404();
        }

        $this->error_log(
            "\n" . current_time('Y-m-d H:i:s', 0) . ': webhook received' . ': ' . $this->event_type . "\n" .
            'PAYLOAD: ' . print_r($this->payload, true) . "\n" .
            //'HEADERS: ' . print_r( $this->headers, true ) . "\n" .
            'PAYIN: ' . print_r($payin, true) . "\n"
            //'$_SERVER: ' . print_r( $_SERVER, true )
        );

        if (mpAccess::PAYIN_SUCCESS_HK == $this->event_type) $this->handlePayinSuccess($payin);
        if (mpAccess::PAYIN_FAILED_HK == $this->event_type)  $this->handlePayinFailure($payin);

        // Sends out our http response
        echo '200 (OK)';

        exit;
    }

    /**
     * Handle PAYIN_NORMAL_SUCCEEDED webhooks
     *
     */
    private function handlePayinSuccess($payin)
    {
        if ($order_id = $this->verify_payment($payin))
        {
            /**
             * Save the MP transaction ID in the WC order metas
             * this needs to be done before calling payment->complete()
             * to handle auto-completed orders such as downloadables and virtual products & bookings
             *
             */
            $transaction_id = $payin->Id;

            update_post_meta($order_id, 'mp_transaction_id', $transaction_id);
            update_post_meta($order_id, 'mp_success_transaction_id', $transaction_id);

            /** update the history of transaction ids for this order **/
            if (
                ($transaction_ids = get_post_meta($order_id, 'mp_transaction_ids', true)) &&
                is_array($transaction_ids)
            ) {
                $transaction_ids[] = $transaction_id;
            }
            else
            {
                $transaction_ids = array($transaction_id);
            }

            update_post_meta($order_id, 'mp_transaction_ids', $transaction_ids);

            /** at last, validate this order **/
            $this->validate_order($order_id);
        }
        else
        {
            $this->error_log("Invalid order $order_id");
        }
    }

    /**
     * Handle PAYIN_NORMAL_FAILED webhooks
     *
     */
    private function handlePayinFailure($payin)
    {
        if ($order_id = $this->verify_payment($payin))
        {
            /**
             * Save the MP transaction ID in the WC order metas
             * this needs to be done before calling payment->complete()
             * to handle auto-completed orders such as downloadables and virtual products & bookings
             *
             */
            $transaction_id = $payin->Id;

            update_post_meta($order_id, 'mp_transaction_id', $transaction_id);
            update_post_meta($order_id, 'mp_success_transaction_id', $transaction_id);

            /** update the history of transaction ids for this order **/
            if (
                ($transaction_ids = get_post_meta($order_id, 'mp_transaction_ids', true)) &&
                is_array($transaction_ids)
            ) {
                $transaction_ids[] = $transaction_id;
            } else {
                $transaction_ids = array($transaction_id);
            }

            update_post_meta($order_id, 'mp_transaction_ids', $transaction_ids);

            /** at last, validate this order **/
            $this->validate_order($order_id);
        }
        else
        {
            $this->error_log("Invalid order $order_id");
        }
    }

    /**
     * Returns end of the webhook URL that was called
     *
     * @return string $endpoint_suffix
     *
     */
    private function get_webhook_suffix()
    {
        $endpoint_suffix = preg_replace('/\?.*$/', '', basename($_SERVER['REQUEST_URI']));

        if (self::WEBHOOK_PREFIX == $endpoint_suffix) $endpoint_suffix = '';

        if ($this->marketpayWCMain->options['webhook_key'] == $endpoint_suffix)
        {
            $endpoint_suffix = '';
        }

        return $endpoint_suffix;
    }

    /**
     * Returns the content payload of the webhook
     *
     * @return string|boolean
     */
    private function get_webhook_content()
    {
        return $_REQUEST;
    }

    /**
     * Get http request headers (maybe for future incoming webhook authentication?)
     *
     * @see: http://stackoverflow.com/questions/541430/how-do-i-read-any-request-header-in-php
     *
     */
    private function get_request_headers()
    {
        $headers = array();

        foreach ($_SERVER as $key => $value)
        {
            if (substr($key, 0, 5) != 'HTTP_') continue;

            $header           = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }

        return $headers;
    }

    /**
     * Check that the incoming webhook looks somewhat authentic
     *
     */
    private function is_authentic()
    {
        /** Check webhook key **/
        if ( ! $this->check_webhook_key())
        {
            $this->error_log('Webhook key is invalid Nok.');

            return false;
        }

        $this->error_log('Webhook key is checked Ok.');

        /** Check that event_type is present in URL **/
        if ( ! $this->event_type) return false;

        $this->error_log('Has event_type in URL Ok. ' . $this->event_type);

        /** Check that payload is present **/
        if ( ! $this->payload || ! is_array($this->payload)) return false;

        $this->error_log('Has payload Ok.');

        /** Check that EventType is present in payload **/
        if ( ! isset($this->payload['EventType']) || ! $this->payload['EventType'])
        {
            return false;
        }

        $this->error_log('Has event_type in payload Ok. ' . $this->payload['EventType']);

        /** Check that RessourceID is empty or present and numeric in payload **/
        if (
            !isset($this->payload['RessourceId']) ||
            (
                (!$this->payload['RessourceId'] || !is_numeric($this->payload['RessourceId'])) &&
                '' != $this->payload['RessourceId']// when setting up the link from MP dashboard RessourceId is empty
            )
        ) {
            return false;
        }

        $this->error_log('RessourceId Ok.');

        /** Check that Date is present in payload **/
        if (!isset($this->payload['Date']) || !$this->payload['Date'] || !is_numeric($this->payload['Date'])) {
            return false;
        }

        $this->error_log('Date Ok.');

        /** Check that URL and payload event types match **/
        if ($this->event_type != $this->payload['EventType']) return false;

        $this->error_log('Event_type matches Ok.');

        /** Success! **/
        return true;
    }

    /**
     * Check that the payin has indeed succeeded with the right amount
     *
     * @param unknown $payin
     */
    private function verify_payment($payin)
    {
        /** We check for the Order ID first because we need it to warn the right vendor of possible failures **/
        if ( ! preg_match('/^WC Order #(\d+)$/', $payin->Tag, $matches))
        {
            $this->warn_owner(sprintf(
                __('Marketpay Payin does not contain a WooCommerce Order ID reference for Resource ID: %1$s', 'marketpay'),
                $this->payload['RessourceId']
            ));

            return false;
        }

        $order_id = $matches[1];
        $this->error_log('MP Payin WC Order tag verified Ok.');

        /** Card payments get a special treatment **/
        $card_payment = false;

        if (get_post_meta($order_id, 'marketpay_payment_type', true) == 'card')
        {
            $card_payment = true;
        }

        if ( ! $card_payment)
        {
            /** Check that this order was paid by bankwire **/
            if (get_post_meta($order_id, 'marketpay_payment_type', true) != 'bank_wire')
            {
                $this->warn_owner(sprintf(
                    __('Marketpay Payin Resource ID: %1$s references WooCommerce Order ID: %2$s which was not paid by bank wire', 'marketpay'),
                    $this->payload['RessourceId'],
                    $order_id
                ), $order_id);

                return false;
            }

            $this->error_log('MP Payin WC order exists and is bank_wire verified Ok.');

            /** Check that the payin ID matches at least one of the transaction_ids of this order **/
            $mp_transaction_id = get_post_meta($order_id, 'mp_transaction_id', true);
            if (
                ($transaction_ids = get_post_meta($order_id, 'mp_transaction_ids', true)) &&
                is_array($transaction_ids)
            ) {
                $transaction_ids[] = $mp_transaction_id;
            }
            else
            {
                $transaction_ids = array($mp_transaction_id);
            }

            if ($order_payment_ref = get_post_meta($order_id, 'marketpay_payment_ref', true))
            {
                $transaction_ids[] = $order_payment_ref->Id;
            }

            if ( ! in_array($payin->Id, $transaction_ids))
            {
                $this->error_log('Bankwire Payin WC order payin Id matches failed.');
                $this->warn_owner(sprintf(
                    __('Marketpay Payin Resource ID: %1$s references wrong WooCommerce Order ID: %2$s', 'marketpay'),
                    $this->payload['RessourceId'],
                    $order_id
                ), $order_id);

                return false;
            }

            $this->error_log('MP Payin WC order payin Id matches verified Ok.');
        }

        if ($card_payment)
        {
            /** Check that the payin ID matches at least one of the transaction_ids of this order **/
            $mp_transaction_id = get_post_meta($order_id, 'mp_transaction_id', true);

            if (
                ($transaction_ids = get_post_meta($order_id, 'mp_transaction_ids', true)) &&
                is_array($transaction_ids)
            ) {
                $this->error_log('debug case 1');
                $this->error_log('transaction_ids: ' . print_r($transaction_ids, true));
                $transaction_ids[] = $mp_transaction_id;
            }
            else
            {
                $this->error_log('debug case 2');
                $transaction_ids = array($mp_transaction_id);
            }

            if ( ! in_array($payin->Id, $transaction_ids))
            {
                $this->error_log('Card MP Payin WC order payin Id matches failed.');
                $this->error_log('order_id: ' . print_r($order_id, true));
                $this->error_log('mp_transaction_id: ' . print_r($mp_transaction_id, true));
                $this->error_log('transaction_ids: ' . print_r($transaction_ids, true));
                $this->error_log('payin->Id: ' . print_r($payin->Id, true));
                $this->warn_owner(sprintf(
                    __('Marketpay Payin Resource ID: %1$s references wrong WooCommerce Order ID: %2$s', 'marketpay'),
                    $this->payload['RessourceId'],
                    $order_id
                ), $order_id);

                return false;
            }

            $this->error_log('Card MP Payin WC order payin Id matches verified Ok.');
        }

        /** Check that payin status is SUCCEEDED **/
        if ('SUCCEEDED' != $payin->Status)
        {
            $this->error_log("MP Payin status is not 'SUCCEEDED' Nok. " . $payin->ResultMessage);
            $message = __('Marketpay Payin did not succeed for Resource ID: %1$s concerning WooCommerce Order ID: %2$s', 'marketpay');

            if (isset($payin->ResultMessage))
            {
                $message .= "\n" . $payin->ResultMessage;
            }

            /** Send an e-mail warning for failed bankwire payins only **/
            if ($card_payment)
            {
                /** For card payments we just add an order note **/
                if (
                    ($order = wc_get_order($order_id)) &&
                    isset($payin->ResultMessage)
                ) {
                    $order->add_order_note(__('Hook note: ', 'marketpay') . $payin->ResultMessage);
                }
            }
            else
            {
                $this->warn_owner(sprintf(
                    $message,
                    $this->payload['RessourceId'],
                    $order_id
                ), $order_id);
            }

            return false;
        }

        $this->error_log("MP Payin 'SUCCEEDED' verified Ok.");

        /** Check that declared/debited funds match **/
        if ( ! $card_payment && $payin->DebitedFunds != $payin->PaymentDetails->DeclaredDebitedFunds)
        {
            $this->warn_owner(sprintf(
                __('Marketpay Payin debited funds do not match declared for Resource ID: %1$s', 'marketpay'),
                $this->payload['RessourceId'],
                $order_id
            ), $order_id);

            return false;
        }

        $this->error_log('MP Payin DebitedFunds == DeclaredDebitedFunds verified Ok.');

        /** Check that declared/fees match **/
        if ( ! $card_payment && $payin->Fees != $payin->PaymentDetails->DeclaredFees)
        {
            $this->warn_owner(sprintf(
                __('Marketpay Payin fees do not match declared for Resource ID: %1$s', 'marketpay'),
                $this->payload['RessourceId'],
                $order_id
            ), $order_id);

            return false;
        }

        $this->error_log('MP Payin Fees == DeclaredFees verified Ok.');

        /** Success! **/
        return $order_id;
    }

    /**
     * Switches the order to "Paid" status
     *
     */
    private function validate_order($order_id)
    {
        $note       = sprintf(__('Received valid Marketpay %1$s webhook', 'marketpay'), $this->event_type);
        $order      = wc_get_order($order_id);
        $old_status = $order->get_status();

        $this->error_log("Old status: $old_status");

        $order->add_order_note(__('Hook note: ', 'marketpay') . $note);
        $order->update_status($order->get_status(), $note);

        $this->error_log('Trying order->payment_complete()...');

        try
        {
            $order->payment_complete($order_id);
        }
        catch (Exception $e)
        {
            $error_message = 'Error:' . ' ' . $e->getMessage();

            $this->error_log(
                'payment_complete debug error @' . current_time('Y-m-d H:i:s', 0) . ': ' .
                $error_message . "\n"
            );

            $this->warn_owner(sprintf(
                __('Marketpay Payin webhook could not complete payment for order: %1$s. %2$s', 'marketpay'),
                $order_id,
                $error_message
            ), $order_id);
        }

        $new_status = $order->get_status();
        $this->error_log("New status: $new_status");
    }

    /**
     * Exit with a 404 header
     * when incoming webhook looks suspicious
     *
     */
    private function exit_with_404()
    {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
        include get_query_template('404');
        die();
    }

    /**
     * When setting up the link from MP dashboard RessourceId is empty
     *
     */
    private function reply_to_dashboard_setup()
    {
        // Sends out our http response
        echo '200 (Setup OK)';

        $this->error_log(
            "\n" . current_time('Y-m-d H:i:s', 0) . ': setup test webhook received' . ': ' .
            $this->event_type . "\n" .
            'PAYLOAD: ' . print_r($this->payload, true) . "\n"
            //'HEADERS: ' . print_r( $this->headers, true ) . "\n" .
            //'$_SERVER: ' . print_r( $_SERVER, true )
        );

        exit;
    }

    /**
     * Checks that the webhook key is present and valid
     *
     */
    private function check_webhook_key()
    {
        if (!preg_match('|' . self::WEBHOOK_PREFIX . '/([0-9a-f]{32})/' . $this->event_type . '\?|', $_SERVER['REQUEST_URI'], $matches)) {
            return false;
        }

        $this->error_log('An MD5 webhook key is present in the URL Ok.');

        if ($matches[1] != $this->marketpayWCMain->options['webhook_key']) {
            return false;
        }

        $this->error_log('Webhook key is valid Ok.');

        return true;
    }

    /**
     * Send an error warning by e-mail to the webmaster
     * Also registers an order note if an order ID is provided
     *
     */
    private function warn_owner($message, $order_id = null)
    {
        $recipients   = array();
        $recipients[] = get_option('admin_email');

        if ($order_id)
        {
            if ($order = wc_get_order($order_id))
            {
                if (self::WARN_VENDORS)
                {
                    // usually turned off
                    /** get e-mail of all vendors concerned by this order **/
                    $items = $order->get_items();
                    foreach ($items as $item)
                    {
                        $vendor_id    = get_post_field('post_author', $item['product_id']);
                        $vendor_email = get_the_author_meta('email', $vendor_id);

                        if ( ! in_array($vendor_email, $recipients))
                        {
                            $recipients[] = $vendor_email;
                        }
                    }
                }

                /** register order notice **/
                $order->add_order_note(__('Hook note: ', 'marketpay') . $message);
            }
        }

        $this->error_log('Sending warning e-mail to recipients:' . print_r($recipients, true));
        $this->error_log('e-mail message: ' . $message);

        return wp_mail(
            $recipients,
            __('Marketpay Bank Wire webhook warning', 'marketpay'),
            $message
        );
    }

    /**
     * Logs error in the logfile
     * only if self::LOGGING is true
     *
     */
    private function error_log($msg)
    {
        if (self::LOGGING)
        {
            error_log($msg . "\n", 3, $this->logFilePath);
        }
    }
}
