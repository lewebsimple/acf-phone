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
 * Version:         1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'acf_phone_plugin' ) ) {

	class acf_phone_plugin {

		public $settings;

		function __construct() {
			$this->settings = array(
				'version' => '1.0.0',
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

	}

	new acf_phone_plugin();

}
