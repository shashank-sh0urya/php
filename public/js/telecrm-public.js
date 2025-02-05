let mappings = {};
addEventListener("load", async () => {
    getCookie("page_url");
    setTimeout(() =>
        setCookie("page_url", window.location.href, 1), 3000)
    if (!JSON.parse(wp_args.is_supported_form_plugin_active)) {
        mappings = await getMappings();
        listenFormSubmit();
    }
});

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let result = "";
    const cookieName = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        console.log(c);
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(cookieName) == 0) {
            result = c.substring(cookieName.length, c.length);
        }
    }
    console.log(result)
    return result;
}

function listenFormSubmit() {
    jQuery(document).on('submit', async (e) => {
        const fields = {};
        Object.keys(mappings).forEach(websiteTag => {
            const elem = jQuery(e.target)
                .find(`input[name="${websiteTag}"],select[name="${websiteTag}"],textarea[name="${websiteTag}"]`)
            const value = processValue(elem);
            if (value) {
                fields[mappings[websiteTag]] = value;
            }

        })
        if (Object.keys(fields).length) {
            if (jQuery(e.target).attr('name')) {
                fields['Form name'] = jQuery(e.target).attr('name');
            }
            // await sendData(fields);
        }
    })
}

function processValue(element) {
    const type = element.attr('type');
    let value = null;
    switch (type) {
        case 'radio': {
            if (element.is(':checked'))
                value = element.val();
            break;
        }
        case 'checkbox': {
            Array.from((element).filter(':checked'))
                .forEach(elem => {
                    value = value ? value + ',' + elem.value : elem.value;
                })
            break;
        }
        case 'date': {
            elemValue = element.val();
            value = Date.parse(elemValue) ? Date.parse(elemValue) : elemValue;
            break;
        }
        default: {
            value = element.val();
            break;
        }
    }
    return value;
}

async function getLastLead(secretKey) {
    try {
        const data = jQuery.ajax({
            type: 'GET',
            url: `${wp_args.lead_url}${secretKey}`,
            success: function (response) {
                let result = response[0].reduce((prevVal, currVal) => {
                    if (!prevVal[currVal.response_code]) {
                        prevVal[currVal.response_code] = { capturedOn: currVal.date_field };
                    }
                    prevVal[currVal.response_code][currVal.lead_field] = currVal.value;
                    return prevVal;
                }, {})
                console.log(result);
            }
        })
    } catch (error) {
        console.log(error);
    }
}

async function getMappings() {
    let response = {};
    try {
        await jQuery.ajax({
            type: 'GET',
            url: `${wp_args.mappings_url}`,
            success: function (data) {
                response = data;
                console.log(response);
            }
        })
    } catch (error) {
        console.log(error)
    }
    return response;
}

async function sendData(fields) {
    try {
        const data = jQuery.ajax({
            type: 'POST',
            url: wp_args.lead_url,
            data: {
                fields,
                form_url: window.location.href
            },
            success: function (response) {
                console.log(response);
            }
        })
    } catch (error) {
        console.log(error);
    }
}

async function setPageUrl() {
    try {
        const data = jQuery.ajax({
            type: 'POST',
            url: wp_args.page_url,
            data: {
                page_url: window.location.href
            },
            success: function (response) {
                console.log(response);
            }
        })
    } catch (error) {
        console.log(error);
    }
}
