<?php if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly 
?>
<?php

/**
 * Fired during plugin deactivation
 *
 * @link      https://app.telecrm.in
 * @since      1.0.1
 *
 * @package    TeleCRM
 * @subpackage TeleCRM/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.1
 * @package    TeleCRM
 * @subpackage TeleCRM/includes
 * @author     r@telecrm.in
 */
class TCRM_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.1
	 */
	public static function tcrm_deactivate() {
		remove_menu_page( TCRM_SETTINGS_SLUG );
	}


}
