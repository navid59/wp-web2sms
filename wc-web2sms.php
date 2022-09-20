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
                    'desc'     => '',
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
            'pending' => array(
                    'name'		 => 'Pending',
                    'desc_tip'   => '<button type="button" id="btn_pending" class="btn btn-lg btn-primary">See how looks</button>',
                    'type'		 => 'checkbox',
                    'desc'       => 'Set it as checked if you want send SMS on Pending order',
                    'id'         => 'wc_settings_web2sms_pending_status',
                    'default'	 => 'no',
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
            'onhold' => array(
                    'name'		=> 'On-Hold',
                    'desc_tip'   => '<button type="button" id="btn_onhold" class="btn btn-lg btn-primary">See how looks</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Set it as checked if you want send SMS on On-Hold order',
                    'id'        => 'wc_settings_web2sms_on-hold_status',
                    'default'	=> 'no',
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
            'failed' => array(
                    'name'		=> 'Faild',
                    'desc_tip'   => '<button type="button" id="btn_failed" class="btn btn-lg btn-primary">See how looks</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Set it as checked if you want send SMS on Faild order',
                    'id'        => 'wc_settings_web2sms_failed_status',
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
            'processing_sms_content' => array(
                    'name'      => 'Processing text',
                    'desc_tip'  => 'The sms text, what client will recive by sms on order status processing',
                    'type'      => 'textarea',
                    'desc'      => 'Write your sms text for Processing status',
                    'id'        => 'wc_settings_web2sms_processing_text',
                    'css'       => '',
            ),
            'cancelled' => array(
                    'name'		=> 'Cancelled',
                    'desc_tip'  => '<button type="button" id="btn_cancelled" class="btn btn-lg btn-primary">See how looks</button>'.' | '.' <a href="../wp-content/plugins/netopia-payments-payment-gateway/src/devicesViewCellPhone.php?TB_iframe=true&width=400&height=770" class="thickbox" title="Mobile view" inlineId=examplePopup4" type="button"  value="Show Thickbox Example Pop-up 4">See how your SMS looks like</a>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Set it as checked if you want send SMS on Cancelled order',
                    'id'        => 'wc_settings_web2sms_cancelled_status',
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
            'completed' => array(
                    'name'		=> 'Completed',
                    'desc_tip'  => '<button type="button" id="btn_completed" class="btn btn-lg btn-primary">See how looks</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Set it as checked if you want send SMS on Completed order',
                    'id'        => 'wc_settings_web2sms_completed_status',
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
            'refunded' => array(
                    'name'		=> 'Refunded',
                    'desc_tip'  => '<button type="button" id="btn_refunded" class="btn btn-lg btn-primary">See how looks</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Set it as checked if you want send SMS on Refunded order',
                    'id'        => 'wc_settings_web2sms_refunded_status',
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
        

        if($activeStatus) {
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
    $smsContent     = $web2sms->getSettingOption($smsOrderStatus.'_text');

    // die($smsContent);
    
    /**
     *  Send SMS
     * */ 
    if($web2sms->isActive($smsOrderStatus)) {
        sendSMS($smsOrderId, $smsOrderStatus, $smsReciverName, $smsCellPhoneNr, $smsContent);
        // setLog($data = 'Yes is active - '.$smsOrderId.' - '.$smsOrderStatus.' - '.$smsReciverName.' - '.$smsCellPhoneNr.' - '.$smsContent);   
    } else {
        setLog($data = 'NO, IS NOT ACTIVE - '.$smsOrderId.' - '.$smsOrderStatus.' - '.$smsReciverName.' - '.$smsCellPhoneNr.' - '.$smsContent);
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

    // $smsBody = sprintf("Dear %s The order nr #%d status changed to '%s'",$smsReciverName, $smsOrderId,$smsOrderStatus);
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


add_thickbox();

function setLog($data) {
    //Log the data to your file using file_put_contents.
    file_put_contents(plugin_dir_path( __FILE__ )."logs/smslog.log", print_r($data, true)."\n", FILE_APPEND);
}

add_action( 'wp_ajax_my_action', 'my_action' );
function my_action() {
    session_start();
	global $wpdb;
    $_SESSION['smsStrContent']   = $_POST['str'];
	wp_die(); // this is required to terminate immediately and return a proper response
}