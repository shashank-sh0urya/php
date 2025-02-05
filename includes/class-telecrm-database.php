<?php if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly 
?>
<?php

/**
 * Fired during plugin activation
 *
 * @link      https://app.telecrm.in
 * @since      1.0.1
 *
 * @package    TeleCRM
 * @subpackage TeleCRM/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.1
 * @package    TeleCRM
 * @subpackage TeleCRM/includes
 * @author     r@telecrm.in
 */

class TCRM_table_names {
	public static function tcrm_get_table_prefix() {
		global $wpdb;
		return $wpdb->prefix;
	}

	public static $TCRM_PLUGIN_PAGE_DETAILS = 'tcrm_plugin_details';
	public static $TCRM_PLUGIN_CREDENTIALS = 'tcrm_plugin_credentials';
	public static $TCRM_PLUGIN_FORMS = 'tcrm_plugin_forms';
	public static $TCRM_PLUGIN_DEBUG_TABLE = 'tcrm_debug_table';

}

class TCRM_table_columns {
	public static $ENTERPRISEID = 'enterpriseid';
	public static $AUTHCODE = 'authcode';
	public static $PAGE_URL = 'pageUrl';
	public static $WEBSITE_TAG = 'websiteTag';
	public static $DESCRIPTOR = 'descriptor';
	public static $PAGE_TITLE = 'pageTitle';
	public static $TCRM_FIELD = 'telecrmField';
	public static $FORM_ID = 'formId';
	public static $RESPONSE_CODE = 'response_code';
	public static $LEAD_FIELD = 'lead_field';
	public static $VALUE = 'value';
	public static $DATE_FIELD = 'date_field';
}

class TCRM_Cache_Keys {
	public static $TCRM_UNIQUE_FORM_ID = 'tcrm_unique_form_id';
	public static $TCRM_ALL_FORM_IDS = 'tcrm_all_form_ids';
	public static $TCRM_FORMS = 'tcrm_forms';
	public static $TCRM_MAPPINGS = 'tcrm_mappings';
	public static $TCRM_CREDENTIALS = 'tcrm_credentials';
	public static $TCRM_RESPONSE = 'tcrm_response';

}

class TCRM_Mapping {
	public $websiteTag;
	public $telecrmField;
	public $descriptor;

	function __construct( $websiteTag, $telecrmField, $descriptor ) {
		$this->websiteTag = $websiteTag;
		$this->telecrmField = $telecrmField;
		$this->descriptor = $descriptor;
	}

	public static function fromJSON( $mappingObject ) {
		$mapping = new TCRM_Mapping( '', '', '' );
		if ( isset( $mappingObject ) ) {
			$mapping->websiteTag = isset( $mappingObject[ TCRM_table_columns::$WEBSITE_TAG ] ) ? $mappingObject[ TCRM_table_columns::$WEBSITE_TAG ] : '';
			$mapping->telecrmField = isset( $mappingObject[ TCRM_table_columns::$TCRM_FIELD ] ) ? $mappingObject[ TCRM_table_columns::$TCRM_FIELD ] : '';
			$mapping->descriptor = isset( $mappingObject[ TCRM_table_columns::$DESCRIPTOR ] ) ? $mappingObject[ TCRM_table_columns::$DESCRIPTOR ] : '';
		}
		return $mapping;
	}
}

class TCRM_Form {
	public $id;
	public $pages;
	public $mappings;

	function __construct( $formid, $pages, $mappings ) {
		$this->id = $formid;
		$this->pages = $pages;
		$this->mappings = $mappings;
	}

	public static function fromJSON( $formObject ) {
		$form = new TCRM_Form( 0, array(), array() );
		if ( isset( $formObject ) ) {
			$form->id = isset( $formObject[ TCRM_table_columns::$FORM_ID ] ) ? $formObject[ TCRM_table_columns::$FORM_ID ] : '';
			if ( isset( $formObject['pages'] ) ) {
				$pages = $formObject['pages'];
				foreach ( $pages as $mapping ) {
					array_push( $form->pages, TCRM_Page::fromJSON( $mapping ) );
				}
			}
			if ( isset( $formObject['mappings'] ) ) {
				$mappings = $formObject['mappings'];
				foreach ( $mappings as $mapping ) {
					array_push( $form->mappings, TCRM_Mapping::fromJSON( $mapping ) );
				}
			}
		}
		return $form;
	}




}

class TCRM_Page {
	public $pageUrl;
	public $pageTitle;

	function __construct( $pageUrl, $page ) {
		$this->pageUrl = $pageUrl;
		$this->pageTitle = $page;
	}

	public static function fromJSON( $pageObject ) {
		$page = new TCRM_Page( '', '' );
		if ( isset( $pageObject ) ) {
			$page->pageUrl = isset( $pageObject[ TCRM_table_columns::$PAGE_URL ] ) ? $pageObject[ TCRM_table_columns::$PAGE_URL ] : '';
			$page->pageTitle = isset( $pageObject[ TCRM_table_columns::$PAGE_TITLE ] ) ? $pageObject[ TCRM_table_columns::$PAGE_TITLE ] : '';
		}
		return $page;
	}
}



class TCRM_Database {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.1
	 */
	public static function tcrm_initialise_tables() {
		TCRM_Database::tcrm_initialise_forms_table();
		TCRM_Database::tcrm_initialise_page_table();
		TCRM_Database::tcrm_initialise_credentials_table();
		TCRM_Database::tcrm_initialise_response_table();
	}

	private static function tcrm_initialise_forms_table() {
		$tableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_FORMS;
		$formIdColumn = TCRM_table_columns::$FORM_ID;
		$telecrmFieldColumn = TCRM_table_columns::$TCRM_FIELD;
		$websiteTagColumn = TCRM_table_columns::$WEBSITE_TAG;
		$descriptorColumn = TCRM_table_columns::$DESCRIPTOR;
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "CREATE TABLE IF NOT EXISTS %i (
            %i INT,
            %i TEXT,
            %i TEXT,
            %i TEXT,
            PRIMARY KEY (%i(128),%i)
        )ENGINE=InnoDB", array( $tableName, $formIdColumn, $telecrmFieldColumn, $websiteTagColumn, $descriptorColumn, $websiteTagColumn, $formIdColumn ) ) );
	}

	private static function tcrm_initialise_page_table() {
		$tableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_PAGE_DETAILS;
		$pageUrlColumn = TCRM_table_columns::$PAGE_URL;
		$pageTitleColumn = TCRM_table_columns::$PAGE_TITLE;
		$formIdColumn = TCRM_table_columns::$FORM_ID;
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "CREATE TABLE IF NOT EXISTS %i (
           %i TEXT,
           %i TEXT,
           %i INT,
           PRIMARY KEY (%i(128),%i(128),%i)
        )ENGINE=InnoDB", array( $tableName, $pageUrlColumn, $pageTitleColumn, $formIdColumn, $pageUrlColumn, $pageTitleColumn, $formIdColumn ) ) );
	}

	private static function tcrm_initialise_credentials_table() {
		$tableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_CREDENTIALS;
		$enterpriseidColumn = TCRM_table_columns::$ENTERPRISEID;
		$authcodeColumn = TCRM_table_columns::$AUTHCODE;
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "CREATE TABLE IF NOT EXISTS %i (
            %i TEXT,
            %i TEXT,
            PRIMARY KEY (%i(128))
        )ENGINE=InnoDB", array( $tableName, $enterpriseidColumn, $authcodeColumn, $enterpriseidColumn ) ) );
	}

	private static function tcrm_initialise_response_table() {
		$tableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_DEBUG_TABLE;
		$responseCodeColumn = TCRM_table_columns::$RESPONSE_CODE;
		$leadFieldColumn = TCRM_table_columns::$LEAD_FIELD;
		$valueColumn = TCRM_table_columns::$VALUE;
		$dateFieldColumn = TCRM_table_columns::$DATE_FIELD;
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "CREATE TABLE IF NOT EXISTS %i(
			%i INT,
			%i TEXT,
			%i TEXT,
			%i TEXT
		)ENGINE=InnoDB", array( $tableName, $responseCodeColumn, $leadFieldColumn, $dateFieldColumn, $valueColumn ) ) );
	}

	public static function tcrm_get_unique_form_id() {
		$tableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_FORMS;
		$formId = TCRM_table_columns::$FORM_ID;
		global $wpdb;
		$uniqueFormId = get_transient( TCRM_Cache_Keys::$TCRM_UNIQUE_FORM_ID );
		if ( $uniqueFormId == false ) {
			$uniqueFormId = $wpdb->get_results( $wpdb->prepare( "SELECT MAX(%i) as %i from %i", array( $formId, $formId, $tableName ) ) );
			set_transient( TCRM_Cache_Keys::$TCRM_UNIQUE_FORM_ID, $uniqueFormId, 12 * HOUR_IN_SECONDS );
		}
		return $uniqueFormId[0]->formId + 1;
	}

	private static function tcrm_get_all_unique_form_ids() {
		$tableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_FORMS;
		$formId = TCRM_table_columns::$FORM_ID;
		global $wpdb;
		$formids = get_transient( TCRM_Cache_Keys::$TCRM_ALL_FORM_IDS ) ? get_transient( TCRM_Cache_Keys::$TCRM_ALL_FORM_IDS ) : array();
		if ( count( $formids ) == 0 ) {
			$result = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT %i from %i", array( $formId, $tableName ) ) );
			foreach ( $result as $formid_result ) {
				array_push( $formids, $formid_result->formId );
			}
			set_transient( TCRM_Cache_Keys::$TCRM_ALL_FORM_IDS, $formids, 12 * HOUR_IN_SECONDS );
		}
		return $formids;
	}

	public static function tcrm_insert_form( $mappings ) {
		$uniqueFormId = TCRM_Database::tcrm_get_unique_form_id();
		$tableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_FORMS;
		$formIdColumn = TCRM_table_columns::$FORM_ID;
		$telecrmFieldColumn = TCRM_table_columns::$TCRM_FIELD;
		$websiteTagColumn = TCRM_table_columns::$WEBSITE_TAG;
		$descriptorColumn = TCRM_table_columns::$DESCRIPTOR;
		global $wpdb;
		foreach ( $mappings as $mapping ) {
			$telecrmField = $mapping->telecrmField;
			$websiteTag = $mapping->websiteTag;
			$descriptor = $mapping->descriptor;
			$wpdb->query( $wpdb->prepare( "INSERT INTO %i(%i,%i,%i,%i) VALUES(%d,%s,%s,%s)", array( $tableName, $formIdColumn, $telecrmFieldColumn, $websiteTagColumn,
				$descriptorColumn, $uniqueFormId, $telecrmField, $websiteTag, $descriptor ) ) );
		}
		delete_transient( TCRM_Cache_Keys::$TCRM_FORMS );
		delete_transient( TCRM_Cache_Keys::$TCRM_UNIQUE_FORM_ID );
		delete_transient( TCRM_Cache_Keys::$TCRM_ALL_FORM_IDS );
		delete_transient( TCRM_Cache_Keys::$TCRM_MAPPINGS );
		return $uniqueFormId;
	}

	public static function tcrm_insert_page( $pageUrl, $pageTitle, $formId ) {
		$tableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_PAGE_DETAILS;
		$pageUrlColumn = TCRM_table_columns::$PAGE_URL;
		$pageTitleColumn = TCRM_table_columns::$PAGE_TITLE;
		$formIdColumn = TCRM_table_columns::$FORM_ID;
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "INSERT INTO %i(%i,%i,%i) VALUES(%s,%s,%d)", array( $tableName,
			$pageUrlColumn,
			$pageTitleColumn,
			$formIdColumn, $pageUrl, $pageTitle, $formId ) ) );
	}

	public static function tcrm_insert_recent_response( $response_code, $lead_fields ) {
		$tableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_DEBUG_TABLE;
		$responseCodeColumn = TCRM_table_columns::$RESPONSE_CODE;
		$leadFieldColumn = TCRM_table_columns::$LEAD_FIELD;
		$dateFieldColumn = TCRM_table_columns::$DATE_FIELD;
		$valueColumn = TCRM_table_columns::$VALUE;
		$date = gmdate( 'D M d Y H:i:s O' );
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "DELETE from %i WHERE %i=%d", array( $tableName, $responseCodeColumn, $response_code ) ) );
		foreach ( $lead_fields as $field_name => $field_value ) {
			$field_value = (string) $field_value;
			$wpdb->query( $wpdb->prepare( "INSERT INTO %i(
				%i,
				%i,
				%i,
				%i
			) VALUES(%s,%s,%d,%s)", array( $tableName, $leadFieldColumn, $valueColumn, $responseCodeColumn,
				$dateFieldColumn, $field_name, $field_value, $response_code, $date ) ) );
		}
		delete_transient( TCRM_Cache_Keys::$TCRM_RESPONSE );
	}

	public static function tcrm_get_recent_response() {
		$tableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_DEBUG_TABLE;
		$responseCodeColumn = TCRM_table_columns::$RESPONSE_CODE;
		global $wpdb;
		$result = get_transient( TCRM_Cache_Keys::$TCRM_RESPONSE );
		if ( $result == false ) {
			$result = $wpdb->get_results( $wpdb->prepare( "SELECT * from %i WHERE %i = %d", array(
				$tableName,
				$responseCodeColumn, 200 ) ) );
			set_transient( TCRM_Cache_Keys::$TCRM_RESPONSE, $result, 12 * HOUR_IN_SECONDS );
		}
		return $result;
	}

	public static function tcrm_get_credentials() {
		$tableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_CREDENTIALS;
		$credentials = new stdClass();
		$credentials->enterpriseid = '';
		$credentials->authcode = '';
		global $wpdb;
		$result = get_transient( TCRM_Cache_Keys::$TCRM_CREDENTIALS );
		if ( $result == false ) {
			$result = $wpdb->get_results( $wpdb->prepare( "SELECT * from %i", array( $tableName ) ) );
			set_transient( TCRM_Cache_Keys::$TCRM_CREDENTIALS, $result, 12 * HOUR_IN_SECONDS );
		}
		if ( count( $result ) > 0 ) {
			$credentials->enterpriseid = $result[0]->enterpriseid;
			$credentials->authcode = $result[0]->authcode;
		}
		return $credentials;
	}

	public static function tcrm_insert_credentials( $enterpriseid, $authcode ) {
		$tableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_CREDENTIALS;
		$enterpriseidColumn = TCRM_table_columns::$ENTERPRISEID;
		$authcodeColumn = TCRM_table_columns::$AUTHCODE;
		$credentials = new stdClass();
		$credentials->enterpriseid = $enterpriseid;
		$credentials->authcode = $authcode;
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "INSERT INTO %i(%i,%i) VALUES(%s,%s)", array( $tableName,
			$enterpriseidColumn,
			$authcodeColumn, $enterpriseid, $authcode ) ) );
		delete_transient( TCRM_Cache_Keys::$TCRM_CREDENTIALS );
	}

	public static function tcrm_get_all_forms() {
		$formids = TCRM_Database::tcrm_get_all_unique_form_ids();
		$formIdColumn = TCRM_table_columns::$FORM_ID;
		$formsTableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_FORMS;
		$pageTableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_PAGE_DETAILS;
		$forms = get_transient( TCRM_Cache_Keys::$TCRM_FORMS ) ? get_transient( TCRM_Cache_Keys::$TCRM_FORMS ) : array();
		if ( count( $forms ) == 0 ) {
			global $wpdb;
			foreach ( $formids as $formid ) {
				$mappings = $wpdb->get_results( $wpdb->prepare( "SELECT * from %i WHERE %i=%d", array( $formsTableName, $formIdColumn, $formid ) ) );
				$pages = $wpdb->get_results( $wpdb->prepare( "SELECT * from %i WHERE %i=%d", array( $pageTableName, $formIdColumn, $formid ) ) );
				$form = new TCRM_Form( $formid, $pages, $mappings );
				array_push( $forms, $form );
			}
			set_transient( TCRM_Cache_Keys::$TCRM_FORMS, $forms, 12 * HOUR_IN_SECONDS );
		}
		return $forms;
	}

	public static function tcrm_clear_all_tables() {
		self::tcrm_clear_table( TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_CREDENTIALS );
		self::tcrm_clear_table( TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_PAGE_DETAILS );
		self::tcrm_clear_table( TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_FORMS );
		self::tcrm_clear_table( TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_DEBUG_TABLE );
		delete_transient( TCRM_Cache_Keys::$TCRM_FORMS );
		delete_transient( TCRM_Cache_Keys::$TCRM_CREDENTIALS );
		delete_transient( TCRM_Cache_Keys::$TCRM_RESPONSE );
		delete_transient( TCRM_Cache_Keys::$TCRM_MAPPINGS );
		delete_transient( TCRM_Cache_Keys::$TCRM_UNIQUE_FORM_ID );
		delete_transient( TCRM_Cache_Keys::$TCRM_ALL_FORM_IDS );
	}

	public static function tcrm_drop_all_tables() {
		self::tcrm_delete_table( TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_CREDENTIALS );
		self::tcrm_delete_table( TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_PAGE_DETAILS );
		self::tcrm_delete_table( TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_FORMS );
		self::tcrm_delete_table( TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_DEBUG_TABLE );
		delete_transient( TCRM_Cache_Keys::$TCRM_FORMS );
		delete_transient( TCRM_Cache_Keys::$TCRM_CREDENTIALS );
		delete_transient( TCRM_Cache_Keys::$TCRM_RESPONSE );
		delete_transient( TCRM_Cache_Keys::$TCRM_MAPPINGS );
		delete_transient( TCRM_Cache_Keys::$TCRM_UNIQUE_FORM_ID );
		delete_transient( TCRM_Cache_Keys::$TCRM_ALL_FORM_IDS );

	}

	public static function tcrm_get_all_mappings() {
		global $wpdb;
		$formsTableName = TCRM_table_names::tcrm_get_table_prefix() . TCRM_table_names::$TCRM_PLUGIN_FORMS;
		$telecrmFieldColumn = TCRM_table_columns::$TCRM_FIELD;
		$websiteTagColumn = TCRM_table_columns::$WEBSITE_TAG;
		$mappings = get_transient( TCRM_Cache_Keys::$TCRM_MAPPINGS );
		if ( $mappings == false ) {
			$mappings = $wpdb->get_results( $wpdb->prepare( "SELECT %i,%i from %i", array( $telecrmFieldColumn, $websiteTagColumn, $formsTableName ) ) );
			set_transient( TCRM_Cache_Keys::$TCRM_MAPPINGS, $mappings, 12 * HOUR_IN_SECONDS );
		}
		return $mappings;
	}
	private static function tcrm_delete_table( $table_name ) {
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "DROP TABLE %i", array( $table_name ) ) );
	}

	private static function tcrm_clear_table( $table_name ) {
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "DELETE FROM %i", array( $table_name ) ) );
	}





}
