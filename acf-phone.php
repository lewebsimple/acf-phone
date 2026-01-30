<?php
/**
 * Plugin Name:     ACF Phone
 * Plugin URI:      https://github.com/lewebsimple/acf-phone
 * Description:     Phone field for Advanced Custom Fields.
 * Author:          Pascal Martineau <pascal@lewebsimple.ca>
 * Author URI:      https://websimple.com
 * License:         GPLv2 or later
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     acf-phone
 * Domain Path:     /languages
 * Version:         3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'init', 'lws_include_acf_field_phone' );
/**
 * Registers the ACF field type.
 */
function lws_include_acf_field_phone() {
	if ( ! function_exists( 'acf_register_field_type' ) ) {
		return;
	}

	load_plugin_textdomain( 'acf-phone', false, plugin_basename( __DIR__ ) . '/languages' );
	require_once __DIR__ . '/class-acf-phone.php';
	require_once __DIR__ . '/class-acf-phone-field.php';

	acf_register_field_type( 'AcfPhoneField' );
}
