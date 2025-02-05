<?php if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly 
?>
<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link      https://app.telecrm.in
 * @since      1.0.1
 *
 * @package    TeleCRM
 * @subpackage TeleCRM/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    TeleCRM
 * @subpackage TeleCRM/admin
 * @author     r@telecrm.in
 */
class TCRM_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $teleCRM    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * tcrm_initialize the class and set its properties.
	 *
	 * @since    1.0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		define( 'TCRM_ACCOUNT_DETAILS_SRC_FILE', plugin_dir_url( dirname( __FILE__ ) ) . 'admin/' );
	}

	public static $enterpriseid;
	public static $authcode;

	public static $allPages = array();

	public static $integratedForms = array();

	public static $hasExistingData = false;

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in TCRM_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The TCRM_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/telecrm-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in TCRM_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The TCRM_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/telecrm-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'wp_args', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( TCRM_NONCE ) ) );

	}

	public function tcrm_add_plugin_settings() {
		if ( current_user_can( 'manage_options' ) ) {
			add_menu_page(
				'TeleCRM Plugin Settings',
				'TeleCRM',
				'manage_options',
				TCRM_SETTINGS_SLUG,
				array(&$this, 'tcrm_render_plugin_settings_page' ),
				plugin_dir_url( __FILE__ ) . 'assets/telecrm-icon.png',
			);
		}
	}

	public function tcrm_render_plugin_settings_page() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/telecrm-admin-display.php';

	}

	public function tcrm_init() {
		$this->tcrm_get_all_pages();
	}

	public function tcrm_get_all_pages() {
		$pageQuery = new WP_Query( array(
			'post_type' => 'page',
			'posts_per_page' => -1
		) );
		array_push( self::$allPages, new TCRM_Page( get_site_url(), get_bloginfo( 'name' ) ) );
		if ( $pageQuery->have_posts() ) {
			while ( $pageQuery->have_posts() ) {
				$pageQuery->the_post();
				array_push( self::$allPages, new TCRM_Page( get_permalink(), get_the_title() ) );
			}
		}
		$postQuery = new WP_Query( array(
			'post_type' => 'post',
			'posts_per_page' => -1
		) );
		if ( $postQuery->have_posts() ) {
			while ( $postQuery->have_posts() ) {
				$postQuery->the_post();
				array_push( self::$allPages, new TCRM_Page( get_permalink(), get_the_title() ) );
			}
		}
	}

	public function tcrm_get_all_integrated_forms() {
		self::$integratedForms = TCRM_Database::tcrm_get_all_forms();
	}

	function filter_form( $formObject ) {
		$formsArray = array();
		$formObject = json_decode( $formObject );
		foreach ( $formObject as $form ) {
			array_push( $formsArray, TCRM_Form::fromJSON( json_decode( wp_json_encode( $form ), true ) ) );
		}
		return $formsArray;
	}

	public function tcrm_save_mappings() {
		check_ajax_referer( TCRM_NONCE );
		$enterpriseid = filter_input( INPUT_POST, 'enterpriseid', FILTER_SANITIZE_STRING );
		$authcode = filter_input( INPUT_POST, 'authcode', FILTER_SANITIZE_STRING );
		$formsArray = filter_input( INPUT_POST, 'forms', FILTER_CALLBACK, array( "options" => array(&$this, "filter_form" ) ) );
		if ( $enterpriseid && strlen( $enterpriseid ) > 0 && $authcode && $formsArray && count( $formsArray ) !== 0 ) {
			TCRM_Database::tcrm_clear_all_tables();
			TCRM_Database::tcrm_insert_credentials( $enterpriseid, $authcode );
			foreach ( $formsArray as $form ) {
				$uniqueFormid = TCRM_Database::tcrm_insert_form( $form->mappings );
				foreach ( $form->pages as $page ) {
					TCRM_Database::tcrm_insert_page( $page->pageUrl, $page->pageTitle, $uniqueFormid );
				}
				$form->id = $uniqueFormid;
			}
			wp_send_json( wp_json_encode( $formsArray ) );
		}
		wp_die();
	}

	public function tcrm_get_mappings() {
		check_ajax_referer( TCRM_NONCE );
		$result = new stdClass();
		$result->forms = TCRM_Database::tcrm_get_all_forms();
		$result->credentials = TCRM_Database::tcrm_get_credentials();
		wp_send_json( wp_json_encode( $result ) );
		wp_die();
	}

}
