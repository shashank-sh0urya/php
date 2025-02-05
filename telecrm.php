<?php if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly 
?>
<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link             https://app.telecrm.in
 * @since             1.0.0
 * @package           TeleCRM
 *
 * @wordpress-plugin
 * Plugin Name:       TeleCRM
 * Plugin URI:       https://telecrm.in/
 * Description:      Retrieve leads on form submission and updates at TeleCRM
 * Version:          1.0.1
 * Author:           Rahul Aggrawal
 * Author URI:       r@telecrm.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       telecrm
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define( 'TCRM_VERSION', '1.0.0' );

define( 'TCRM_PLUGIN_NAME', 'TeleCRM' );

define( 'TCRM_SETTINGS_SLUG', 'telecrm' );

define( 'TCRM_NONCE', 'MAPPINGS' );

define( 'TCRM_SECRET_KEY', 'telecrm-debug' );

define( 'TCRM_ROUTES_NAMESPACE', 'telecrm/v1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-telecrm-activator.php
 */
function tcrm_activate_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-telecrm-activator.php';
	$plugin_activator = new TCRM_Activator();
	$plugin_activator->activate();
}

function tcrm_get_permissions() {
	return true;
}

function tcrm_register_tcrmroutes() {
	register_rest_route( TCRM_ROUTES_NAMESPACE, '/leads/(?P<key>[a-z]+[-][a-z]+)',
		[ 
			'methods' => WP_REST_Server::READABLE,
			'callback' => 'tcrm_get_last_lead',
			'permission_callback' => 'tcrm_get_permissions',
		]
	);

	register_rest_route( TCRM_ROUTES_NAMESPACE, '/leads/',
		[ 
			'methods' => 'POST',
			'callback' => 'tcrm_send_lead_data',
			'permission_callback' => 'tcrm_get_permissions',
		]
	);

	register_rest_route( TCRM_ROUTES_NAMESPACE, '/mappings/', [ 
		'methods' => 'GET',
		'callback' => 'tcrm_get_stored_mappings',
		'permission_callback' => 'tcrm_get_permissions',
	] );
}

function tcrm_get_last_lead( $request ) {
	$response = 'Not Authorized';
	if ( $request['key'] === TCRM_SECRET_KEY ) {
		$response = apply_filters( 'tcrm_get_last_lead', array() );
	}
	return rest_ensure_response( $response );
}

function tcrm_send_lead_data( $request ) {
	do_action( 'tcrm_send_lead_data', $request );
}

function tcrm_set_page_url( $request ) {
	do_action( 'tcrm_set_page_url', $request );
}


function tcrm_get_stored_mappings( $request ) {

	$response = apply_filters( 'tcrm_get_stored_mappings', array() );

	return rest_ensure_response( $response );
}

/**
 * Fires before the administration menu loads in the admin.
 *
 * @param string $context Empty context.
 */


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-telecrm-deactivator.php
 */
function tcrm_deactivate_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-telecrm-deactivator.php';
	TCRM_Deactivator::tcrm_deactivate();
}



register_activation_hook( __FILE__, 'tcrm_activate_plugin' );
register_deactivation_hook( __FILE__, 'tcrm_deactivate_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-telecrm.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.1
 */
function run_telecrm() {

	$plugin = new TeleCRM();
	$plugin->run();
	add_action( 'rest_api_init', 'tcrm_register_tcrmroutes', 1, 0 );


}

run_telecrm();
