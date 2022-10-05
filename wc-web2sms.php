<?php

require_once ('vendor/autoload.php');
use Web2sms\Sms\SendSMS;

class WC_Settings_Web2sms {
    public $slug = 'wc_settings_web2sms';
    public $smsOrderId, $smsOrderStatus, $smsReciverName, $smsCellPhoneNr;
    /*
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_web2sms', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab_web2sms', __CLASS__ . '::update_settings' );
    }
    
    
    /*
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_web2sms'] = 'SMS Settings';
        return $settings_tabs;
    }


    /*
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }


    /*
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }


    /*
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function get_settings() {
        $settings = array(
            'section_title' => array(
                    'name'     => 'Web2sms Section',
                    'type'     => 'title',
                    'desc'     => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                   Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                   It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                   It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.<br><br> and more recently with desktop publishing software <a href="#" id="show_documention">View my inline content!</a>like Aldus PageMaker including versions of Lorem Ipsum.',
                    'id'       => 'wc_settings_tab_web2sms_section_title',
                    'css'       => '',
            ),
            'active' => array(
                    'name'		=> 'Enable / Disable',
                    'type'		=> 'checkbox',
                    'desc'      => 'Set it as checked if you want to use the SMS Option',
                    'default'	=> 'no',
                    'id'        => 'wc_settings_web2sms_active',
                    'css'       => '',
			),
            'apikey' => array(
                    'name'      => 'Api key',
                    'desc_tip'  => 'Your api key from web2sms.ro',
                    'type'      => 'text',
                    'desc'      => 'Copy your api key from <a href="https://www.web2sms.ro/" target="_blank">www.web2sms.ro</a>',
                    'id'        => 'wc_settings_web2sms_apikey',
                    'css'       => '',
            ),
            'secretkey' => array(
                    'name'      => 'Secret key',
                    'desc_tip'  => 'Your secret key from web2sms.ro',
                    'type'      => 'text',
                    'desc'      => 'Copy your secret key from <a href="https://www.web2sms.ro/" target="_blank">www.web2sms.ro</a>',
                    'id'        => 'wc_settings_web2sms_secretkey',
                    'css'       => '',
            ),
            'pending_sms_content' => array(
                    'name'      => 'Pending text',
                    'desc_tip'  => 'The sms text, what client will recive by sms on order status pending',
                    'type'      => 'textarea',
                    'desc'      => 'Write your sms text for pending status',
                    'id'        => 'wc_settings_web2sms_pending_text',
                    'css'       => '',
            ),
            'pending' => array(
                    'name'		 => 'Pending',
                    'desc_tip'   => '<button type="button" id="btn_pending" class="btn btn-lg btn-primary">See how looks</button>',
                    'type'		 => 'checkbox',
                    'desc'       => 'Set it as checked if you want send SMS on Pending order',
                    'id'         => 'wc_settings_web2sms_pending_status',
                    'default'	 => 'no',
                    'css'       => '',
            ),
            'onhold_sms_content' => array(
                    'name'      => 'On-Hold text',
                    'desc_tip'  => 'The sms text, what client will recive by sms on order status On-Hold',
                    'type'      => 'textarea',
                    'desc'      => 'Write your sms text for On-Hold status',
                    'id'        => 'wc_settings_web2sms_on-hold_text',
                    'css'       => '',
            ),
            'onhold' => array(
                    'name'		=> 'On-Hold',
                    'desc_tip'   => '<button type="button" id="btn_onhold" class="btn btn-lg btn-primary">See how looks</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Set it as checked if you want send SMS on On-Hold order',
                    'id'        => 'wc_settings_web2sms_on-hold_status',
                    'default'	=> 'no',
                    'css'       => '',
            ),
            'failed_sms_content' => array(
                    'name'      => 'Faild text',
                    'desc_tip'  => 'The sms text, what client will recive by sms on order status Faild',
                    'type'      => 'textarea',
                    'desc'      => 'Write your sms text for Faild status',
                    'id'        => 'wc_settings_web2sms_failed_text',
                    'css'       => '',
            ),'failed' => array(
                    'name'		=> 'Faild',
                    'desc_tip'   => '<button type="button" id="btn_failed" class="btn btn-lg btn-primary">See how looks</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Set it as checked if you want send SMS on Faild order',
                    'id'        => 'wc_settings_web2sms_failed_status',
                    'default'	=> 'no',
                    'css'       => '',
            ),
            'processing_sms_content' => array(
                    'name'      => 'Processing text',
                    'desc_tip'  => 'The sms text, what client will recive by sms on order status processing',
                    'type'      => 'textarea',
                    'desc'      => 'Write your sms text for Processing status',
                    'id'        => 'wc_settings_web2sms_processing_text',
                    'css'       => '',
            ),
            'processing' => array(
                    'name'		=> 'Processing',
                    'desc_tip'   => '<button type="button" id="btn_processing" class="btn btn-lg btn-primary">See how looks</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Set it as checked if you want send SMS on Processing order',
                    'id'        => 'wc_settings_web2sms_processing_status',
                    'default'	=> 'no',
                    'css'       => '',
            ),
            'cancelled_sms_content' => array(
                    'name'      => 'Cancelled text',
                    'desc_tip'  => 'The sms text, what client will recive by sms on order status Cancelled',
                    'type'		=> 'textarea',
                    'desc'      => 'Write your sms text for Cancelled order',
                    'id'        => 'wc_settings_web2sms_cancelled_text',
                    'default'	=> 'no',
                    'css'       => '',
			),
            'cancelled' => array(
                    'name'		=> 'Cancelled',
                    'desc_tip'  => '<button type="button" id="btn_cancelled" class="btn btn-lg btn-primary">See how looks</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Set it as checked if you want send SMS on Cancelled order',
                    'id'        => 'wc_settings_web2sms_cancelled_status',
                    'default'	=> 'no',
                    'css'       => '',
            ),
            'completed_sms_content' => array(
                    'name'      => 'Completed text',
                    'desc_tip'  => 'The sms text, what client will recive by sms on order status Completed',
                    'type'      => 'textarea',
                    'desc'      => 'Write your sms text for Completed status',
                    'id'        => 'wc_settings_web2sms_completed_text',
                    'css'       => '',
            ),
            'completed' => array(
                    'name'		=> 'Completed',
                    'desc_tip'  => '<button type="button" id="btn_completed" class="btn btn-lg btn-primary">See how looks</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Set it as checked if you want send SMS on Completed order',
                    'id'        => 'wc_settings_web2sms_completed_status',
                    'default'	=> 'no',
                    'css'       => '',
            ),
            'refunded_sms_content' => array(
                    'name'      => 'Refunded text',
                    'desc_tip'  => 'The sms text, what client will recive by sms on order status Refunded',
                    'type'      => 'textarea',
                    'desc'      => 'Write your sms text for Refunded status',
                    'id'        => 'wc_settings_web2sms_refunded_text',
                    'css'       => '',
            ),
            'refunded' => array(
                    'name'		=> 'Refunded',
                    'desc_tip'  => '<button type="button" id="btn_refunded" class="btn btn-lg btn-primary">See how looks</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Set it as checked if you want send SMS on Refunded order',
                    'id'        => 'wc_settings_web2sms_refunded_status',
                    'default'	=> 'no',
                    'css'       => '',
            ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_web2sms_section_end'
            )
        );

        return apply_filters( 'wc_settings_web2sms_settings', $settings );
    }

    public function getSettingOption($option) {
        global $wpdb;
        switch ($option) {
            case 'active':
            case 'apikey':
            case 'secretkey':
            case 'pending_status':
            case 'pending_text':
            case 'on-hold_status':
            case 'on-hold_text':
            case 'failed_status':
            case 'failed_text':
            case 'processing_status':
            case 'processing_text':
            case 'cancelled_status':
            case 'cancelled_text':
            case 'completed_status':
            case 'completed_text':
            case 'refunded_status':
            case 'refunded_text':
                return  get_option($this->slug.'_'.$option, array());
                break;
            default:
                throw new \Exception('Web2sms -> '.$option.' not exist!');
        }
    }

    public function hasApikey() {
        return !empty($this->getSettingOption('apikey')) ? true : false;
    }

    public function hasSecretkey() {
        return !empty($this->getSettingOption('secretkey')) ? true : false;
    }

    /**
     * Verify if web2sms is enable and ready to use
     */
    function isEnable() {
        $enable = $this->getSettingOption('active') == 'yes' ? true : false;
        if($enable) {
            if($this->hasApikey() && $this->hasSecretkey()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Verify if send sms set for order status
     */
    function isActive($orderStatus) {
        if(!$this->isEnable()){
            return false;
        }
        
        $activeStatus = $this->getSettingOption($orderStatus.'_status') == 'yes' ? true : false;
        $hasContent = !empty($this->getSettingOption($orderStatus.'_text')) ? true : false;
        
        if($activeStatus && $hasContent) {
           return true;
        } else {
            return false;
        }
    }


}

$ntpWeb2sms = new WC_Settings_Web2sms();
$ntpWeb2sms->init();


add_action('woocommerce_order_status_changed', 'woo_order_status_change_custom', 10, 1);
function woo_order_status_change_custom($order_id) {
    $web2sms = new WC_Settings_Web2sms();   

    $order = wc_get_order( $order_id );
    $smsOrderId = $order_id;
    $smsOrderStatus = $order->status;
    $smsReciverName = $order->get_billing_first_name();
    $smsCellPhoneNr = $order->get_billing_phone();
    $smsContentThem = $web2sms->getSettingOption($smsOrderStatus.'_text');

    /**
     * Regenerate / Customize SMS Content
     */
    $strFind = array("%ordId%", "%name%", "%lastname%", "%email%");
    $strReplace = array(
        $order->get_order_number(),
        $order->get_billing_first_name(),
        $order->get_billing_last_name(),
        $order->get_billing_email()
    );
    
    $smsContent     = str_replace($strFind, $strReplace, $smsContentThem);

    /**
     *  Send SMS
     * */ 
    if($web2sms->isActive($smsOrderStatus)) {
        sendSMS($smsOrderId, $smsOrderStatus, $smsReciverName, $smsCellPhoneNr, $smsContent);
    }
}


function sendSMS($smsOrderId, $smsOrderStatus, $smsReciverName, $smsCellPhoneNr, $smsContent){
    
    $web2sms = new WC_Settings_Web2sms();
    

    $sendSMS = new SendSMS();
    $sendSMS->accountType = 'prepaid';                                                  // postpaid | prepaid

    /**
     * Postpaid account
     */
    $sendSMS->apiKey     = $web2sms->getSettingOption('apikey');
    $sendSMS->secretKey  = $web2sms->getSettingOption('secretkey');

    $smsBody = $smsContent;
    $smsRecipient = sprintf("%s", $smsCellPhoneNr);

    $sendSMS->messages[]  = [
                        'sender'            => null,                                    // who send the SMS             // Optional
                        'recipient'         => $smsRecipient,                           // who receive the SMS          // Mandatory
                        'body'              => $smsBody.rand(0,1000),                   // The actual text of SMS       // Mandatory
                        'scheduleDatetime'  => null,                                    // Date & Time to send SMS      // Optional
                        'validityDatetime'  => null,                                    // Date & Time of expire SMS    // Optional
                        'callbackUrl'       => '',                                      // Call back                    // Optional    
                        'userData'          => null,                                    // User data                    // Optional
                        'visibleMessage'    => false                                    // false -> show the Org Msg & True is not showing the Org Msg           // Optional
                        ];

    $sendSMS->setRequest();
    $result = $sendSMS->sendSMS();
    
    setLog("---- ******************* ---".rand(0,100)."\n");
    setLog($result);
    
    
    setLog($sendSMS);
    setLog("---- ------------------- ---".rand(0,100)."\n");
    
}

/**
 * Thicbox for Popup
 */
add_thickbox();


/**
 * Set Log
 */
function setLog($data) {
    //Log the data to your file using file_put_contents.
    file_put_contents(plugin_dir_path( __FILE__ )."logs/smslog.log", print_r($data, true)."\n", FILE_APPEND);
}


add_action( 'wp_ajax_sms_content_calculation', 'sms_content_calculation' );
function sms_content_calculation() {
    session_start();
	global $wpdb;
    $strFind = array("%ordId%", "%name%", "%lastname%", "%email%");
    $strReplace = array("1234", "ClientName", "ClientLastname", "client@email.com");
    $strContent = str_replace($strFind, $strReplace, $_POST['str']);
    $_SESSION['smsStrContent']   = $strContent;
	wp_die(); // this is required to terminate immediately and return a proper response
}


/**
 * To set cron job
 * See http://codex.wordpress.org/Plugin_API/Filter_Reference/cron_schedules
 */
add_filter( 'cron_schedules', 'web2sms_cart_notify' );
function web2sms_cart_notify( $schedules ) {
    $schedules['every_five_minutes'] = array(
            'interval'  => 60 * 1,
            'display'   => __( 'Every 5 Minutes', 'textdomain' )
    );
    return $schedules;
}

/**
 * Schedule an action if it's not already scheduled
 */
if ( ! wp_next_scheduled( 'web2sms_cart_notify' ) ) {
    wp_schedule_event( time(), 'every_five_minutes', 'web2sms_cart_notify' );
}

/**
 * Hook into that action that'll fire every five minutes 
 */
add_action( 'web2sms_cart_notify', 'every_five_minutes_event_func' );
function every_five_minutes_event_func() {
    global $woocommerce;
    // do something here you can perform anything
    setLog("---- WooComerce --- ---- cart recovery ---- ----".rand(0,100)."\n");
    setLog("---- Notify URL ---- 3 ---- ".rand(0,100)." ---- ".print_r(WC()->api_request_url( 'netopiapayments' ), true)."\n");
}

/**
 * Validate mobil number before send SMS
 */
function validateTelNumber() {

}

/**
 * Abandoned cart web2sms
 */

// Actions to be done on cart update.
add_action( 'woocommerce_add_to_cart', 'web2sms_store_cart');
add_action( 'woocommerce_add_to_cart', 'web2sms_store_abandoned_cart');

add_action( 'woocommerce_cart_item_removed', 'web2sms_cart_item_removed');
add_action( 'woocommerce_cart_item_removed', 'web2sms_store_abandoned_cart');

add_action( 'woocommerce_cart_item_restored', 'web2sms_cart_item_restored');
add_action( 'woocommerce_cart_item_restored', 'web2sms_store_abandoned_cart');

add_action( 'woocommerce_after_cart_item_quantity_update', 'web2sms_quantity_update_cart');
add_action( 'woocommerce_after_cart_item_quantity_update', 'web2sms_store_abandoned_cart');

add_action( 'woocommerce_calculate_totals', 'web2sms_calculate_totals_cart');
add_action( 'woocommerce_calculate_totals', 'web2sms_store_abandoned_cart');

add_action( 'woocommerce_after_checkout_validation', 'web2sms_checkout_validation_cart');
add_action( 'woocommerce_after_checkout_validation', 'web2sms_store_abandoned_cart');


/**
 * Temporary storage of cart
 */
function web2sms_store_abandoned_cart() {
    global $wpdb,$woocommerce;
	$currentTime = current_time( 'timestamp' );
    
    $cart_cut_off_time = 60 * 1; // 60 Sec
    if ( is_user_logged_in() ) {
        $userType  = "registered";
        /**
         * Get user info
         */
        $userId   = get_current_user_id();
        $userMeta = get_user_meta( $userId, '', false );
        $userInfo['nickname'] = $userMeta['nickname'][0];
        $userInfo['billing_first_name'] = $userMeta['billing_first_name'][0];
        $userInfo['billing_last_name'] = $userMeta['billing_last_name'][0];
        $userInfo['billing_email'] = $userMeta['billing_email'][0];
        $userInfo['billing_phone'] = $userMeta['billing_phone'][0];
        $userInfo = wp_json_encode($userInfo);

        /**
         * Verify if cart is already monitoring
         */
        $results = $wpdb->get_results( 
                        $wpdb->prepare('SELECT * FROM `' . $wpdb->prefix . 'web2sms_abandoned_cart` WHERE userId = %d AND smsRetry = %s ', $userId, 0)
                    );

        if (count( $results ) === 0 ) {
            if ( '' !== $cartData && '{"cart":[]}' !== $cartData && '""' !== $cartData ) {
                $cartData         = array();
                $cartData['cart'] = WC()->session->cart;
                $cartInfo         = wp_json_encode( $cartData );
                $checkoutLink = WC()->cart->get_checkout_url();
                $wpdb->query( 
                    $wpdb->prepare(
                        'INSERT INTO `' . $wpdb->prefix . 'web2sms_abandoned_cart` ( userId, userType, userInfo, cartInfo, checkoutLink, smsRetry, createdAt, expireAt ) VALUES ( %d, %s, %s, %s, %s, %d, %s , %s )',
                        $userId,
                        $userType,
                        $userInfo,
                        $cartInfo,
                        $checkoutLink,
                        0,
                        date( 'Y-m-d h:i:s', current_time( $currentTime )),
                        date( 'Y-m-d h:i:s', current_time( $currentTime + (2 * 24 * 60 * 60 ) ))                        
                    )
                );
                $abandoned_cart_id = $wpdb->insert_id;
                setLog("Insert id : ".$abandoned_cart_id." -> ".rand(0,100)."\n");
            }
        } else {
            $updatedCartInfo         = array();
            $updatedCartInfo['cart'] = WC()->session->cart;
            $cartInfo                  = wp_json_encode( $updatedCartInfo );

            $wpdb->query( 
                $wpdb->prepare(
                    'UPDATE `' . $wpdb->prefix . 'web2sms_abandoned_cart` SET userInfo = %s , cartInfo = %s , updatedAt = %s WHERE userId = %d ',
                    $userInfo,
                    $cartInfo,
                    date( 'Y-m-d h:i:s', current_time( 'timestamp' )),
                    $userId                       
                )
            );
        }
    } else {
        $userType = "guest";
        $userId   = getCartSession( 'user_id' );

		$cartData         = array();
        if ( function_exists( 'WC' ) ) {
            $cartData['cart'] = WC()->session->cart;
            $checkoutLink     = WC()->cart->get_checkout_url();
            $sessionId       = WC()->session->get_customer_id();
        } else {
            $cartData['cart'] = $woocommerce->session->cart;
            $checkoutLink     = $woocommerce->cart->get_checkout_url();
            $sessionId       = $woocommerce->session->get_customer_id();
        }
        $cartInfo             = wp_json_encode( $cartData );
        
        setLog("--- GUEST --- Costumer ID  : ".$sessionId." -> ".rand(0,100)."\n");

        /**
         * Verify if GUEST cart is already monitoring
         */
        $results = $wpdb->get_results( 
            $wpdb->prepare('SELECT * FROM `' . $wpdb->prefix . 'web2sms_abandoned_cart` WHERE sessionId = %s AND userId = %d AND smsRetry = %s ', $sessionId, $userId, 0)
        );

        if (count( $results ) === 0 ) {
                $userInfo = '{}';
                $wpdb->query( 
                    $wpdb->prepare(
                        'INSERT INTO `' . $wpdb->prefix . 'web2sms_abandoned_cart` ( 	sessionId, userId, userType, userInfo, cartInfo, checkoutLink, smsRetry, createdAt, expireAt ) VALUES ( %s, %d, %s, %s, %s, %s, %d, %s , %s )',
                        $sessionId,
                        $userId,
                        $userType,
                        $userInfo,
                        $cartInfo,
                        $checkoutLink,
                        0,
                        date( 'Y-m-d h:i:s', current_time( $currentTime )),
                        date( 'Y-m-d h:i:s', current_time( $currentTime + (2 * 24 * 60 * 60 ) ))                        
                    )
                );
                $abandoned_cart_id = $wpdb->insert_id;
                setLog("--- GUEST --- Insert id : ".$abandoned_cart_id." -> ".rand(0,100)."\n");
        } else {
            $updatedCartInfo         = array();
            $updatedCartInfo['cart'] = WC()->session->cart;
            $cartInfo                  = wp_json_encode( $updatedCartInfo );
            $userInfo = '{updated:true}';
            
            $wpdb->query( 
                $wpdb->prepare(
                    'UPDATE `' . $wpdb->prefix . 'web2sms_abandoned_cart` SET userInfo = %s , cartInfo = %s , updatedAt = %s WHERE sessionId = %d AND userId = %d',
                    $userInfo,
                    $cartInfo,
                    date( 'Y-m-d h:i:s', current_time( 'timestamp' )),
                    $sessionId,
                    $userId                       
                )
            );
        }

    }
}

/**
 * Get session key if exist
 */
function getCartSession( $session_key ) {
    if (!is_object( WC()->session)) {
        return false;
    }
    return WC()->session->get( $session_key );
}

//Temp method #1
function web2sms_store_cart(){
    setLog("---- web2sms --- store cart ----".rand(0,100)."\n");
}

//Temp method #2
function web2sms_cart_item_removed() {
    setLog("---- web2sms --- cart item removed ----".rand(0,100)."\n");
}

//Temp method #3
function web2sms_cart_item_restored() {
    setLog("---- web2sms --- restore cart ----".rand(0,100)."\n");
}

//Temp method #4
function web2sms_quantity_update_cart() {
    setLog("---- web2sms --- quantity update cart ----".rand(0,100)."\n");
}

//Temp method #5
function web2sms_calculate_totals_cart(){
    /**
     * There is lot's of time whitch totalsum is calculated
     * When Cart is Zero , is not called
     */
    setLog("---- web2sms --- calculate totals cart ----".rand(0,100)."\n");
}

//Temp method #6
function web2sms_checkout_validation_cart(){
    setLog("---- web2sms --- checkout validation cart ----".rand(0,100)."\n");
}
