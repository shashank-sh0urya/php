const TCRM_TOTAL_SLIDES = 2;

const TCRM_WELCOME_SCREEN_ID = '#tcrm-welcome-screen';
const TCRM_PLUGIN_ID = '#tcrm-telecrm-plugin';
const TCRM_PAGE_MAPPINGS_ID = '#tcrm-page-mappings';
const TCRM_ACCOUNT_DETAILS_ID = '#tcrm-account-details';
const TCRM_ADD_MORE_FIELD_ID = '#tcrm-add-more-field';
const TCRM_EDIT_DETAILS_BTN_ID = '#tcrm-edit-details-btn';
const TCRM_FETCH_FORM_BTN_ID = '#tcrm-fetch-forms-btn';
const TCRM_SELECTED_PAGES_NAME_ID = '#tcrm-selected-pages-name';
const TCRM_SUBMIT_BTN_ID = '#tcrm-submit-btn';
const TCRM_BACK_ARROW_ID = '#tcrm-back-arrow';
const TCRM_NO_ENTERPRISE_ERROR_ID = '#tcrm-no-enterprise-error';
const TCRM_NO_AUTHCODE_ERROR_ID = '#tcrm-no-authcode-error';
const TCRM_NO_PAGE_ERROR_ID = '#tcrm-no-page-error';
const TCRM_SELECTED_PAGES_ID = '#tcrm-selected-pages';
const TCRM_WEB_PAGES_ID = '#tcrm-web-pages';
const TCRM_SUBMIT_LOADER_ID = '#tcrm-submit-loader';
const TCRM_FETCH_FORM_LOADER_ID = '#tcrm-fetch-form-loader'
const TCRM_FORM_TEMPLATE_ID = '#tcrm-form-template';
const TCRM_MAPPING_TEMPLATE_ID = '#tcrm-mapping-template';
const TCRM_CANCEL_BTN_ID = '#tcrm-cancel-btn';
const TCRM_CANCEL_BTN_FETCH_ID = '#tcrm-cancel-fetch-btn';
const TCRM_INTEGRATED_PAGES_TEXT = '#tcrm-integrated-pages-text';
const TCRM_INTEGRATED_PAGES_DIVIDER = '#tcrm-integrated-pages-divider';
const TCRM_ALREADY_INTEGRATED_OPTIONS_TEMPLATE_ID = '#tcrm-already-integrated-options-template';
const TCRM_RIGHT_CHEVRON_ID = '#tcrm-right-chevron';
const TCRM_LEFT_CHEVRON_ID = '#tcrm-left-chevron';
const TCRM_ACCOUNT_DETAILS_BTNS = '#tcrm-account-details-btns';
const TCRM_PAGE_LIST_ID = '#tcrm-page-list';
const TCRM_FORM_ID = '#tcrm-form';
const TCRM_URL_MAPPER = '#tcrm-url-mapper';
const TCRM_ADVANCED_SETTING = '#tcrm-advanced-setting';
const TCRM_URL_MAPPINGS = '#tcrm-url-mappings';
const TCRM_URL_MAPPING_FIELD = '#url-mapping-field';


const TCRM_REMOVE_FIELD_CLASS = '.tcrm-removeField';
const TCRM_WEBSITE_TAG_INPUT_CLASS = '.tcrm-website-tag-input';
const TCRM_FIELD_INPUT_CLASS = '.tcrm-telecrm-field-input';
const TCRM_ERROR_MESSAGE_CLASS = '.tcrm-error-message';
const TCRM_LEFT_FIELDS_CLASS = '.tcrm-left-fields';
const TCRM_CAROUSEL_IMG_COVER_CLASS = '.tcrm-carousel-img-cover';
const TCRM_NO_FORMS_FOUND_CLASS = '.tcrm-no-forms-found';
const TCRM_MAPPING_LABEL_COVER_CLASS = '.tcrm-mapping-label-cover';
const TCRM_PAGE_COUNTS_CLASS = '.tcrm-page-counts';
const TCRM_FORM_CLASS = '.tcrm-form';
const TCRM_MAPPING_DIV_CLASS = '.tcrm-mapping-div'
const TCRM_PAGE_NAME_CLASS = '.tcrm-page-name';
const TCRM_FORM_NAME_CLASS = '.tcrm-form-name';
const TCRM_PAGE_URL_CLASS = '.tcrm-page-url';
const TCRM_PAGE_NAME_CONTAINER_CLASS = '.tcrm-page-name-container';
const TCRM_ACCORDION_CLASS = '.tcrm-accordion';
const TCRM_ADD_MORE_FIELD_CLASS = '.tcrm-add-more-field';
const TCRM_WEBSITE_MAPPING_CLASS = '.tcrm-telecrm-website-mapping';
const TCRM_INFO_CONTAINER_CLASS = '.tcrm-info-container';
const TCRM_CHEVRON_CLASS = '.tcrm-chevron';
const TCRM_MAPPING_CONTAINER_CLASS = '.tcrm-mapping-container';
const TCRM_EXISIING_FORM = '.tcrm-existing-form';
const TCRM_NO_NEW_FORM_FOUND_CLASS = '.tcrm-no-new-forms';
const TCRM_DISPLAY_FLEX_CLASS = 'tcrm-d-flex';
const TCRM_DISPLAY_BLOCK_CLASS = 'tcrm-d-block';
const TCRM_DISPLAY_GRID_CLASS = 'tcrm-d-grid';
const TCRM_DISPLAY_NONE_CLASS = 'tcrm-d-none';
const TCRM_DROPDOWN_INPUT_CLASS = '.tcrm-dropdown-input';
const TCRM_DELTE_FORM_CLASS = '.tcrm-delete-form';




const TCRM_INPUT_TAG = 'input';


const TCRM_DISPLAY_NONE_PROPERTY = 'none';
const TCRM_DISPLAY_FLEX_PROPERTY = 'flex';
const TCRM_DISPLAY_BLOCK_PROPERTY = 'block';
const TCRM_DISPLAY_GRID_PROPERTY = 'grid';

const TCRM_ENTERPRISE_ID = '#enterpriseid';
const TCRM_AUTHCODE_ID = '#authcode';

const TCRM_SPAN = 'span';


const TCRM_MAPPINGS = 'mappings';
const TCRM_WEBSITE_PAGE = 'website-page';
const TCRM_ADD_FIELD = 'add-field';
const TCRM_SAME_ID = 'same-id';
const TCRM_URL = '__Form_Url';


var activeSlide = 0;
var existingData = null;
var isEditMappingMode = false;


$ = jQuery;


function slideCarousel(slideToLeft) {
	activeSlide = slideToLeft ? Math.max(activeSlide - 1, 0) : Math.min(activeSlide + 1, TCRM_TOTAL_SLIDES);
	activateCarouselSlide();
	$(TCRM_RIGHT_CHEVRON_ID).css('display', activeSlide === TCRM_TOTAL_SLIDES ? 'none' : 'block');
	$(TCRM_LEFT_CHEVRON_ID).css('display', activeSlide === 0 ? 'none' : 'block');
}


function activateCarouselSlide() {
	$(TCRM_CAROUSEL_IMG_COVER_CLASS).css('transform', `translateX(-${activeSlide * 100}%)`);
}

function switchToPluginDetails() {
	$(TCRM_WELCOME_SCREEN_ID).addClass(TCRM_DISPLAY_NONE_CLASS);
	$(`${TCRM_PLUGIN_ID},${TCRM_SELECTED_PAGES_ID}`).removeClass(TCRM_DISPLAY_NONE_CLASS);
}

function populateSelectedPages(pageTitles) {
	const selectedPages = getSelectedPages().map(page => page.value);
	const textValue = selectedPages.length ? selectedPages.join(',') : 'Select Pages';
	$(TCRM_SELECTED_PAGES_NAME_ID).text(textValue);
}

function getSelectedPages() {
	const selectedPages = $(`input[type=checkbox]:checked:not(#select-all,${TCRM_ADVANCED_SETTING})`);
	return Array.from(selectedPages);
}

function onBackClick() {
	$(`${TCRM_FORM_CLASS}:not(${TCRM_EXISIING_FORM})`).remove();
	switchToAddPage();
}

function deleteForm(e) {
	$(e).parent()?.parent()?.parent()?.parent()?.remove();
}

function handleOptionClick(option) {
	const checkBox = $(option).find("input[type='checkbox']");
	if (!checkBox.is(':disabled')) {
		checkBox.prop('checked', !checkBox.is(':checked'));
	}
	populateSelectedPages();
}

function toggleAdvancedSetting() {
	console.log('here');
	const switchState = $(TCRM_ADVANCED_SETTING).is(":checked");
	if (!switchState) {
		const form = new Form('Url', [], [new Mapping(TCRM_URL, '', 'Url of the lead form')]);
		console.log(form);
		const formDiv = getFormDiv(form);
		console.log('formDiv:', formDiv)
		addUrlMapping(formDiv);
		formDiv.find(TCRM_REMOVE_FIELD_CLASS).remove();
	} else {
		$(`${TCRM_URL_MAPPER} *`).remove();
	}
}

function addUrlMapping(formDiv) {
	const urlMapping = Array.from($(formDiv).find('.mapping-div'))[0];
	$(urlMapping).find(TCRM_REMOVE_FIELD_CLASS).remove();
	$(urlMapping).find('.tcrm-website-tag-input').attr('id', 'url-mapping-field');
	$(formDiv).find('.tcrm-addField').html('+ Add Query Params');
	$(formDiv).find(TCRM_DELTE_FORM_CLASS).remove();
	$(TCRM_URL_MAPPER).append(formDiv);
}

function removeField(e) {
	$(e).parent().parent().remove();
}

function getFormDiv(form) {
	try {
		const formTemplate = $(TCRM_FORM_TEMPLATE_ID);
		const formDiv = document.createElement('div');

		$(formDiv).html(formTemplate.html());
		$(formDiv).find(TCRM_FORM_NAME_CLASS).html(`Form ${form.id}`);
		$(formDiv).find(TCRM_PAGE_NAME_CONTAINER_CLASS).attr('id', form.id);
		let emptyFields = 0;
		form.mappings.forEach(mapping => {
			const mappingDiv = document.createElement('div');
			$(mappingDiv).addClass('mapping-div');
			$(mappingDiv).html($(TCRM_MAPPING_TEMPLATE_ID).html());
			$(mappingDiv).find(TCRM_WEBSITE_TAG_INPUT_CLASS).val(mapping.websiteTag);
			$(mappingDiv).find(TCRM_FIELD_INPUT_CLASS).val(mapping.telecrmField);
			$(mappingDiv).find(`${TCRM_INFO_CONTAINER_CLASS} ${TCRM_SPAN}`).html(mapping.descriptor);
			$(formDiv).find(TCRM_WEBSITE_MAPPING_CLASS).append(mappingDiv);
			emptyFields += !(mapping.telecrmField) ? 1 : 0;
		})
		if (emptyFields) {
			$(formDiv).find(TCRM_LEFT_FIELDS_CLASS).html(emptyFields);
			$(formDiv).find(TCRM_ERROR_MESSAGE_CLASS).removeClass(TCRM_DISPLAY_NONE_CLASS);
		}
		return formDiv;
	} catch (error) {
		console.log(error)
	}

}

function searchPage(e) {
	const searchString = $(e).val();
	Array.from($(`${TCRM_DROPDOWN_INPUT_CLASS}:not(#select-all)`)).forEach(option => {
		if (($(option).attr('id').includes(searchString) || $(option).attr('value').includes(searchString))) {
			$(option).parent().removeClass(TCRM_DISPLAY_NONE_CLASS);
		}
		else {
			$(option).parent().addClass(TCRM_DISPLAY_NONE_CLASS);
		}
	})

}

function selectAll(e) {
	const checkedVal = $(e).children().is(':checked');
	$(e).children().prop('checked', !checkedVal);
	($(`.tcrm-msitem:not(.${TCRM_DISPLAY_NONE_CLASS},#select-all) ${TCRM_DROPDOWN_INPUT_CLASS}`)).prop('checked', !checkedVal);
	populateSelectedPages();
}

function addPagesToForm(form) {
	console.log($(`#${form.id}`), form.pages);
	$(`#${form.id}`).find(`${TCRM_SPAN}:not(.tcrm-addField,.tcrm-left-fields)`).html(form.pages
		.map(page => `<a class="page-url d-contents" href="${page.pageUrl}" title="${page.pageTitle}" target="_blank">${page.pageTitle}</a>`).join(','));
}

function toggleAccordion(id) {
	console.log($(`#${id}`).parent().hasClass('tcrm-hide'), $(`#${id}`));
	if ($(`#${id}`).parent().hasClass('tcrm-hide')) {
		$(`#${id}`).parent().removeClass('tcrm-hide')
		$(`#${id}`).find(TCRM_CHEVRON_CLASS).addClass('tcrm-up-chevron');
	} else {
		$(`#${id}`).parent().addClass('tcrm-hide');
		$(`#${id}`).find(TCRM_CHEVRON_CLASS).removeClass('tcrm-up-chevron');
	}
}

function addField(addMoreField) {
	const mappingDiv = document.createElement('div');
	$(mappingDiv).html($(TCRM_MAPPING_TEMPLATE_ID).html());
	$(mappingDiv).find('input').attr('disabled', false);
	$(addMoreField).parent()
		.siblings(TCRM_WEBSITE_MAPPING_CLASS)
		.append(mappingDiv);
}

async function saveMappings(e) {
	e.preventDefault();
	$(TCRM_SUBMIT_LOADER_ID).removeClass(TCRM_DISPLAY_NONE_CLASS);
	const authcode = $(TCRM_AUTHCODE_ID).val();
	const enterpriseid = $(TCRM_ENTERPRISE_ID).val();
	const forms = getForms();
	if (enterpriseid && authcode && forms && forms.length) {
		await $.ajax({
			type: 'POST',
			url: wp_args.ajax_url,

			data: {
				_ajax_nonce: wp_args.nonce,
				action: "tcrm_save_mappings",
				forms: JSON.stringify(forms),
				enterpriseid: enterpriseid,
				authcode: authcode
			},
			success: async function (response) {
				await fetchExistingMappings();
			}
		});
	}
	$(TCRM_SUBMIT_LOADER_ID).addClass(TCRM_DISPLAY_NONE_CLASS);
}




function getForms() {
	const forms = [];
	Array.from($(TCRM_FORM_CLASS)).forEach((htmlForm, index, htmlForms) => {
		const form = new Form('', [], []);
		form.id = $(htmlForm).find(TCRM_PAGE_NAME_CONTAINER_CLASS).attr('id');
		form.pages = Array.from($(htmlForm).
			find(`${TCRM_PAGE_NAME_CONTAINER_CLASS} ${TCRM_SPAN}:not(.tcrm-left-fields) a`))
			.map(anchorDiv => new Page($(anchorDiv).attr('href'), $(anchorDiv).attr('title')));

		Array.from($(htmlForm).find(`${TCRM_WEBSITE_MAPPING_CLASS} ${TCRM_MAPPING_CONTAINER_CLASS}`)).slice(1)
			.forEach((mapping, index, mappings) => {
				const telecrmField = $(mapping).find(TCRM_FIELD_INPUT_CLASS).val();
				const websiteTag = $(mapping).find(TCRM_WEBSITE_TAG_INPUT_CLASS).val();
				const descriptor = $(mapping).siblings(TCRM_INFO_CONTAINER_CLASS).find(TCRM_SPAN).text();
				form.mappings.push(new Mapping(websiteTag, telecrmField, descriptor));
			});
		forms.push(form);
	});
	return forms;
}

async function fetchFormsOfPages() {
	const isValidated = await validateCredentials();
	if (isValidated) {
		const selectedPages = getSelectedPages();
		const forms = [];
		if (!(selectedPages && selectedPages.length)) {
			$(TCRM_NO_PAGE_ERROR_ID).css('display', 'block');
		} else {
			$(TCRM_NO_PAGE_ERROR_ID).addClass(TCRM_DISPLAY_NONE_CLASS);
			$(TCRM_FETCH_FORM_LOADER_ID).removeClass(TCRM_DISPLAY_NONE_CLASS);
			for (let selectedPage of selectedPages) {
				const pageUrl = selectedPage.id;
				await processPageResponse(pageUrl, forms, selectedPage);
			}
			$(`${TCRM_PAGE_MAPPINGS_ID} ${TCRM_FORM_CLASS}:not(${TCRM_EXISIING_FORM})`).remove();
			const allExistingForms = getForms()?.filter(form => form.id !== 'Url');
			let uniqueId = Math.max(...[...allExistingForms.map(({ id }) => id), ...forms.map(({ id }) => id), 0]) + 1;
			let isNewFormFound = false;
			forms.forEach(form => {
				form.id = uniqueId;
				const existingFormIndex = allExistingForms.findIndex(existingForm => form.isSameForm(existingForm));
				console.log(320)
				allExistingForms.forEach(existingForm => form.filterExistingMappings(existingForm));
				if (existingFormIndex === -1) {
					isNewFormFound = true;
					const formDiv = getFormDiv(form);
					$(TCRM_PAGE_MAPPINGS_ID).append(formDiv);
					addPagesToForm(form);
					uniqueId = uniqueId + 1;
				}
				else {
					addPagesToForm(form);
				}
			});
			if (isNewFormFound) {
				$(TCRM_NO_NEW_FORM_FOUND_CLASS).addClass(TCRM_DISPLAY_NONE_CLASS);
				switchToAddNewMappings();
			} else {
				$(TCRM_NO_NEW_FORM_FOUND_CLASS).removeClass(TCRM_DISPLAY_NONE_CLASS);
			}
			$(TCRM_FETCH_FORM_LOADER_ID).addClass(TCRM_DISPLAY_NONE_CLASS);
		}
	}

}

async function processPageResponse(pageUrl, forms, selectedPage) {
	try {
		const htmlPageResponse = await $.ajax(pageUrl);
		const htmlForms = Array.from($(htmlPageResponse).find('form'));
		for (let htmlForm of htmlForms) {
			const formElements = Array.from($(htmlForm).find("input,select,textarea")
				.filter(":not(input[type='hidden'])")
				.filter(":not(input[type='submit'])"));
			const form = new Form(0, [], []);
			form.mappings = [];
			formElements.forEach(formElement => {
				let descriptor = $(formElement).attr('placeholder');
				if (!descriptor) {
					const inputId = $(formElement).attr('id');
					descriptor = $(htmlForm).find(`label[for="${inputId}"]`)?.text();
				}
				const existingMappingIndex = form.mappings.findIndex(mapping => mapping.websiteTag === $(formElement).attr('name'));
				if (existingMappingIndex !== -1) {
					form.mappings[existingMappingIndex].descriptor += ',' + descriptor;
				} else {
					form.mappings.push(new Mapping(
						$(formElement).attr('name'),
						'',
						descriptor || 'No descriptor found'));
				}
			}
			);
			const alreadyPresentFormIndex = forms.findIndex(existingForm => form.isSameForm(existingForm));
			if (alreadyPresentFormIndex !== -1) {
				const isPageAlreadyPresent = forms[alreadyPresentFormIndex].pages.some(({ pageUrl }) => pageUrl === selectedPage.id);
				if (!isPageAlreadyPresent) { forms[alreadyPresentFormIndex].pages.push({ pageUrl: selectedPage.id, pageTitle: selectedPage.value }); }
			} else {
				console.log(376)
				forms.forEach(existingForm => form.filterExistingMappings(existingForm));
				form.pages.push({ pageUrl: selectedPage.id, pageTitle: selectedPage.value });
				form.id = forms.length;
				forms.push(form);
			}
		}
	} catch (error) {
		console.log(error);
	}
}


function switchToAddNewMappings() {
	$(`${TCRM_FETCH_FORM_LOADER_ID},${TCRM_ACCOUNT_DETAILS_ID}`).addClass(TCRM_DISPLAY_NONE_CLASS);

	$(`${TCRM_PAGE_MAPPINGS_ID},${TCRM_SUBMIT_BTN_ID},${TCRM_BACK_ARROW_ID}`).removeClass(TCRM_DISPLAY_NONE_CLASS);
}

function switchToReadMode() {
	$(`${TCRM_NO_NEW_FORM_FOUND_CLASS},${TCRM_ACCOUNT_DETAILS_BTNS},
	${TCRM_BACK_ARROW_ID},${TCRM_SELECTED_PAGES_ID},${TCRM_CANCEL_BTN_ID},${TCRM_SUBMIT_BTN_ID},${TCRM_REMOVE_FIELD_CLASS},${TCRM_ADD_MORE_FIELD_CLASS},${TCRM_DELTE_FORM_CLASS}`).addClass(TCRM_DISPLAY_NONE_CLASS);
	$(`${TCRM_EDIT_DETAILS_BTN_ID},${TCRM_PAGE_MAPPINGS_ID},${TCRM_ACCOUNT_DETAILS_ID},${TCRM_PLUGIN_ID}`).removeClass(TCRM_DISPLAY_NONE_CLASS)
	$(`${TCRM_PLUGIN_ID} ${TCRM_INPUT_TAG}`).attr('disabled', true);
}

function switchToEditMode() {
	$(`${TCRM_EDIT_DETAILS_BTN_ID},${TCRM_ADD_MORE_FIELD_CLASS}`).addClass(TCRM_DISPLAY_NONE_CLASS);
	$(`${TCRM_CANCEL_BTN_ID},${TCRM_SUBMIT_BTN_ID},${TCRM_REMOVE_FIELD_CLASS},${TCRM_ADD_MORE_FIELD_CLASS},${TCRM_DELTE_FORM_CLASS}`).removeClass(TCRM_DISPLAY_NONE_CLASS);
	$(`${TCRM_PLUGIN_ID} ${TCRM_INPUT_TAG}:not(${TCRM_URL_MAPPING_FIELD})`).attr('disabled', false);
}

function switchToAddPage() {
	const forms = getForms();
	if (!$(TCRM_ENTERPRISE_ID).val()) {
		$(TCRM_PAGE_LIST_ID).addClass('tcrm-disabled');
		$(TCRM_CANCEL_BTN_FETCH_ID).addClass(TCRM_DISPLAY_NONE_CLASS);
	} else {
		$(TCRM_PAGE_LIST_ID).removeClass('tcrm-disabled');
		if (forms.length) { $(TCRM_CANCEL_BTN_FETCH_ID).removeClass(TCRM_DISPLAY_NONE_CLASS); }
	}
	$(`${TCRM_PAGE_MAPPINGS_ID},${TCRM_EDIT_DETAILS_BTN_ID},${TCRM_SUBMIT_BTN_ID},${TCRM_EXISIING_FORM}`).addClass(TCRM_DISPLAY_NONE_CLASS);
	$(`${TCRM_SELECTED_PAGES_ID},${TCRM_PAGE_LIST_ID},${TCRM_ACCOUNT_DETAILS_ID},${TCRM_ACCOUNT_DETAILS_BTNS}`).removeClass(TCRM_DISPLAY_NONE_CLASS);
	$(TCRM_INPUT_TAG).attr('disabled', false);
}

async function validateCredentials() {
	const enterpriseid = $(TCRM_ENTERPRISE_ID).val();
	const authcode = $(TCRM_AUTHCODE_ID).val();
	let isValidCredentials = false;
	if (enterpriseid && authcode) {
		isValidCredentials = await validateAuthcode(enterpriseid, authcode);
		if (!isValidCredentials) {
			renderErrorState();
		}
	}
	if (isValidCredentials) {
		removeErrorState();
	}
	return isValidCredentials;
}

function removeErrorState() {
	$(TCRM_PAGE_LIST_ID).removeClass('tcrm-disabled');
	$(TCRM_NO_AUTHCODE_ERROR_ID).addClass(TCRM_DISPLAY_NONE_CLASS);
	$(TCRM_NO_ENTERPRISE_ERROR_ID).addClass(TCRM_DISPLAY_NONE_CLASS);
}

function renderErrorState() {
	$(TCRM_PAGE_LIST_ID).addClass('tcrm-disabled');
	$(`${TCRM_NO_AUTHCODE_ERROR_ID},${TCRM_NO_ENTERPRISE_ERROR_ID}`).removeClass(TCRM_DISPLAY_NONE_CLASS);
}

async function fetchExistingMappings() {
	$('#tcrm-loader').removeClass(TCRM_DISPLAY_NONE_CLASS);
	$('#tcrm-welcome-screen-1').addClass(TCRM_DISPLAY_NONE_CLASS);
	const data = $.ajax({
		type: 'POST',
		url: wp_args.ajax_url,
		data: {
			_ajax_nonce: wp_args.nonce,
			action: "tcrm_get_mappings",
		},
		success: function (response) {
			const responseData = JSON.parse(`${response}`);
			const forms = responseData.forms
				.map(formJSON => Form.fromJSON(formJSON));
			const credentials = responseData.credentials;
			$(TCRM_FORM_CLASS).remove();
			if (credentials && credentials.enterpriseid) {
				$(TCRM_ENTERPRISE_ID).val(credentials.enterpriseid);
			}
			if (credentials && credentials.authcode) {
				$(TCRM_AUTHCODE_ID).val(credentials.authcode);

			}
			if (forms && forms.length) {
				forms.forEach(form => {
					if (form.mappings && form.mappings.some(mapping => mapping.websiteTag === TCRM_URL)) {
						form.id = 'Url';
						const urlMappingIndex = form.mappings.findIndex(mapping => mapping.websiteTag === TCRM_URL);
						form.mappings.unshift(form.mappings[urlMappingIndex]);
						form.mappings.splice(urlMappingIndex + 1, 1);
						const formDiv = getFormDiv(form);
						addUrlMapping(formDiv);
						$(TCRM_ADVANCED_SETTING).prop('checked', true);
					}
					else {
						const formDiv = getFormDiv(form);
						$(TCRM_PAGE_MAPPINGS_ID).append(formDiv);
						addPagesToForm(form);
					}
				});
				$(TCRM_FORM_CLASS).addClass('tcrm-existing-form')
				switchToPluginDetails();
				switchToReadMode();
			}
			else {
				if (credentials && credentials.enterpriseId) {
					switchToPluginDetails();
				}
				switchToAddPage();
			}
			$('#tcrm-loader').addClass(TCRM_DISPLAY_NONE_CLASS);
			$('#tcrm-welcome-screen-1').removeClass(TCRM_DISPLAY_NONE_CLASS);
		}
	})
}

$(document).ready(async () => {
	await fetchExistingMappings();
	$(TCRM_FORM_ID).on('submit', (e) => {
		e.preventDefault();
		saveMappings(e);
	});

})

class Mapping {
	websiteTag;
	telecrmField;
	descriptor;
	constructor(websiteTag, telecrmField, descriptor) {
		this.websiteTag = websiteTag;
		this.telecrmField = telecrmField;
		this.descriptor = descriptor;
	}
	static fromJSON(mappingObject) {
		const mapping = new Mapping('', '', '');
		if (mappingObject) {
			mapping.websiteTag = mappingObject.websiteTag ?? '';
			mapping.telecrmField = mappingObject.telecrmField ?? '';
			mapping.descriptor = mappingObject.descriptor ?? '';
		}
		return mapping;
	}
}

class Page {
	pageUrl;
	pageTitle;
	constructor(pageUrl, pageTitle) {
		this.pageUrl = pageUrl;
		this.pageTitle = pageTitle;
	}

	static fromJSON(pageObject) {
		const page = new Page('', '');
		if (pageObject) {
			page.pageTitle = (pageObject.pageTitle && pageObject.pageTitle.toString()) ?? '';
			page.pageUrl = (pageObject.pageUrl && pageObject.pageUrl.toString()) ?? '';
		}
		return page;
	}
}


class Form {
	id;
	pages = [];
	mappings = [];
	constructor(id, pages, mappings) {
		this.id = id;
		this.pages = pages;
		this.mappings = mappings;
	}

	isSameForm(form) {
		return this.mappings.every(({ websiteTag }) => form.mappings
			.some(mapping => mapping.websiteTag === websiteTag));
	}

	filterExistingMappings(form) {
		console.log(form.mappings, this.mappings)
		this.mappings = this.mappings.filter(({ websiteTag }) => !form.mappings.some(mapping => mapping.websiteTag === websiteTag))
	}

	static fromJSON(formObject) {
		const form = new Form(0, [], []);
		if (formObject) {
			form.id = formObject.id ?? 0;
			form.mappings = formObject.mappings && formObject.mappings.length ?
				formObject.mappings.map(mapping => Mapping.fromJSON(mapping)) : [];
			form.pages = formObject.pages && formObject.pages.length ?
				formObject.pages.map(page => Page.fromJSON(page)) : [];
		}
		return form;
	}
}

const validateAuthcode = async (enterpriseId, authcode) => {
	try {
		const actions = [{
			type: 'SYSTEM_NOTE',
			text: `Lead Source:Webpage ${window.location.href}`
		}]
		const fields = {
			Name: 'Test-Lead-Wordpress-Verification',
			Phone: '9988774455'
		}
		data = {
			actions,
			fields
		}
		let fetchURL = `https://next-api.telecrm.in/enterprise/${enterpriseId}/wordpress`;
		let response = await fetch(fetchURL, {
			method: "POST",
			mode: "cors",
			cache: "no-cache",
			credentials: "same-origin",
			headers: {
				"Content-Type": "application/json",
				"Authorization": `Bearer ${authcode}`
			},
			redirect: "follow",
			referrer: "no-referrer",
			body: JSON.stringify(data),
		})
		let responseText = await response.text();
		console.log(responseText)
		return responseText === "OK";
	} catch (error) {
		return false;
	}
}

