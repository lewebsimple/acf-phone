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
 * Version:         3.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$acf_phone_data = get_file_data( __FILE__, array( 'Version' => 'Version' ) );
define( 'ACF_PHONE_VERSION', $acf_phone_data['Version'] );
define( 'ACF_PHONE_FILE', __FILE__ );
define( 'ACF_PHONE_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACF_PHONE_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_PHONE_BASENAME', plugin_basename( __FILE__ ) );

require_once __DIR__ . '/includes/wpgraphql.php';

// Load plugin only if ACF is active
add_action( 'plugins_loaded', 'acf_phone_plugins_loaded' );
function acf_phone_plugins_loaded() {
	if ( ! acf_phone_has_acf() ) {
		add_action( 'admin_notices', 'acf_phone_missing_acf_notice' );
		return;
	}
	load_plugin_textdomain( 'acf-phone', false, plugin_basename( __DIR__ ) . '/languages' );
	add_action( 'init', 'acf_phone_init' );
}

// Initialize ACF Phone plugin
function acf_phone_init() {
	require_once __DIR__ . '/includes/class-acf-phone.php';
	require_once __DIR__ . '/includes/class-acf-phone-field.php';
	acf_register_field_type( 'AcfPhoneField' );
}

// Detect if ACF is active
function acf_phone_has_acf(): bool {
	return function_exists( 'acf_register_field_type' );
}

// Admin notice for missing ACF
function acf_phone_missing_acf_notice() {
	?>
	<div class="notice notice-error">
		<p>
			<strong>ACF Phone</strong> requires
			<a href="https://www.advancedcustomfields.com/" target="_blank">Advanced Custom Fields</a> to be installed and activated.
		</p>
	</div>
	<?php
}