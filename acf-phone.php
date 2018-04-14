<?php
/**
 * Plugin Name:     ACF Phone
 * Plugin URI:      https://gitlab.ledevsimple.ca/wordpress/plugins/acf-phone
 * Description:     Phone number field for Advanced Custom Fields v5.
 * Author:          Pascal Martineau <pascal@lewebsimple.ca>
 * Author URI:      https://lewebsimple.ca
 * Text Domain:     acf-phone
 * Domain Path:     /languages
 * Version:         0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'acf_phone_plugin' ) ) {

	class acf_phone_plugin {

		public $settings;

		function __construct() {
			$this->settings = array(
				'version' => '0.1.0',
				'url'     => plugin_dir_url( __FILE__ ),
				'path'    => plugin_dir_path( __FILE__ )
			);
			add_action( 'acf/include_field_types', array( $this, 'include_field' ) );
		}

		function include_field( $version = 5 ) {
			load_plugin_textdomain( 'acf-phone', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
			include_once( 'fields/class-acf-phone-v' . $version . '.php' );
		}

	}

	new acf_phone_plugin();

}
