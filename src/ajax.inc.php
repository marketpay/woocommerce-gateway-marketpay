<?php
/**
 * Ajax methods for Marketpay WooCommerce Plugin admin
 *
 */
class marketpayWCAjax
{
    /** This will store our mpAccess class instance **/
    private $mp;

    /** Ignored items **/
    private $ignored_failed_po   = array();
    private $ignored_refused_kyc = array();

    /**
     * Class constructor
     *
     */
    public function __construct()
    {
        /** Get the stored hidden/ignored items **/
        $this->ignored_failed_po   = get_option('mp_ignored_failed_po', array());
        $this->ignored_refused_kyc = get_option('mp_ignored_refused_kyc', array());

        /** Admin ajax for failed payouts and KYCs dashboard widget **/
        add_action('wp_ajax_ignore_mp_failed_po', array($this, 'ajax_ignore_mp_failed_po'));
        //add_action( 'wp_ajax_retry_mp_failed_po', array( $this, 'ajax_retry_mp_failed_po' ) );
        add_action('wp_ajax_ignore_mp_refused_kyc', array($this, 'ajax_ignore_mp_refused_kyc'));
    }

    /**
     * Stores a failed payout resource ID as ignored
     *
     */
    public function ajax_ignore_mp_failed_po()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $this->ajax_head();
        $response     = null;
        $ressource_id = null;

        if (!empty($_POST['id'])) {
            $ressource_id = $_POST['id'];
        }

        if ($ressource_id && !in_array($ressource_id, $this->ignored_failed_po)) {
            $this->ignored_failed_po[] = $ressource_id;
            $response                  = update_option('mp_ignored_failed_po', $this->ignored_failed_po);
        }

        echo json_encode($response);
        exit;
    }

    /**
     * Stores a refused KYC doc resource ID as ignored
     *
     */
    public function ajax_ignore_mp_refused_kyc()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $this->ajax_head();
        $response     = null;
        $ressource_id = null;

        if (!empty($_POST['id'])) {
            $ressource_id = $_POST['id'];
        }

        if ($ressource_id && !in_array($ressource_id, $this->ignored_refused_kyc)) {
            $this->ignored_refused_kyc[] = $ressource_id;
            $response                    = update_option('mp_ignored_refused_kyc', $this->ignored_refused_kyc);
        }

        echo json_encode($response);
        exit;
    }

    private function ajax_head()
    {
        session_write_close();
        header("Content-Type: application/json");
    }
}

new marketpayWCAjax();