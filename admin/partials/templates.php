<?php if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly 
?>
<template id="tcrm-form-template">
	<div class="tcrm-form tcrm-hide">
		<div class="tcrm-page-name-container" onclick="toggleAccordion(this.id)">
			<div class="tcrm-page-meta-data">
				<p class="tcrm-form-name">

				</p>
				<span class="tcrm-page-urls"></span>
			</div>
			<div class="tcrm-flex">
				<div class="tcrm-error-message tcrm-d-none"><span class="tcrm-left-fields"></span> fields left</div>
				<div>
					<img src="<?php echo esc_attr( TCRM_ACCOUNT_DETAILS_SRC_FILE . 'assets/delete-icon.png' ); ?>"
						class="tcrm-info-img tcrm-mb-10 tcrm-delete-form" title="Delete Form"
						onclick="deleteForm(this)">
					<div class="tcrm-chevron tcrm-down-chevron">
						<img src="<?php echo esc_attr( TCRM_ACCOUNT_DETAILS_SRC_FILE . 'assets/dropdown-chevron.png' ); ?>"
							style="height:8px; user-select:none">
					</div>
				</div>
			</div>
		</div>
		<div class="tcrm-accordion">
			<div class="tcrm-telecrm-website-mapping">
				<div class="tcrm-no-forms-found">No forms Found!</div>
				<div class="tcrm-mapping-container tcrm-mapping-label-cover">
					<!-- <div class="removeField" onclick="removeField(this)" title="remove this row">&times;</div> -->
					<div class="tcrm-field">
						<label for="">TeleCRM Field</label>
						<!-- <input type="text" placeholder="Enter TeleCRM Field" /> -->
					</div>
					<div class="tcrm-field">
						<!-- <div class="tcrm-d-flex w100p mb5"> -->
						<label>Website name Tag</label>
						<!-- </div> -->
						<!-- <input type="text" placeholder="Enter Your Website name Tag" /> -->
					</div>
				</div>
			</div>
			<div class="tcrm-field tcrm-add-more-field">
				<span class="tcrm-addField" onclick="addField(this)"> + Add row </span>
			</div>
		</div>
	</div>
</template>
<template id="tcrm-info-img">

</template>

<template id="tcrm-mapping-template">

	<div class="tcrm-mapping-container">
		<div class="tcrm-removeField" onclick="removeField(this)" title="remove this row">&times;</div>
		<div class="tcrm-field">
			<!-- <label for="" class="mb5">TeleCRM Field</label> -->
			<input class='tcrm-telecrm-field-input' type="text" placeholder="Enter TeleCRM Field" />
		</div>
		<div class="tcrm-field">
			<!-- <div class="tcrm-d-flex w100p mb5">
				<label>Website name Tag</label>
			</div> -->
			<input type="text" class="tcrm-website-tag-input" disabled placeholder="Enter Your Website name Tag" />
		</div>
	</div>
	<div class="tcrm-w100p tcrm-info-container tcrm-mb5">
		<img src="<?php echo esc_attr( TCRM_ACCOUNT_DETAILS_SRC_FILE . 'assets/info-icon.png' ); ?>"
			class="tcrm-info-img">
		<span></span>
	</div>
</template>

<template id="tcrm-already-integrated-options-template">
	<div class="tcrm-msitem tcrm-no-effect">
		<input type="checkbox" class="tcrm-dropdown-input" style="display:none" />
		<label style="opacity:0.7">
			<span class="title"></span>
			<span class="tcrm-sub-head"></span>
		</label>
		<a href="" title="" target="_blank"><img
				src="<?php echo esc_attr( TCRM_ACCOUNT_DETAILS_SRC_FILE . 'assets/external-icon.png' ); ?>"
				style="height:17px; margin-left:3px;cursor:pointer"></a>
	</div>
</template>