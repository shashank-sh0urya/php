<?php if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly 
?>
<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link      https://app.telecrm.in
 * @since      1.0.1
 *
 * @package    TeleCRM
 * @subpackage TeleCRM/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="tcrm-flex tcrm-center tcrm-telecrm-plugin-class" id="telecrm-plugin-form">
	<div id="tcrm-welcome-screen" class="tcrm-welcome-screen tcrm-a-flex-center tcrm-d-flex tcrm-welcome-screen">
		<?php include_once ( dirname( __FILE__ ) . '/welcome_screen.php' ); ?>
	</div>
	<div class="tcrm-page-grid tcrm-grid tcrm-d-none" id="tcrm-telecrm-plugin">
		<section class="tcrm-form-wrapper tcrm-grid" id="tcrm-scrollToBottom">
			<form class="tcrm-form-section" id="tcrm-form" autocomplete="off">
				<div id="tcrm-account-details">
					<?php include_once ( dirname( __FILE__ ) . '/account_details.php' ); ?>
				</div>
				<div id="tcrm-page-mappings" class="tcrm-d-none d-block">
					<div class="tcrm-header tcrm-page-header">
						<img src="<?php echo esc_attr( TCRM_ACCOUNT_DETAILS_SRC_FILE . 'assets/dropdown-chevron.png' ); ?>"
							class="tcrm-back-arrow tcrm-d-flex" id="tcrm-back-arrow"
							style="height:8px;cursor:pointer;margin-right:5px;" onclick="onBackClick()">
						Form Mappings<span class="tcrm-page-counts"></span>
					</div>
				</div>
				<div class="tcrm-no-new-forms tcrm-d-none">No New Forms Found for Selected Pages!</div>
				<div class="tcrm-btnClass">
					<div class="tcrm-flex" style="gap:10px;">
						<button id="tcrm-submit-btn" class="tcrm-btn tcrm-btn-primary tcrm-d-none">Submit
							<div class="tcrm-loader tcrm-d-none tcrm-d-flex" id="tcrm-submit-loader"></div>
						</button>
						<button type="button" class="tcrm-btn tcrm-btn-primary tcrm-cancel-btn tcrm-d-none"
							id="tcrm-cancel-btn" title="Add new page" onclick="fetchExistingMappings()">
							Cancel
						</button>
					</div>
					<div class="tcrm-flex tcrm-d-none" style="gap:10px;" id="tcrm-edit-details-btn">
						<button type="button" class="tcrm-btn tcrm-btn-primary" title="Edit Details"
							onclick="switchToEditMode()">
							Edit Mappings
						</button>
						<button type="button" class="tcrm-btn tcrm-btn-primary tcrm-add-new-page" title="Add new page"
							onclick="switchToAddPage()">
							Add New Page
						</button>
					</div>
				</div>
			</form>
		</section>
		<section class="tcrm-banner">
			<?php include_once ( dirname( __FILE__ ) . '/instructions.php' ); ?>
		</section>
	</div>
</div>

<?php include_once ( dirname( __FILE__ ) . '/templates.php' ); ?>