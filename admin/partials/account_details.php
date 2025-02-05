<?php if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly 
?>
<h1 style="padding-top:0;">TeleCRM Plugin</h1>
<div class="tcrm-field">
	<div class="tcrm-labels">Key</div class="tcrm-labels">
	<div class="tcrm-sub-head">
		<div>Enter TeleCRM Wordpress account key</div>
		<a class="tcrm-tcrm-page-url" target="_blank"
			href="https://next.telecrm.in/defaulteid/integrations/wordpress?tab=configuration">
			Get Key
			<img src="<?php echo esc_attr( TCRM_ACCOUNT_DETAILS_SRC_FILE . 'assets/external-icon.png' ); ?>"
				style="height:13px; margin-left:3px;"></a>
	</div>
	<input type="text" onblur="validateCredentials()" placeholder="Enter your Key" id="enterpriseid"
		value="<?php echo esc_attr( TCRM_Admin::$enterpriseid ); ?>">
</div>
<div class="tcrm-field tcrm-pt0">
	<div id="no-enterprise-error" class="tcrm-error-prompt" style="display: none">Enter Correct Key</div>
</div>
<div class="tcrm-field">
	<div class="tcrm-labels">Authcode</div>
	<div class="tcrm-sub-head">
		<div>Enter TeleCRM authcode</div>
		<a class="tcrm-page-url" target="_blank"
			href="https://next.telecrm.in/defaulteid/integrations/wordpress?tab=configuration">
			Get authcode
			<img src="<?php echo esc_attr( TCRM_ACCOUNT_DETAILS_SRC_FILE . 'assets/external-icon.png' ); ?>"
				style="height:13px; margin-left:3px;"></a>
	</div>
	<input type="text" onblur="validateCredentials()" placeholder="Enter your authcode" id="authcode"
		value="<?php echo esc_attr( TCRM_Admin::$authcode ); ?>" />
</div>
<div class="field pt0">
	<div id="no-authcode-error" class="tcrm-error-prompt" style="display: none">Enter Correct Authcode</div>
</div>

<div class="tcrm-telecrm-info-container tcrm-mt10">
	<div class="tcrm-field">
		<div class=tcrm-labels>
			Advanced Setting
		</div>
		<div class="tcrm-sub-head">
			Capture Url of the form
		</div>
	</div>
	<div class="tcrm-a-flex-center">
		<label class="tcrm-switch">
			<input type="checkbox" id="tcrm-advanced-setting">
			<span class="tcrm-slider tcrm-round" onclick="toggleAdvancedSetting()"></span>
		</label>
	</div>
</div>
<div id='tcrm-url-mapper'>

</div>
<div class="tcrm-field tcrm-d-none" id="tcrm-selected-pages">
	<div class="tcrm-labels" style="user-select: none;">Select Pages</div class="tcrm-labels">
	<div class="tcrm-sub-head">Choose the pages where your forms are located</div>
	<div class="tcrm-multiselect" tabindex="0" id="tcrm-page-list">
		<div class="tcrm-multiselect-input" id="tcrm-pages-title">
			<div class="tcrm-mslabel" id="tcrm-selected-pages-name">Select Pages</div>
			<span id="tcrm-down-chevron"> <img
					src="<?php echo esc_attr( TCRM_ACCOUNT_DETAILS_SRC_FILE . 'assets/dropdown-chevron.png' ); ?>"
					style="height:8px;"></span>
		</div>
		<div class="tcrm-mslist" id="tcrm-web-pages">
			<div class="tcrm-msitem tcrm-d-flex tcrm-search-wrapper">
				<div onclick="selectAll(this)">
					<input id=select-all type="checkbox" class="tcrm-dropdown-input" />
				</div>
				<input type="text" placeholder="Search Pages" class="tcrm-search-box" oninput="searchPage(this)">
			</div>
			<?php
			for ( $i = 0; $i < count( TCRM_Admin::$allPages ); ++$i ) : ?>
				<div class="tcrm-msitem" onclick="handleOptionClick(this)">
					<input type="checkbox" class="tcrm-dropdown-input"
						value="<?php echo esc_attr( TCRM_Admin::$allPages[ $i ]->pageTitle ); ?>"
						id="<?php echo esc_attr( TCRM_Admin::$allPages[ $i ]->pageUrl ); ?>" />
					<label for="<?php echo esc_attr( TCRM_Admin::$allPages[ $i ]->pageUrl ); ?>">
						<span class="tcrm-title">
							<?php echo esc_attr( TCRM_Admin::$allPages[ $i ]->pageTitle ); ?>
						</span>
						<span class="tcrm-sub-head">
							<?php echo esc_attr( TCRM_Admin::$allPages[ $i ]->pageUrl ); ?>
						</span>
					</label>
					<a href="<?php echo esc_attr( TCRM_Admin::$allPages[ $i ]->pageUrl ); ?>"
						title="<?php echo esc_attr( TCRM_Admin::$allPages[ $i ]->pageUrl ); ?>" target="_blank"
						style="margin-left:auto"><img
							src="<?php echo esc_attr( TCRM_ACCOUNT_DETAILS_SRC_FILE . 'assets/external-icon.png' ); ?>"
							style="height:17px; margin-left:3px;"></a>
				</div>
			<?php endfor; ?>
		</div>
	</div>
</div>
<div class="tcrm-field">
	<div id="tcrm-no-page-error" class="tcrm-error-prompt" style="display: none">*Select atleast one page</div>
</div>
<div id="tcrm-fieldAdder">

</div>
<div id="tcrm-account-details-btns" class="tcrm-btnClass" style="display:flex;margin:0;margin-bottom:10px;gap:10px;">
	<button type="button" id="tcrm-fetch-forms-btn" class="tcrm-btn tcrm-btn-primary" title="Fetch Forms"
		onclick="fetchFormsOfPages()">
		Fetch Forms <div class="tcrm-loader tcrm-d-none" id="tcrm-fetch-form-loader"></div>
	</button>
	<button type="button" class="tcrm-btn tcrm-btn-primary tcrm-cancel-btn tcrm-d-none" id="tcrm-cancel-fetch-btn"
		title="Cancel" onclick="fetchExistingMappings()">
		Cancel
	</button>

</div>