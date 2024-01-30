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
 * Version:         2.0.3
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
	require_once __DIR__ . '/class-lws-acf-field-phone.php';

	acf_register_field_type( 'lws_acf_field_phone' );
}

/**
 * Legacy support for ACF Phone 1.x
 */
class acf_phone_plugin {

	/**
	 * Helper for displaying acf-phone field value in different formats
	 *
	 * @param array  $value the raw phone value
	 * @param string $format the desired format
	 *
	 * @return mixed the formatted value
	 */
	static function format_value( $value, $format ) {
		if ( ! is_array( $value ) || empty( $value['national'] || empty( $value['e164'] ) ) ) {
			return '';
		}
		$national = $value['national'] . ( $value['extension'] ? ' ext. ' . $value['extension'] : '' );
		switch ( $format ) {
			case 'national':
				return $national;

			case 'e164':
				return $value['e164'];

			case 'clicktocall':
				return '<a href="tel:' . $value['e164'] . '">' . $national . '</a>';

			case 'array':
			default:
				return $value;
		}
	}

	/**
	 * Helper for encoding acf-phone field value from string
	 *
	 * @param $value
	 *
	 * @return array|bool
	 */
	static function encode_value( $value ) {
		if ( empty( $value ) ) {
			return false;
		}
		$value = preg_replace( '/[^0-9]/', '', $value );
		if ( strlen( $value ) !== 10 ) {
			return false;
		}
		$number = array(
			substr( $value, 0, 3 ),
			substr( $value, 3, 3 ),
			substr( $value, 6, 4 ),
		);
		return array(
			'national'  => "({$number[0]}) {$number[1]}-{$number[2]}",
			'country'   => 'CA',
			'e164'      => "+1{$value}",
			'extension' => '',
		);
	}
}
