<?php if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly 
?>
<?php

/**
 * The file that defines the core plugin class
 *
 * A class deftcrm_inition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://app.telecrm.in
 * @since      1.0.1
 *
 * @package    TeleCRM
 * @subpackage TeleCRM/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.1
 * @package    TeleCRM
 * @subpackage TeleCRM/includes
 * @author     r@telecrm.in
 */
class TeleCRM {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      TCRM_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      string    $teleCRM    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.1
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = TCRM_VERSION;
		} else {
			$this->version = '1.0.1';
		}
		$this->plugin_name = TCRM_PLUGIN_NAME;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - TCRM_Loader. Orchestrates the hooks of the plugin.
	 * - TCRM_i18n. Defines internationalization functionality.
	 * - TCRM_Admin. Defines all hooks for the admin area.
	 * - TCRM_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-telecrm-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-telecrm-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-telecrm-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-telecrm-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-telecrm-database.php';

		$this->loader = new TCRM_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the TCRM_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new TCRM_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new TCRM_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'tcrm_add_plugin_settings' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'tcrm_init' );
		$this->loader->add_action( 'wp_ajax_tcrm_save_mappings', $plugin_admin, 'tcrm_save_mappings' );
		$this->loader->add_action( 'wp_ajax_tcrm_get_mappings', $plugin_admin, 'tcrm_get_mappings' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new TCRM_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_filter( 'tcrm_get_last_lead', $plugin_public, 'tcrm_get_last_lead' );
		$this->loader->add_filter( 'tcrm_get_stored_mappings', $plugin_public, 'tcrm_get_stored_mappings' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'tcrm_enqueue_scripts' );
		$this->loader->add_action( 'forminator_custom_form_submit_before_set_fields', $plugin_public,'tcrm_send_forminator_data', 10, 3);
		$this->loader->add_action( 'tcrm_send_lead_data', $plugin_public, 'tcrm_send_lead_data', 1 );
		$this->loader->add_action( 'tcrm_set_page_url', $plugin_public, 'tcrm_set_page_url', 10, 1 );
		$this->loader->add_action( 'ninja_forms_after_submission', $plugin_public, 'tcrm_send_ninja_form_data', 10, 1 );
		$this->loader->add_action( 'elementor_pro/forms/new_record', $plugin_public, 'tcrm_send_elementor_form_data', 20, 2 );
		$this->loader->add_action( 'wpcf7_before_send_mail', $plugin_public, 'tcrm_send_cf7_data', 30, 1 );
		$this->loader->add_action( 'everest_forms_complete_entry_save', $plugin_public, 'tcrm_send_everest_form_data', 40, 5 );
		$this->loader->add_action( 'wpforms_process_complete', $plugin_public, 'tcrm_send_wpform_data', 50, 4 );
		$this->loader->add_action( 'frm_after_create_entry', $plugin_public, 'tcrm_send_formidable_data', 60, 2 );
		$this->loader->add_action( 'fluentform/submission_inserted', $plugin_public, 'tcrm_send_fluent_data', 70, 3 );
		$this->loader->add_action( 'gform_after_submission', $plugin_public, 'tcrm_send_gravity_data', 80, 2 );
// 		$this->loader->add_action( 'forminator_form_after_save_entry', $plugin_public, 'tcrm_send_forminator_data', 10, 2 );
		$this->loader->add_action( 'metform_after_store_form_data', $plugin_public, 'tcrm_submit_metform_data', 50, 4 );
		$this->loader->add_action( 'houzez_after_agent_form_submission', $plugin_public, 'tcrm_send_houzez_data' );
		$this->loader->add_action( 'houzez_after_contact_form_submission', $plugin_public, 'tcrm_send_houzez_data' );
		$this->loader->add_action( 'houzez_after_estimation_form_submission', $plugin_public, 'tcrm_send_houzez_data' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.1
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.1
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.1
	 * @return    TCRM_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
