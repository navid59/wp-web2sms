<?php

/*
Plugin Name: NETOPIA Payments Payment Gateway
Plugin URI: https://www.netopia-payments.ro
Description: accept payments through NETOPIA Payments
Author: Netopia
Version: 1.0
License: GPLv2
*/

// Include our Gateway Class and register Payment Gateway with WooCommerce
add_action( 'plugins_loaded', 'netopiapayments_init', 0 );
function netopiapayments_init() {
	// If the parent WC_Payment_Gateway class doesn't exist
	// it means WooCommerce is not installed on the site
	// so do nothing
	if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;
	DEFINE ('NTP_PLUGIN_DIR', plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) . '/' );
	
	// If we made it this far, then include our Gateway Class
	include_once( 'wc-netopiapayments-gateway.php' );

	// Now that we have successfully included our class,
	// Lets add it too WooCommerce
	add_filter( 'woocommerce_payment_gateways', 'add_netopiapayments_gateway' );
	function add_netopiapayments_gateway( $methods ) {
		$methods[] = 'netopiapayments';
		return $methods;
	}

    add_action( 'admin_enqueue_scripts', 'netopiapaymentsjs_init' );

	// Add custom action links
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'netopia_action_links' );
	function netopia_action_links( $links ) {
		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=netopiapayments' ) . '">' . __( 'Settings', 'netopiapayments' ) . '</a>',
		);
		return array_merge( $plugin_links, $links );
	}

    function netopiapaymentsjs_init($hook) {
        if ( 'woocommerce_page_wc-settings' != $hook ) {
            return;
        }
        wp_enqueue_script( 'netopiapaymentsjs', plugin_dir_url( __FILE__ ) . 'js/netopiapayments_.js',array('jquery'),'2.0' ,true);
        wp_enqueue_script( 'netopiatoastrjs', plugin_dir_url( __FILE__ ) . 'js/toastr.min.js',array(),'2.0' ,true);
        wp_enqueue_style( 'netopiatoastrcss', plugin_dir_url( __FILE__ ) . 'css/toastr.min.css',array(),'2.0' ,false);
    }
}

// Define our Web2sms Option
add_action( 'plugins_loaded', 'web2sms_init', 0 );
function web2sms_init() {
	// Include our Web2sms Class
	include_once( 'wc-web2sms.php' );

	

	wp_enqueue_script( 'web2smsjs', plugin_dir_url( __FILE__ ) . 'js/web2sms.js',array('jquery'),'1.0' ,true);
	wp_enqueue_style( 'web2smscss', plugin_dir_url( __FILE__ ) . 'css/web2sms.css',array(),'10' ,false);
}