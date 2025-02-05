<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link      https://app.telecrm.in
 * @since      1.0.1
 *
 * @package    TeleCRM
 * @subpackage TeleCRM/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    TeleCRM
 * @subpackage TeleCRM/public
 * @author     r@telecrm.in
 * 
 */


class TCRM_Public {

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

	private $mappings;
	private $stored_mappings;
	private static $credentials;
	private $fetch_lead_on_form_submit;
	private $supported_form_plugins = array(
		"contact-form-7/wp-contact-form-7.php",
		"elementor-pro/elementor-pro.php",
		"elementor/elementor.php",
		"everest-forms/everest-forms.php",
		"fluentform/fluentform.php",
		"formidable/formidable.php",
		"forminator/forminator.php",
		"metform/metform.php",
		"ninja-forms/ninja-forms.php",
		"wpforms-lite/wpforms.php",
	);

	/**
	 * tcrm_initialize the class and set its properties.
	 *
	 * @since    1.0.1
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->tcrm_get_credentials();
		$this->tcrm_get_mappings();
	}
	private function tcrm_get_credentials() {
		self::$credentials = TCRM_Database::tcrm_get_credentials();
	}

	private function tcrm_get_mappings() {
		$allMappings = TCRM_Database::tcrm_get_all_mappings();
		foreach ( $allMappings as $mapping ) {
			$this->mappings[ str_replace( "[]", "", $mapping->websiteTag ) ] = $mapping->telecrmField;
			$this->stored_mappings[ $mapping->websiteTag ] = $mapping->telecrmField;

		}
	}

	private function tcrm_is_supported_form_plugin_activated() {
		$all_plugins = get_option( 'active_plugins' );
		$is_supported_form_plugin_active = false;
		foreach ( $this->supported_form_plugins as $plugin ) {
			$is_supported_form_plugin_active = $is_supported_form_plugin_active || in_array( $plugin, $all_plugins );
		}
		return $is_supported_form_plugin_active;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.1
	 */
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.1
	 */
	public function tcrm_enqueue_scripts() {
		$this->enqueue_scripts();
	}
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/telecrm-public.js', array( 'jquery', ), $this->version, array( 'strategy' => 'defer', 'in_footer' => true ) );
		wp_localize_script( $this->plugin_name, 'wp_args', array(
			'lead_url' => home_url( 'wp-json/' . TCRM_ROUTES_NAMESPACE . '/leads/' ),
			'mappings_url' => home_url( 'wp-json/' . TCRM_ROUTES_NAMESPACE . '/mappings/' ),
			'page_url' => home_url( 'wp-json/' . TCRM_ROUTES_NAMESPACE . '/page-url/' ),
			'is_supported_form_plugin_active' => wp_json_encode( $this->tcrm_is_supported_form_plugin_activated() )
		) );
	}

	public function tcrm_get_last_lead() {
		$last_lead = TCRM_Database::tcrm_get_recent_response();
		return array( $last_lead );
	}

	public function tcrm_send_everest_form_data( $id, $fields, $entry, $form_id, $form_data ) {
		$lead_fields = [];
		$form_name = $form_data["settings"]["form_title"];
		foreach ( $fields as $field ) {
			$field_name = 'everest_forms[form_fields][' . $field['id'] . ']';
			$tcrmfield = isset( $this->mappings[ $field_name ] ) ? $this->mappings[ $field_name ] : null;
			if ( $tcrmfield ) {
				if ( $this->tcrm_check_for_array_type( $field['value'] ) ) {
					$values = $this->tcrm_check_for_array_type( $field['value']['label'] ) ? $field['value']['label'] : [ ( $field['value']['label'] ) ];
					foreach ( $values as $value ) {
						$lead_fields = $this->tcrm_handle_values( $value, $tcrmfield, $lead_fields );
					}

				} else {
					$lead_fields = $this->tcrm_handle_values( $field['value'], $tcrmfield, $lead_fields );
				}
			}
		}
		if ( count( $lead_fields ) > 0 ) {
			$this->tcrm_send_data_to_autoupdate_api( $lead_fields, $form_name );
		}
	}

	private function tcrm_handle_values( $raw_value, $field_name, $lead_fields ) {
		$tcrmfield = isset( $this->mappings[ $field_name ] ) ? $this->mappings[ $field_name ] : null;
		if ( $tcrmfield ) {
			if ( $this->tcrm_check_for_array_type( $raw_value ) ) {
				foreach ( $raw_value as $value ) {
					$lead_fields = $this->tcrm_get_comma_separated_values( $lead_fields, $tcrmfield, $value );
				}
			} else {
				$lead_fields = $this->tcrm_get_comma_separated_values( $lead_fields, $tcrmfield, $raw_value );
			}
		}
		return $lead_fields;
	}

	private function tcrm_get_comma_separated_values( $fields, $key, $newValue ) {
		if ( isset( $fields[ $key ] ) ) {
			$fields[ $key ] = ( $fields[ $key ] . ',' . $newValue );
		} else {
			$fields += [ $key => $newValue ];
		}
		return $fields;
	}
	private function tcrm_check_for_array_type( $value ) {
		return gettype( $value ) === 'array';
	}

	function tcrm_send_wpform_data( $fields, $entry, $form_data, $entry_id ) {
		$lead_fields = [];
		$form_name = $form_data['settings']['form_title'];
		foreach ( $fields as $field ) {
			foreach ( $field as $key => $value ) {
				$id = 'wpforms[fields][' . $field['id'] . '][' . $key . ']';

				if ( $key ) {
					$lead_fields = $this->tcrm_handle_values( str_replace( "\n", "", $value ), $id, $lead_fields );
				}
			}
			$id = 'wpforms[fields][' . $field['id'] . ']';
			if ( $key ) {
				$lead_fields = $this->tcrm_handle_values( str_replace( "\n", ",", $field["value"] ), $id, $lead_fields );
			}
		}
		if ( count( $lead_fields ) > 0 ) {
			$this->tcrm_send_data_to_autoupdate_api( $lead_fields, $form_name );
		}
	}

	private function tcrm_extract_value_by_type( $field, $form_value ) {
		if ( $field["widgetType"] === 'mf-password' )
			return '********';
		if ( $field["widgetType"] === 'mf-switch' ) {
			if ( ! $form_value )
				return $field["mf_swtich_disable_text"];
			return $form_value;
		}

		$field_type_with_list = array( "mf-select", "mf-multi-select", "mf-radio", "mf-checkbox" );
		if ( ! in_array( $field["widgetType"], $field_type_with_list ) ) {
			return $form_value;
		}

		$value_list = explode( ",", $form_value );
		$readable_values = array();

		foreach ( $value_list as $raw_value ) {
			foreach ( $field["mf_input_list"] as $input_ref ) {
				if ( isset( $input_ref["mf_input_option_value"] ) && $input_ref["mf_input_option_value"] == $raw_value ) {
					array_push( $readable_values, $input_ref["mf_input_option_text"] );
				} elseif ( isset( $input_ref["value"] ) && $input_ref["value"] == $raw_value ) {
					array_push( $readable_values, $input_ref["label"] );
				}
			}
		}
		return implode( ", ", $readable_values );
	}




	private function tcrm_extract_fields( $form_id, $form_values ) {
		// ref: ./wp-content/plugins/metform/core/entries/form-data.php
		$map_data = \MetForm\Core\Entries\Action::instance()->get_fields( $form_id );
		$form_data = json_decode( wp_json_encode( $map_data ), true );

		$body = array();
		foreach ( $form_data as $index => $field ) {
			$key = $field["mf_input_name"];
			$raw_value = isset( $form_values[ $index ] ) ? $form_values[ $index ] : null;
			$value = $this->tcrm_extract_value_by_type( $field, $raw_value );

			if ( $value === null )
				continue;
			$body[ $key ] = $value;
		}
		return $body;
	}


	function tcrm_submit_metform_data( $form_id, $form_values, $form_settings, $attributes ) {
		$form_name = $form_settings["form_title"];
		$payload = $this->tcrm_extract_fields( $form_id, $form_values );
		$fields = [];
		foreach ( $payload as $key => $value ) {
			$fields = $this->tcrm_handle_values( $value, $key, $fields );
		}
		if ( count( $fields ) > 0 ) {
			$this->tcrm_send_data_to_autoupdate_api( $fields, $form_name );
		}
	}

	function tcrm_send_forminator_data( $entry, $form_id, $form_data_array ) {
		// echo json_encode($form_data_array);
		$lead_fields = [];
		$form_data = Forminator_API::get_form( $form_id );
		$form_settings = $form_data->{'settings'};
		$form_name = $form_settings["formName"];
		foreach ( $form_data_array as $form_data ) {
			$field_name = $form_data["name"];
			$value = $form_data["value"];
			if ( $form_data["field_type"] = "radio" || $form_data["field_type"] = "checkbox" ) {
				if ( $this->tcrm_check_for_array_type( $value ) ) {
					$values = [];
					foreach ( $value as $val ) {
						array_push( $values, $this->get_forminator_field_value( $val, $form_data["field_array"] ) );
					}
					$value = $values;
				} else {
					$value = $this->get_forminator_field_value( $value, $form_data["field_array"] );
				}
			}

			$lead_fields = $this->tcrm_handle_values( $value, $field_name, $lead_fields );
		}
		if ( count( $lead_fields ) > 0 ) {
			$this->tcrm_send_data_to_autoupdate_api( $lead_fields, $form_name );
		}
	}

	private function get_forminator_field_value( $value, $field_array ) {
		$result = $value;
		foreach ( $field_array["options"] as $option ) {
			if ( $option["value"] == $value ) {
				$result = $option["label"];
			}
		}
		return $result;
	}

	function tcrm_send_cf7_data( $contact_form ) {
		$submission = WPCF7_Submission::get_instance();

		if ( null == $submission ) {
			return;
		}
		$posted_data = $submission->get_posted_data();
		$fields = [];
		$form_name = $contact_form->title();
		foreach ( $posted_data as $key => $value ) {
			$fields = $this->tcrm_handle_values( $value, $key, $fields );
		}
		if ( count( $fields ) > 0 ) {
			$this->tcrm_send_data_to_autoupdate_api( $fields, $form_name );
		}
	}

	function tcrm_send_elementor_form_data( $record, $handler ) {
		if ( 'form' !== $record->get( 'form_type' ) ) {
			return;
		}
		$form_name = $record->get_form_settings( 'form_name' );
		$raw_fields = $record->get( 'fields' );
		$fields = [];
		foreach ( $raw_fields as $id => $field ) {
			$field_id = 'form_fields[' . $id . ']';
			$fields = $this->tcrm_handle_values( $field['raw_value'], $field_id, $fields );
		}
		if ( count( $fields ) > 0 ) {
			$this->tcrm_send_data_to_autoupdate_api( $fields, $form_name );
		}
	}

	function tcrm_send_ninja_form_data( $form_data ) {
		$lead_fields = [];
		$form_name = $form_data['settings']['title'];
		foreach ( $form_data['fields'] as $key => $val ) {
			$lead_fields[ $val ] = $this->tcrm_handle_values( $val, $key, $lead_fields );
		}
		if ( count( $lead_fields ) > 0 ) {
			$this->tcrm_send_data_to_autoupdate_api( $lead_fields, $form_name );
		}
	}

	function tcrm_send_formidable_data( $entry_id, $form_id ) {
		$form = FrmForm::getOne( $form_id );
		$form_name = $form->name;
		$fields = FrmField::get_all_for_form( $form_id );
		$lead_fields = [];
		foreach ( $fields as $field ) {
			$field_id = $field->id;
			$value = FrmEntryMeta::get_entry_meta_by_field( $entry_id, $field_id );
			$item_key = 'item_meta[' . $field_id . ']';
			$lead_fields = $this->tcrm_handle_values( $value, $item_key, $lead_fields );
		}
		if ( count( $lead_fields ) > 0 ) {
			$this->tcrm_send_data_to_autoupdate_api( $lead_fields, $form_name );
		}
	}

	function tcrm_send_fluent_data( $insertId, $formData, $form ) {
		$lead_fields = [];
		$form_name = $form->title;
		foreach ( $formData as $field_name => $field_value ) {
			if ( gettype( $field_value ) === 'array' ) {
				foreach ( $field_value as $key => $val ) {
					$second_key = $field_name;
					if ( gettype( $key ) !== 'integer' ) {
						$second_key = $second_key . '[' . $key . ']';
					}
					$lead_fields = $this->tcrm_handle_values( $val, $second_key, $lead_fields );
				}
			} else {
				$lead_fields = $this->tcrm_handle_values( $field_value, $field_name, $lead_fields );
			}
		}
		if ( count( $lead_fields ) > 0 ) {
			$this->tcrm_send_data_to_autoupdate_api( $lead_fields, $form_name );
		}
	}

	function tcrm_send_gravity_data( $entry, $form ) {
		// $fields=
		foreach ( $form['fields'] as $field ) {
			$field_id = $field->id;
			$field_label = $field->label;
			$field_value = rgar( $entry, (string) $field_id );
		}
		// $this->tcrm_send_data_to_autoupdate_api( $form );
	}

	// 	function tcrm_send_forminator_data( $form_id, $response ) {
// 		if ( ! $response )
// 			return;
// 		if ( ! is_array( $response ) )
// 			return;
// 		if ( ! $response['success'] )
// 			return;
// 		$entry_response = Forminator_Form_Entry_Model::get_latest_entry_by_form_id( $form_id );
// 		$entry_data = $entry_response->{'meta_data'};
// 		$lead_fields = [];
// 		$form_data = Forminator_API::get_form( $form_id );
// 		$form_settings = $form_data->{'settings'};
// 		$form_name = $form_settings["formName"];
// 		foreach ( $entry_data as $field_name => $value ) {
// 			$lead_fields = $this->tcrm_handle_values( $value['value'], $field_name, $lead_fields );
// 		}
// 		if ( count( $lead_fields ) > 0 ) {
// 			$this->tcrm_send_data_to_autoupdate_api( $lead_fields, $form_name );
// 		}

	// 	}

	function clean_payload( $form_data ) {
		$exclude_fields = array(
			'webhook',
			'webhook_url',
			'redirect_to',
			'email_to',
			'email_subject',
			'email_to_cc',
			'email_to_bcc',
			'houzez_contact_form',
			'target_email',
			'property_nonce',
			'prop_payment',
			'property_agent_contact_security',
			'contact_realtor_ajax',
			'is_listing_form',
			'submit',
			'realtor_page',
		);

		if ( ! empty( $form_data ) && is_array( $form_data ) ) {
			foreach ( $exclude_fields as $field ) {
				if ( isset( $form_data[ $field ] ) ) {
					unset( $form_data[ $field ] );
				}
			}
		}

		return $form_data;
	}

	function tcrm_send_houzez_data() {
		$posted_data = $this->clean_payload( $_POST );
		$form_name = $posted_data['action'];
		$fields = [];
		foreach ( $posted_data as $key => $value ) {
			$fields = $this->tcrm_handle_values( $value, $key, $fields );
		}
		if ( count( $fields ) > 0 ) {
			$this->tcrm_send_data_to_autoupdate_api( $fields, $form_name );
		}
	}

	function tcrm_send_lead_data( $request ) {
		$fields = $request['fields'];
		$form_url = $request['form_url'];
		$this->tcrm_send_data_to_autoupdate_api( $fields, '', $form_url );
	}

	function tcrm_set_url_mappings( $lead_fields, $url ) {
		$url_components = wp_parse_url( $url );
		$url_mappings = array();
		if ( isset( $url_components['query'] ) ) {
			parse_str( $url_components['query'], $url_mappings );
		}
		$url_mappings += [ '__Form_Url' => $url ];
		foreach ( $url_mappings as $field_name => $value ) {
			$lead_fields = $this->tcrm_handle_values( $value, $field_name, $lead_fields );
		}
		return $lead_fields;
	}


	function tcrm_send_data_to_autoupdate_api( $fields, $form_name, $form_url = '' ) {
		$data = new stdClass();
		$actions = array();
		$action = new stdClass();
		$action->type = 'SYSTEM_NOTE';
		$current_url = $this->tcrm_get_current_url();
		$action->text = 'Lead Source: Website ' . $current_url;
		array_push( $actions, $action );
		$data->actions = $actions;
		if ( $form_name ) {
			$fields['Form Name'] = $form_name;
		}
		$fields = $this->tcrm_set_url_mappings( $fields, $current_url );
		$data->fields = $fields;
		$response = wp_remote_post( 'https://next-api.telecrm.in/enterprise/' . self::$credentials->enterpriseid . '/wordpress', array(
			'method' => 'POST',
			'mode' => 'cors',
			'cache' => 'no-cache',
			'credentials' => 'same-origin',
			'headers' => array(
				'Content-Type' => 'application/json',
				'Authorization' => 'Bearer ' . self::$credentials->authcode
			),
			'redirect' => 'follow',
			'referrer' => 'no-referrer',
			'body' => wp_json_encode( $data ),
		) );
		TCRM_Database::tcrm_insert_recent_response( 200, $fields );
	}

	function tcrm_get_stored_mappings() {
		return $this->stored_mappings;
	}

	function tcrm_get_current_url() {
		global $post;
		$current_url = '';
		$santized_url = filter_input( INPUT_COOKIE, 'page_url', FILTER_SANITIZE_URL );
		if ( filter_var( $santized_url, FILTER_VALIDATE_URL ) ) {
			$current_url = $santized_url;
		} else if ( $post && $post->id ) {
			$current_url = get_permalink( $post->id );
		} else if ( get_permalink() && ! str_contains( get_permalink(), 'admin-ajax.php' ) ) {
			$current_url = get_permalink();
		} else {
			$current_url = home_url();
		}
		return $current_url;
	}

}
