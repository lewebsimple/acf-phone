<?php
/**
 * Plugin Name:     ACF Phone
 * Plugin URI:      https://github.com/lewebsimple/acf-phone
 * Description:     Phone number field for Advanced Custom Fields v5.
 * Author:          Pascal Martineau <pascal@lewebsimple.ca>
 * Author URI:      https://lewebsimple.ca
 * License:         GPLv2 or later
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     acf-phone
 * Domain Path:     /languages
 * Version:         1.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'acf_phone_plugin' ) ) {

	class acf_phone_plugin {

		public $settings;

		function __construct() {
			$this->settings = array(
				'version' => '1.0.2',
				'url'     => plugin_dir_url( __FILE__ ),
				'path'    => plugin_dir_path( __FILE__ )
			);
			add_action( 'acf/include_field_types', array( $this, 'include_field_types' ) );
		}

		function include_field_types( $version ) {
			load_plugin_textdomain( 'acf-phone', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
			include_once( 'fields/class-acf-phone-v5.php' );
		}

		/**
		 * Helper for displaying acf-phone field value in different formats
		 *
		 * @param array $value the raw phone value
		 * @param string $format the desired format
		 *
		 * @return mixed the formatted value
		 */
		static function format_value( $value, $format = 'national' ) {
			if ( empty( $value['national'] || empty( $value['e164'] ) ) ) {
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

	new acf_phone_plugin();

}
