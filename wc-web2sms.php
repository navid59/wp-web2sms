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
                    'name'     => 'Ce este Web2sms',
                    'type'     => 'title',
                    'desc'     => 'Platforma web2sms a fost creata de catre NETOPIA Payments si a fost special conceputa pentru a asigura fexibilitate.
                    Nu exista cost suplimentar de licentiere, iar platofrma este compatbila cu orice sistem de operare.
                    Avand conectare directa cu toti operatorii GSM din ROMANIA, web2sms livreaza in permanenta beneficii precum: incredere si performanta, un mediu sigur de tranzactionare si acces simplu din orice web browser.
                    Punem un accent deosebit pe transparenta, tarifele noastre reflectand numai costul SMS-urilor livrate catre operatori.
                    Pentru mai multe informaţii, vă rugăm să ne contactaţi la echipa de <a href="mailto:contact@web2sms.ro">suport</a>.<br><br> Daca doresti trimiterea mesajelor de informare catre clientii tai, poti activa plugin-ul si setezi setarii de mai jos.
                    Pentru mai multe informati <a href="#" id="show_documention">Vazi documentație!</a>.',
                    'id'       => 'wc_settings_tab_web2sms_section_title',
                    'css'       => '',
            ),
            'active' => array(
                    'name'		=> 'Enable / Disable',
                    'type'		=> 'checkbox',
                    'desc'      => 'Bifeaza, daca doresti trimiterea mesajelor de informare catre clientii.',
                    'default'	=> 'no',
                    'id'        => 'wc_settings_web2sms_active',
                    'css'       => '',
			),
            'apikey' => array(
                    'name'      => 'Api key',
                    'placeholder' => 'Cheia unica asociata contului web2sms.',
                    'desc_tip'  => 'Api key de la web2sms.ro',
                    'type'      => 'text',
                    'desc'      => 'API cheia, se poate accesa din meniul Dashboard, in <a href="https://www.web2sms.ro/" target="_blank">www.web2sms.ro</a>',
                    'id'        => 'wc_settings_web2sms_apikey',
                    'css'       => '',
            ),
            'secretkey' => array(
                    'name'      => 'Secret key',
                    'placeholder' => 'Cheia secreta asociata contului web2sms.',
                    'desc_tip'  => 'Secret key de la web2sms.ro',
                    'type'      => 'text',
                    'desc'      => 'Cheia secreta, se poate accesa din meniul Dashboard, in <a href="https://www.web2sms.ro/" target="_blank">www.web2sms.ro</a>',
                    'id'        => 'wc_settings_web2sms_secretkey',
                    'css'       => '',
            ),
            'pending_sms_content' => array(
                    'name'        => 'Pending text',
                    'placeholder' => '',
                    'desc_tip'    => 'The sms text, what client will recive by sms on order status pending',
                    'type'        => 'textarea',
                    'desc'        => 'Scrie textul pentru SMS-ul tău cand camanda este in stare "Pending"',
                    'id'          => 'wc_settings_web2sms_pending_text',
                    'css'         => '',
            ),
            'pending' => array(
                    'name'		 => 'Pending',
                    'desc_tip'   => '<button type="button" id="btn_pending" class="btn btn-lg btn-primary">vezi cum arate</button>',
                    'type'		 => 'checkbox',
                    'desc'       => 'Bifeaza, pentru trimiterea SMS in starea "Pending order".',
                    'id'         => 'wc_settings_web2sms_pending_status',
                    'default'	 => 'no',
                    'css'       => '',
            ),
            'onhold_sms_content' => array(
                    'name'        => 'On-Hold text',
                    'placeholder' => '',
                    'desc_tip'    => 'The sms text, what client will recive by sms on order status On-Hold',
                    'type'        => 'textarea',
                    'desc'        => 'Scrie textul pentru SMS-ul tău cand camanda este in stare "On-Hold"',
                    'id'          => 'wc_settings_web2sms_on-hold_text',
                    'css'         => '',
            ),
            'onhold' => array(
                    'name'		=> 'On-Hold',
                    'desc_tip'  => '<button type="button" id="btn_onhold" class="btn btn-lg btn-primary">vezi cum arate</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Bifeaza, pentru trimiterea SMS in starea "On-Hold order"',
                    'id'        => 'wc_settings_web2sms_on-hold_status',
                    'default'	=> 'no',
                    'css'       => '',
            ),
            'failed_sms_content' => array(
                    'name'        => 'Faild text',
                    'placeholder' => '',
                    'desc_tip'    => 'The sms text, what client will recive by sms on order status Faild',
                    'type'        => 'textarea',
                    'desc'        => 'Scrie textul pentru SMS-ul tău cand camanda este in stare "Faild"',
                    'id'          => 'wc_settings_web2sms_failed_text',
                    'css'         => '',
            ),'failed' => array(
                    'name'		=> 'Faild',
                    'desc_tip'   => '<button type="button" id="btn_failed" class="btn btn-lg btn-primary">vezi cum arate</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Bifeaza, pentru trimiterea SMS in starea "Faild order"',
                    'id'        => 'wc_settings_web2sms_failed_status',
                    'default'	=> 'no',
                    'css'       => '',
            ),
            'processing_sms_content' => array(
                    'name'        => 'Processing text',
                    'placeholder' => '',
                    'desc_tip'    => 'The sms text, what client will recive by sms on order status processing',
                    'type'        => 'textarea',
                    'desc'        => 'Scrie textul pentru SMS-ul tău cand camanda este in stare "Processing".',
                    'id'          => 'wc_settings_web2sms_processing_text',
                    'css'         => '',
            ),
            'processing' => array(
                    'name'		=> 'Processing',
                    'desc_tip'   => '<button type="button" id="btn_processing" class="btn btn-lg btn-primary">vezi cum arate</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Set it as checked if you want send SMS on Processing order',
                    'id'        => 'wc_settings_web2sms_processing_status',
                    'default'	=> 'no',
                    'css'       => '',
            ),
            'cancelled_sms_content' => array(
                    'name'        => 'Cancelled text',
                    'placeholder' => '',
                    'desc_tip'    => 'The sms text, what client will recive by sms on order status Cancelled',
                    'type'		  => 'textarea',
                    'desc'        => 'Scrie textul pentru SMS-ul tău cand camanda este in stare "Cancelled".',
                    'id'          => 'wc_settings_web2sms_cancelled_text',
                    'default'	  => 'no',
                    'css'         => '',
			),
            'cancelled' => array(
                    'name'		=> 'Cancelled',
                    'desc_tip'  => '<button type="button" id="btn_cancelled" class="btn btn-lg btn-primary">vezi cum arate</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Bifeaza, pentru trimiterea SMS in starea "Cancelled order"',
                    'id'        => 'wc_settings_web2sms_cancelled_status',
                    'default'	=> 'no',
                    'css'       => '',
            ),
            'completed_sms_content' => array(
                    'name'        => 'Completed text',
                    'placeholder' => '',
                    'desc_tip'    => 'Scrie textul pentru SMS-ul tău cand camanda este in stare "Completed"',
                    'type'        => 'textarea',
                    'desc'        => 'Write your sms text for Completed status',
                    'id'          => 'wc_settings_web2sms_completed_text',
                    'css'         => '',
            ),
            'completed' => array(
                    'name'		=> 'Completed',
                    'desc_tip'  => '<button type="button" id="btn_completed" class="btn btn-lg btn-primary">vezi cum arate</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Bifeaza, pentru trimiterea SMS in starea "Completed order"',
                    'id'        => 'wc_settings_web2sms_completed_status',
                    'default'	=> 'no',
                    'css'       => '',
            ),
            'refunded_sms_content' => array(
                    'name'        => 'Refunded text',
                    'placeholder' => '',
                    'desc_tip'    => 'Scrie textul pentru SMS-ul tău cand camanda este in stare "Refunded"',
                    'type'        => 'textarea',
                    'desc'        => 'Write your sms text for Refunded status',
                    'id'          => 'wc_settings_web2sms_refunded_text',
                    'css'         => '',
            ),
            'refunded' => array(
                    'name'		=> 'Refunded',
                    'desc_tip'  => '<button type="button" id="btn_refunded" class="btn btn-lg btn-primary">vezi cum arate</button>',
                    'type'		=> 'checkbox',
                    'desc'      => 'Bifeaza, pentru trimiterea SMS in starea "Refunded order"',
                    'id'        => 'wc_settings_web2sms_refunded_status',
                    'default'	=> 'no',
                    'css'       => '',
            ),
            'setting_section_end' => array(
                'type' => 'sectionend',
                'id' => 'wc_settings_tab_web2sms_section_title'
            ),
            'abandoned_cart' => array(
                'title' => 'Abandoned cart',
                'type'  => 'title',
                'desc'  => 'Cosurile de cumparaturi abandonate apar in momentul in care un potential client incepe un proces de achizitie pentru o comanda online, dar renunta la aceasta inainte de finalizare.
                Orice produs adaugat in cart care insa nu ajunge sa fie cumparat este considerat un produs abandonat de catre vizitator.
                Prin setari de mai jos aveti posibilitatea sa gestionezi cu ajutorul trimite un SMS ca aducere aminte.',
                'id' => 'wc_settings_tab_web2sms_section_abandoned_cart',
            ),
            'intervalTime' => array(
                'name'      => 'Interval Time',
                'desc_tip'  => 'Send reminder after XX hour',
                'default'   => '5',
                'type'      => 'number',
                'custom_attributes' => array(
                    'min'  => 1,
                    'step' => 1,
                    'max'  => 48,
                ),
                'desc'      => 'An interval time to send reminder after last Cart update time',
                'id'        => 'wc_settings_web2sms_interval_time',
                'css'       => 'width:100px;',
            ),
            'smsRetry' => array(
                'name'      => 'SMS Retry',
                'desc_tip'  => 'Nr of sending reminder SMS',
                'default'   => '2',
                'type'      => 'number',
                'custom_attributes' => array(
                    'min'  => 1,
                    'step' => 1,
                    'max'  => 10,
                ),
                'desc'      => 'Nr of sending reminder SMS',
                'id'        => 'wc_settings_web2sms_sms_retry',
                'css'       => 'width:100px;',
            ),
            'reminder_sms_content' => array(
                'name'        => 'reminder text',
                'placeholder' => 'Salut! nu uita ca ai ceva in cosul tu, dar nu ai finazlizat inca!',
                'desc_tip'    => 'The sms text, what client will recive by sms on Abandoned cart',
                'type'        => 'textarea',
                'desc'        => 'Scrie textul pentru SMS-ul tău pentru "Abandoned cart"',
                'id'          => 'wc_settings_web2sms_reminder_text',
                'css'         => '',
            ),
            'reminder' => array(
                'name'		=> 'reminder',
                'desc_tip'  => '<button type="button" id="btn_reminder" class="btn btn-lg btn-primary">vezi cum arate</button>',
                'type'		=> 'checkbox',
                'desc'      => 'Bifeaza, daca doresti sa trimiteti SMS la cosurii "Abandoned".',
                'id'        => 'wc_settings_web2sms_reminder',
                'default'	=> 'no',
                'css'       => '',
            ),
            'reminder_section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_web2sms_section_abandoned_cart'
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
            case 'reminder':
            case 'reminder_text':
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
    return $result[0];
    
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
    $schedules['schedule_time'] = array(
            'interval'  => 60 * 1,
            'display'   => 'Web2sms reminder cron'
    );
    return $schedules;
}

/**
 * Schedule an action if it's not already scheduled
 */
if ( ! wp_next_scheduled( 'web2sms_cart_notify' ) ) {
    wp_schedule_event( time(), 'schedule_time', 'web2sms_cart_notify' );
}

/**
 * Hook into that action that'll fire every five minutes 
 */
add_action( 'web2sms_cart_notify', 'web2smsReminder' );
function web2smsReminder() {
    global $wpdb;
    $web2sms = new WC_Settings_Web2sms();
    /** 
     * Check reminder is set 
     * */
    $reminderStatus = $web2sms->getSettingOption('reminder') == 'yes' ? true : false;
    $reminderContent = $web2sms->getSettingOption('reminder_text');
    $hasReminderContent = !empty($reminderContent) ? true : false;
    
    if(!$reminderStatus || !$hasReminderContent) {
        return false;
    }

    $interval_time = get_option($web2sms->slug.'_interval_time', array());
    if (empty($interval_time) || $interval_time <= 0 ) {
        return false;
    }

    $sms_retry = get_option($web2sms->slug.'_sms_retry', array());
    if (empty($sms_retry) || $sms_retry <= 0 ) {
        return false;
    }

    $timeAgo    = 1; //$interval_time * 60; // Time base on minutes
    $expireLimit = $timeAgo + ( 48 * 60 ); // 48H plus Interval time set as Expire limit and base on minutes
    
    $intervalTime = date("Y-m-d H:i:s", strtotime("-$timeAgo minutes"));
    $expireTime = date("Y-m-d H:i:s", strtotime("-$expireLimit minutes"));
        
    /**
     * Delete tmp Record
     */
    $deleteTime = date("Y-m-d H:i:s", strtotime("-1 month")); // a month ago
    $wpdb->query('DELETE FROM `'. $wpdb->prefix . 'web2sms_abandoned_cart` WHERE `createdAt` < "'. $deleteTime .'"' );
   

    /**
     * Get list of abonded cart to send SMS
     */
    $results = $wpdb->get_results( 
        $wpdb->prepare('SELECT * FROM `' . $wpdb->prefix . 'web2sms_abandoned_cart` WHERE userInfo != %s AND smsRetry < %d AND expireAt > %s AND updatedAt < %s ', '{}', $sms_retry, $expireTime, $intervalTime)
    );

    foreach ($results as $abandonedCart) {
        # Verify info
        $userInfo = json_decode($abandonedCart->userInfo);
        if(!empty($userInfo->billing_phone)) {
            if(isValidPhoneNumber($userInfo->billing_phone)) {
                // $cartInfo = json_decode($abandonedCart->cartInfo);
                
                /**
                 * Regenerate / Customize SMS Content
                 */
                $strFind = array("%name%", "%lastname%", "%email%");
                $strReplace = array(
                    $userInfo->billing_first_name,
                    $userInfo->billing_last_name,
                    $userInfo->billing_email
                );
                
                $smsContent = str_replace($strFind, $strReplace, $reminderContent);
                $reminderPhoneNr = $userInfo->billing_phone;

                /**
                 *  Send SMS as reminder
                 **/ 
                if($web2sms->isEnable()) {
                  $sendSmsResult = sendSMS(null, null, null, $reminderPhoneNr, $smsContent);
                }


                /**
                 * Update Retry SMS
                 */
                $smsResultObj = json_decode($sendSmsResult);
                if($smsResultObj->status) {
                    $upgradeNrSMS = $abandonedCart->smsRetry+1;
                    $wpdb->query( 
                        $wpdb->prepare(
                            'UPDATE `' . $wpdb->prefix . 'web2sms_abandoned_cart` SET smsRetry = %d , updatedAt = %s WHERE id = %s ',
                            (int) $upgradeNrSMS,
                            date( 'Y-m-d h:i:s', current_time( 'timestamp' )),
                            $abandonedCart->id                       
                        )
                    );
                }
                
                
            } else {
                // Not valid Phone Number --- Do nothing
            }
        } else {
            // No Phone Number  --- Do nothing 
        }
    }
}

/**
 * Validate mobil number before send SMS
 */
function isValidPhoneNumber($phone_number) {
    if(preg_match('/^[0,7]{2}[0-9]{8}+$/', $phone_number)) {
        return true;
    } else{
        return false;
    }
}

/**
 * Abandoned cart web2sms
 */

// Actions to be done on cart update.
add_action( 'woocommerce_add_to_cart', 'web2sms_store_abandoned_cart');
add_action( 'woocommerce_cart_item_removed', 'web2sms_store_abandoned_cart');
add_action( 'woocommerce_cart_item_restored', 'web2sms_store_abandoned_cart');
add_action( 'woocommerce_after_cart_item_quantity_update', 'web2sms_store_abandoned_cart');
add_action( 'woocommerce_calculate_totals', 'web2sms_store_abandoned_cart');
add_action( 'woocommerce_after_checkout_validation', 'web2sms_checkout_validation_cart');
add_action( 'woocommerce_checkout_order_processed', 'web2sms_checkout_order_processed');


/**
 * Temporary storage of cart
 */
function web2sms_store_abandoned_cart() {
    global $wpdb,$woocommerce;
	$currentTime = current_time( 'timestamp' );
    
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
                        'INSERT INTO `' . $wpdb->prefix . 'web2sms_abandoned_cart` ( sessionId, userId, userType, userInfo, cartInfo, checkoutLink, smsRetry, createdAt, expireAt ) VALUES ( %d, %d, %s, %s, %s, %s, %d, %s , %s )',
                        $userId,
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
                // $abandoned_cart_id = $wpdb->insert_id; // The abandoned cart id
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
        
        /**
         * Verify if GUEST cart is already monitoring
         */
        $results = $wpdb->get_results( 
            $wpdb->prepare('SELECT * FROM `' . $wpdb->prefix . 'web2sms_abandoned_cart` WHERE sessionId = %s AND smsRetry = %s ', $sessionId, 0)
        );

        if (count( $results ) === 0 ) {
            if ( '' !== $cartData && '{"cart":[]}' !== $cartData && '""' !== $cartData ) {
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
            }
        } else {
            $updatedCartInfo         = array();
            $updatedCartInfo['cart'] = WC()->session->cart;
            $cartInfo                  = wp_json_encode( $updatedCartInfo );
            
            $wpdb->query( 
                $wpdb->prepare(
                    'UPDATE `' . $wpdb->prefix . 'web2sms_abandoned_cart` SET userId = %d , cartInfo = %s , updatedAt = %s WHERE sessionId = %s ',
                    $userId,
                    $cartInfo,
                    date( 'Y-m-d h:i:s', current_time( 'timestamp' )),
                    $sessionId                       
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

/**
 * Checkout validation cart
 */
function web2sms_checkout_validation_cart($checkouArg){
    global $wpdb;
    $sessionId   = WC()->session->get_customer_id();

    $userInfo['nickname']           = '';
    $userInfo['billing_first_name'] = $checkouArg['billing_first_name'];
    $userInfo['billing_last_name']  = $checkouArg['billing_last_name'];
    $userInfo['billing_email']      = $checkouArg['billing_email'];
    $userInfo['billing_phone']      = $checkouArg['billing_phone'];
    $userInfo = wp_json_encode($userInfo);

    $wpdb->query( 
        $wpdb->prepare(
            'UPDATE `' . $wpdb->prefix . 'web2sms_abandoned_cart` SET userInfo = %s , cartStatus = %d , updatedAt = %s WHERE sessionId = %s ',
            $userInfo,
            1,
            date( 'Y-m-d h:i:s', current_time( 'timestamp' )),
            $sessionId                       
        )
    );
}

/**
 * Checkout validation order processed
 */
function web2sms_checkout_order_processed($orderId){
    global $wpdb;
    $sessionId   = WC()->session->get_customer_id();
    
    $wpdb->query( 
        $wpdb->prepare(
            'UPDATE `' . $wpdb->prefix . 'web2sms_abandoned_cart` SET orderId = %d , updatedAt = %s WHERE sessionId = %s ',
            $orderId,
            date( 'Y-m-d h:i:s', current_time( 'timestamp' )),
            $sessionId                       
        )
    );
}
