$(document).bind("ajaxSend", function () {
    $('#loader').show();
}).bind("ajaxComplete", function () {
    $('#loader').hide();
});

$(function () {
    $('.custom-alert').on('fadein', function () {
        window.setTimeout(function () {
            $(".custom-alert").fadeOut();
        }, 2500);
    });
});

/**
 * Function to show success alert
 * @param {string} msg
 */
function showSuccessAlert(msg) {
    $('.alert-success .custom-alert-content').html(msg);
    $('.alert-success.custom-alert').fadeIn();
    $('.custom-alert').trigger('fadein');
}

/**
 * Function to show failure alert
 * @param {string} msg
 */
function showFailureAlert(msg) {
    $('.alert-danger .custom-alert-content').html(msg);
    $('.alert-danger.custom-alert').fadeIn();
    $('.custom-alert').trigger('fadein');
}

/**
 * Function to handle back end validation errors
 * @param {object} response
 */
function handleValidationErrors(response) {
    $("html, body").animate({
        scrollTop: 0
    }, "slow");
    if (response.data != undefined || response.data != null) {
        $.each(response.data, function (index, error) {
            var errorHtml = '<label id="' + index + '-error" class="error" for="' + index + '">' + error + '</label>';

            if ($('#' + index + '-error').length) {
                $('#' + index + '-error').remove();
            }

            $('[name="' + index + '"]').parent().append(errorHtml);
            $('[name="' + index + '"]').addClass('error');
        });
    } else {
        showFailureAlert('Some Error Occured. Please try again later');
    }
}

function handleErrorResponse(jqXHR) {
    $("html, body").animate({
        scrollTop: 0
    }, "slow");
    console.log('failure response received');
    console.log(jqXHR.responseText);
    showFailureAlert('Some Error Occured. Please try again later');
}

/**
 * Funtion to verify the removal of the resuorce
 * @param {string} msg
 */
function verifyRemove(msg){
    var confirmation = confirm(msg);
    if(confirmation){
        return true;
    }
    else{
        return false;
    }
}