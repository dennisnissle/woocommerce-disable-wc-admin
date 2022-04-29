<?php
/**
 * Plugin Name: Disable WooCommerce Admin
 * Plugin URI: https://github.com/vendidero/woocommerce-disable-wc-admin
 * Description: This plugin disables the (built-in) WooCommerce Admin feature in WooCommerce.
 * Version: 1.0.0
 * Author: vendidero
 * Author URI: https://vendidero.de
 * WC requires at least: 3.9
 * WC tested up to: 5.9
 *
 * Update URI: false
 *
 * @author vendidero
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'plugins_loaded', function() {
	/**
	 * Fake existence of WC Admin
	 */
	if ( ! defined( 'WC_ADMIN_VERSION_NUMBER' ) ) {
		define( 'WC_ADMIN_VERSION_NUMBER', '1.0' );
	}

	if ( ! defined( 'WC_ADMIN_PLUGIN_FILE' ) ) {
		define( 'WC_ADMIN_PLUGIN_FILE', 'woocommerce-admin/woocommerce-admin.php' );
	}

	if ( ! defined( 'WC_ADMIN_APP' ) ) {
		define( 'WC_ADMIN_APP', 'wc-admin-app-none' );
	}
}, 5 );

add_filter( 'woocommerce_admin_disabled', '__return_true', 500 );