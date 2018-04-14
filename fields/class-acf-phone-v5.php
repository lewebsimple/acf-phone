<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'acf_phone_field' ) ) {

	class acf_phone_field extends acf_field {

		function __construct( $settings ) {
			$this->name     = 'phone';
			$this->label    = __( "Phone", 'acf-phone' );
			$this->category = 'basic';
			// TODO: Default field settings
			$this->defaults = array();
			// TODO: JavaScript string translations
			$this->l10n     = array();
			$this->settings = $settings;
			parent::__construct();
		}

		/**
		 * Render phone field settings
		 *
		 * @param $field (array) the $field being edited
		 */
		function render_field_settings( $field ) {
			// TODO: Render field settings
		}

		/**
		 * Render phone field input
		 *
		 * @param $field (array) the $field being rendered
		 */
		function render_field( $field ) {
			?>
            <input type="tel" name="<?= esc_attr( $field['name'] ) ?>" value="<?= esc_attr( $field['value'] ) ?>"/>
            <noscript>
                <small><?= __( "Please enable JavaScript to use this field.", 'acf-phone' ) ?></small>
            </noscript>
			<?php
		}

		/**
		 * Enqueue input scripts and styles
		 */
		function input_admin_enqueue_scripts() {
			$url     = $this->settings['url'];
			$version = $this->settings['version'];

			wp_register_script( 'intl-tel-input', "{$url}assets/js/intlTelInput.min.js", array( 'jquery' ), '12.1.0' );
			wp_register_script( 'acf-phone', "{$url}assets/js/acf-phone.js", array(
				'acf-input',
				'intl-tel-input'
			), $version );
			wp_enqueue_script( 'acf-phone' );
			wp_localize_script( 'acf-phone', 'options', array(
				'utilsScriptUrl' => "{$url}assets/js/utils.js"
			) );

			wp_register_style( 'intl-tel-input', "{$url}assets/css/intlTelInput.css", array(), '12.1.0' );
			wp_register_style( 'acf-phone', "{$url}assets/css/acf-phone.css", array(
				'acf-input',
				'intl-tel-input'
			), $version );
			wp_enqueue_style( 'acf-phone' );
		}

		/**
		 * Format phone value
		 *
		 * @param $value (mixed) the value which was loaded from the database
		 * @param $post_id (mixed) the $post_id from which the value was loaded
		 * @param $field (array) the $field holding the options
		 *
		 * @return $value (mixed) the formatted value
		 */
		function format_value( $value, $post_id, $field ) {
			return $value;
		}

	}

	new acf_phone_field( $this->settings );

}
