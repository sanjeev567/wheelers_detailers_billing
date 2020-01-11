$('#customer-list-table').DataTable({
    order: [[0, "desc"]],
    select: true,
    dom: 'Bfrtip',
    buttons: [
        $.extend( true, {}, {
            extend: 'excelHtml5', footer: true,
            messageTop: $('#partyName').html()
        } )
    ],
});

$('#invoice-list-table').DataTable({
    order: [[0, "desc"]],
    select: true,
    // dom: 'Bfrtip',
    // buttons: [
    //     $.extend( true, {}, {
    //         extend: 'excelHtml5', footer: true,
    //         messageTop: $('#partyName').html()
    //     } )
    // ],
});

$(document).on('click', '.invoice-cancel-btn', function () {
    if(!verifyRemove('Are you sure you want to cancel this invoice?')){
        return false;
    }
    var prefix = $.trim($('#app_url_prefix').val());
    var id = $(this).data('id');
    var _token = $('[name="_token"]').val();

    $.ajax({
        type: "post",
        url: prefix + "/cancel-invoice",
        data: {
            _token:_token,
            id:id
        },
        dataType: "json",
        success: function (response) {
            if (response.status == '1') {
                showSuccessAlert('invoice canceled successfully');
                window.setTimeout(function () {
                    window.location.reload('/');
                }, 1200);
            } else {
                showFailureAlert('Unable to cancel the invoice. Please try again later. Msg: '+response.msg);
            }
        },
        error: function (jqXHR) {
            console.log('failure response received');
            showFailureAlert('Unable to cancel the invoice. Please try again later');
        }
    });
});

$(document).on('click', '.delete-customer-btn', function () {
    if(!verifyRemove('Are you sure you want to delete this customer?')){
        return false;
    }
    var prefix = $.trim($('#app_url_prefix').val());
    var id = $(this).data('id');
    var _token = $('[name="_token"]').val();

    $.ajax({
        type: "post",
        url: prefix + "/delete-customer",
        data: {
            _token:_token,
            id:id
        },
        dataType: "json",
        success: function (response) {
            if (response.status == '1') {
                showSuccessAlert('customer deleted successfully');
                window.setTimeout(function () {
                    window.location.reload('/');
                }, 1200);
            } else {
                showFailureAlert('Unable to delete the customer. Please try again later');
            }
        },
        error: function (jqXHR) {
            console.log('failure response received');
            showFailureAlert('Unable to delete the customer. Please try again later');
        }
    });
});