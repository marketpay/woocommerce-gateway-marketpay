<?php
/**
 * Marketpay WooCommerce plugin admin methods class
 * This class handles user profile field validations
 *
 * The validation functions are called from:
 * admin.inc.php in the user_edit_checks() function
 * main.inc.php in the wooc_validate_extra_register_fields_user() function
 * main.inc.php in the wooc_validate_extra_register_fields_userfront() function
 * main.inc.php in the wooc_validate_extra_register_fields() function
 * main.inc.php in the wooc_validate_extra_register_fields_checkout() function
 *
 * @author ferran@lemonpay.me
 * @see: https://github.com/marketpay/woocommerce-gateway-marketpay
 *
 **/
class marketpayWCValidation
{
    private $marketpayWCMain;

    private $_list_post_keys = array(
        'billing_first_name' => array('type' => 'single', 'text' => 'First name'),
        'billing_last_name'  => array('type' => 'single', 'text' => 'Last name'),
        'user_birthday'      => array('type' => 'date', 'text' => 'Birthday'),
        'user_nationality'   => array('type' => 'country', 'text' => 'Nationality'),
        'billing_country'    => array('type' => 'country', 'text' => 'Country'),
        'user_mp_status'     => array('type' => 'status', 'text' => 'User status'),
        'user_business_type' => array('type' => 'businesstype', 'text' => 'Business type'),
        'kyc_id_document'    => array('type' => 'single', 'text' => 'ID Document'),
        'kyc_document'       => array('type' => 'single', 'text' => 'Document Attachment ID')
    );

    public function __construct($marketpayWCMain = null)
    {
        $this->marketpayWCMain = $marketpayWCMain;
    }

    /**
     * Validate single style information
     * @param array $data - field data
     */
    public function validate_single(&$data)
    {
        $value = $data['data_post'][$data['key_field']];

        if (isset($this->_list_post_keys[$data['key_field']]))
        {
            $info = $this->_list_post_keys[$data['key_field']];

            if (isset($value) && empty($value))
            {
                $data['message'][] = __($info['text'], 'marketpay');
                $data['message'][] = __('is required!', 'marketpay');

                $this->send_message_format($data);
            }
        }
    }

    /**
     * Validate date-style information
     * (birth date)
     *
     * @param array $data - field data
     */
    public function validate_date(&$data)
    {
        $isset = false;
        $value = false;

        if (isset($data['data_post'][$data['key_field']]))
        {
            $value = $data['data_post'][$data['key_field']];
            $isset = true;
        }
        
        $info = $this->_list_post_keys[$data['key_field']];

        /** If value exists but is empty **/
        if ($isset && empty($value))
        {
            /** To avoid double test error we use that one in a specific case **/
            if (
                isset($data['double_test']['user_birthday']) &&
                1 == $data['double_test']['user_birthday']
            ) {
                $data['message'][] = __($info['text'], 'marketpay');
                $data['message'][] = __('is required!', 'marketpay');
                $this->send_message_format($data);
            }
        }
        /** If date value exists but format is wrong **/
        elseif ($isset && ! $this->validate_date_format($this->convert_date($value)))
        {
            $data['message'][] = __('Invalid ' . $info['text'] . ' date.', 'marketpay');
            $data['message'][] = __('Please use this format: ', 'marketpay');
            $data['message'][] = $this->supported_format(get_option('date_format'));

            $this->send_message_format($data);
        }
        /** If birth date value exists verify that it is in the past **/
        elseif ($isset)
        {
            $input_date = strtotime($this->convert_date($value));
            $today      = strtotime(date('Y-m-d'));

            /** Test if date is in the future **/
            if ($input_date >= $today)
            {
                $data['message'][] = __('Birthday must be lower than today.', 'marketpay');

                $this->send_message_format($data);
            }
        }
    }

    /**
     * Country field validation method
     * Verifies if country field is set
     * Verifies that the country is a valid/known country for WC
     * For specific countries, verify that mandatory state field is also present
     *
     * @param array $data - field data
     *
     */
    public function validate_country(&$data)
    {
        $isset = false;
        $value = false;

        if (isset($data['data_post'][$data['key_field']])) {
            $value = $data['data_post'][$data['key_field']];
            $isset = true;
        }
        $info = $this->_list_post_keys[$data['key_field']];

        /** If value exists but is empty **/
        if ($isset && empty($value)) {

            $data['message'][] = __($info['text'], 'marketpay');
            $data['message'][] = __('is required!', 'marketpay');
            $this->send_message_format($data);

            /** If value exists check if country is valid **/
        } elseif ($isset) {

            $countries_obj = new WC_Countries();
            $countries     = $countries_obj->__get('countries');

            /** Check if country is known/valid for WC **/
            if (!isset($countries[$value])) {
                $data['message'][] = __('Unknown country for Nationality', 'marketpay');
                $this->send_message_format($data);
            }

            /** If one of those countries is selected verify that state is not empty **/
            if (
                isset($value) && (
                    'MX' == $value ||
                    'CA' == $value ||
                    'US' == $value
                )
            ) {
                if (empty($data['data_post']['billing_state'])) {
                    $data['message'][] = __("State", 'marketpay');
                    $data['message'][] = __('is required!', 'marketpay');
                    //$data['message'][] = $data['caller_func'];    // Debug
                    $this->send_message_format($data);
                }
            }
        }
    } // function validate_country($data)

    /**
     * User status validation method
     *
     * @param array $data - field data
     */
    public function validate_status(&$data)
    {

        /**
         * Possibility - 1, the conf:
         * default_buyer_status is either set as
         *     "individuals" OR
         *     "business"
         * -> no need to test
         * -> get out!
         */

        /**
         * Possibility - 2, the conf:
         * default_buyer_status is set as
         * "either" -> add the field "user mp status"
         */
        if (
            isset($data['main_options']['default_buyer_status']) &&
            'either' == $data['main_options']['default_buyer_status']
        ):

            //if we need to test
            //1 if is NOT set and user has already a value, OK
            //2 if is NOT set and user has NOT value -> error
            //3 if set but empty -> error
            //4 if set and full ->
            //4.1 check if it's in a set of values

            //get the data
            $isset = false;
            $value = false;
            if (isset($data['data_post']['user_mp_status'])):
                $value = $data['data_post']['user_mp_status'];
                $isset = true;
            endif;

            //in case of edition
            $user_to_test = false;
            if (isset($data['data_post']['user_id'])):
                $user_to_test = get_user_meta($data['data_post']['user_id'], 'user_mp_status', true);
            endif;

            if (!$isset && !$user_to_test):
                //error
                $data['message'][] = __('User status', 'marketpay');
                $data['message'][] = __('is required!', 'marketpay');
                $this->send_message_format($data);
                return;
            endif;

            //3 if set but empty -> error
            if ($isset && empty($value)):
                //error
                $data['message'][] = __('User status', 'marketpay');
                $data['message'][] = __('is required!', 'marketpay');
                $this->send_message_format($data);
                return;
            endif;

            //4 check if it's in a set of values
            if ($isset && !empty($value)):
                if ($value != 'business' && $value != 'individual' && $value != 'either'):
                    $data['message'][] = __('Unknown user status type', 'marketpay');
                    $this->send_message_format($data);
                    return;
                endif;
            endif;

        endif;

    }

    public function validate_businesstype(&$data)
    {
        //init
        $business = false;

        //test if user is already business or he is registering as business
        if ((isset($data['data_post']['user_mp_status']) && $data['data_post']['user_mp_status'] == "business")):
            $business = "business";
        endif;

        //Get values
        $isset_business      = false;
        $value_business_type = false;
        if (isset($data['data_post']['user_business_type'])):
            $value_business_type = $data['data_post']['user_business_type'];
            $isset_business      = true;
        endif;

        //start test values
        if ($business == "business"):

            //IF it's set AND value is EMPTY --------------------
            if ($isset_business && empty($value_business_type)):
                $data['message'][] = __('Business type', 'marketpay');
                $data['message'][] = __('is required!', 'marketpay');
                $this->send_message_format($data);
                return;
            endif; ///if it's set and value is empty

            //If isset test the differents types ----------------
            if ($isset_business):
                //IF -TYPE- is wrong business type
                if (
            'organisation' != $value_business_type &&
            'business' != $value_business_type &&
            'soletrader' != $value_business_type &&
            '' != $value_business_type
        ):

                    $data['message'][] = __('Unknown business type', 'marketpay');
                    $this->send_message_format($data);
                    return;
                endif; // test organisations types
            endif; //test if isset

        endif; //end if is business
    }

    /**
     * format and use the good format and messenger to send the message
     * @param array $data
     */
    public function send_message_format($data)
    {

        $text   = '';
        $strong = 0;
        if (isset($data['place']) && $data['place'] == "admin"): //if not set it's front
            $text .= '<strong>' . __('Error:', 'marketpay') . '</strong> ';
            $strong = 1;
        endif;

        //assemble message
        foreach ($data['message'] as $part):
            if ($strong == 0):
                $text .= '<strong>' . $part . '</strong> ';
                $strong = 1;
            else:
                $text .= ' ' . $part;
            endif;

        endforeach;

        //if there is the object error send the error
        if (isset($data['wp_error']) && $data['wp_error'] != null && $data['wp_error']):
            $data['wp_error']->add($data['key_field'] . '_error', $text);
        else:
            //else send the notice
            wc_add_notice($text, 'error');
        endif;
    }

    /**
     * If the date format is not properly supported at system level
     * (if textual dates cannot be translated back and forth using the locale settings),
     * this will replace textual month names with month numbers in the date format
     *
     * @param string $date_format
     * @return string $date_format
     *
     * Public because shared with marketpayWCAdmin. TODO: refactor
     *
     */
    public function supported_format($date_format)
    {
        if (date('Y-m-d') == $this->convert_date(date_i18n(get_option('date_format'), time()), get_option('date_format'))) {
            return $date_format;
        }

        return preg_replace('/F/', 'm', $date_format);
    }

    /**
     * Checks that date is a valid Gregorian calendar date
     * Uses the yyyy-mm-dd format as input
     *
     * @param string $date    // yyyy-mm-dd
     * @return boolean
     *
     * Public because shared with marketpayWCAdmin. TODO: refactor
     *
     */
    public function validate_date_format($date)
    {

        if (!preg_match('/^(\d{4,4})\-(\d{2,2})\-(\d{2,2})$/', $date, $matches)) {
            return false;
        }

        if (!wp_checkdate($matches[2], $matches[3], $matches[1], $date)) {
            return false;
        }

        return true;
    }

    /**
     * Check that date conforms to expected date format
     * @see: http://stackoverflow.com/questions/19271381/correctly-determine-if-date-string-is-a-valid-date-in-that-format
     *
     * @param string $date
     * @return boolean
     *
     * Public because shared with marketpayWCAdmin. TODO: refactor
     *
     */
    public function convert_date($date, $format = null)
    {

        if (!$format) {
            $format = $this->supported_format(get_option('date_format'));
        }

        if (preg_match('/F/', $format) && function_exists('strptime')) {

            /** Convert date format to strftime format */
            $format = preg_replace('/j/', '%d', $format);
            $format = preg_replace('/F/', '%B', $format);
            $format = preg_replace('/Y/', '%Y', $format);
            $format = preg_replace('/,\s*/', ' ', $format);
            $date   = preg_replace('/,\s*/', ' ', $date);

            setlocale(LC_TIME, get_locale());

            $d = strptime($date, $format);
            if (false === $d) // Fix problem with accentuated month names on some systems
            {
                $d = strptime(utf8_decode($date), $format);
            }

            if (!$d) {
                return false;
            }

            return
            1900 + $d['tm_year'] . '-' .
            sprintf('%02d', $d['tm_mon'] + 1) . '-' .
            sprintf('%02d', $d['tm_mday']);

        } else {

            $d = DateTime::createFromFormat($format, $date);

            if (!$d) {
                return false;
            }

            return $d->format('Y-m-d');
        }
    }
}
