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

add_filter( 'woocommerce_admin_disabled', '__return_true', 500 );

add_filter( 'woocommerce_data_stores', function( $data_stores ) {
	include_once( __DIR__ . '/data-store-admin-note-replacement.php' );

	$data_stores['admin-note'] = new DataStoreAdminNoteReplacement();

	return $data_stores;
}, 1000 );

add_action( 'plugins_loaded', function() {
	$loader = 'Automattic\WooCommerce\Admin\Loader';

	if ( class_exists( $loader ) ) {
		// Handler for WooCommerce and WooCommerce Admin plugin activation.
		remove_action( 'woocommerce_activated_plugin', array( $loader, 'activated_plugin' ) );
		remove_action( 'activated_plugin', array( $loader, 'activated_plugin' ) );
	}

	$composer_package = 'Automattic\WooCommerce\Admin\Composer\Package';

	if ( class_exists( $composer_package ) ) {
		remove_action( 'woocommerce_init', array( $composer_package, 'check_outdated_wca_plugin' ) );
	}

	if ( ! function_exists( 'wc_admin_is_connected_page' ) ) {
		function wc_admin_is_connected_page() {
			return false;
		}
	}

	if ( ! function_exists( 'wc_admin_connect_page' ) ) {
		function wc_admin_connect_page( $options ) {
			return false;
		}
	}

	if ( ! function_exists( 'wc_admin_register_page' ) ) {
		function wc_admin_register_page( $options ) {
			return false;
		}
	}

	if ( ! function_exists( 'wc_admin_is_registered_page' ) ) {
		function wc_admin_is_registered_page() {
			return false;
		}
	}

	if ( ! function_exists( 'wc_admin_get_breadcrumbs' ) ) {
		function wc_admin_get_breadcrumbs() {
			return array();
		}
	}
}, 1000 );

add_action( 'admin_init', function() {
	add_filter( 'woocommerce_admin_features', function() {
		return array();
	}, 100 );

	$classname = 'Automattic\WooCommerce\Admin\Loader';

	if ( class_exists( $classname ) ) {
		$instance  = $classname::get_instance();

		remove_action( 'admin_enqueue_scripts', array( $classname, 'register_scripts' ) );
		remove_action( 'admin_enqueue_scripts', array( $classname, 'inject_wc_settings_dependencies' ), 14 );
		remove_action( 'admin_enqueue_scripts', array( $instance, 'load_scripts' ), 15 );
		// Old settings injection.
		remove_filter( 'woocommerce_components_settings', array( $classname, 'add_component_settings' ) );
		// New settings injection.
		remove_filter( 'woocommerce_shared_settings', array( $classname, 'add_component_settings' ) );
		remove_filter( 'admin_body_class', array( $classname, 'add_admin_body_classes' ) );
		remove_action( 'admin_menu', array( $classname, 'register_page_handler' ) );
		remove_action( 'admin_menu', array( $classname, 'register_store_details_page' ) );
		remove_filter( 'admin_title', array( $classname, 'update_admin_title' ) );
		remove_action( 'rest_api_init', array( $classname, 'register_user_data' ) );
		remove_action( 'in_admin_header', array( $classname, 'embed_page_header' ) );
		remove_filter( 'woocommerce_settings_groups', array( $classname, 'add_settings_group' ) );
		remove_filter( 'woocommerce_settings-wc_admin', array( $classname, 'add_settings' ) );
		remove_action( 'admin_head', array( $classname, 'remove_notices' ) );
		remove_action( 'admin_head', array( $classname, 'smart_app_banner' ) );
	}

	$classname = 'Automattic\WooCommerce\Admin\Features\Features';

	if ( class_exists( $classname ) ) {
		remove_filter( 'woocommerce_get_sections_advanced', array( $classname, 'add_features_section' ) );
		remove_filter( 'woocommerce_get_settings_advanced', array( $classname, 'add_features_settings' ), 10 );
		remove_action( 'admin_enqueue_scripts', array( $classname, 'maybe_load_beta_features_modal' ) );
		remove_action( 'admin_enqueue_scripts', array( $classname, 'load_scripts' ), 15 );
		remove_filter( 'admin_body_class', array( $classname, 'add_admin_body_classes' ) );
		remove_filter( 'update_option_woocommerce_allow_tracking', array( $classname, 'maybe_disable_features' ), 10 );
	}
}, 100 );