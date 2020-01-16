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

$(function(){
    $(document).on('click', '.upload-invoice-image-btn', function () {
        $("#uploadModal").modal('show');
        $("#current-invoice-id").val($(this).data('id'));
        refreshInvoiceImageList();
    });

    $('#uploadModal').on('hidden.bs.modal', function () {
        $("#current-invoice-id").val('');
        $('#invoice-images-wrapper').html('');
    });

    $(document).on('click', '.delete-invoice-image', function () {
        if (!verifyRemove('Are you sure you want to delete this invoice image?')) {
            return false;
        }
        let prefix = $.trim($('#app_url_prefix').val());
        let id = $(this).data('id');
        let ele = this;
        let _token = $('[name="_token"]').val();

        $.ajax({
            type: "post",
            url: prefix + "/delete-invoice-image",
            data: {
                _token: _token,
                id: id
            },
            dataType: "json",
            success: function (response) {
                if (response.status == '1') {
                    showSuccessAlert('Image deleted succssfully');
                    $(ele).parent().remove();
                } else {
                    showFailureAlert('Unable to delete the invoice image. Please try again later');
                }
            },
            error: function (jqXHR) {
                console.log('failure response received');
                showFailureAlert('Unable to delete the invoice image. Please try again later');
            }
        });
    });

    $('#btn_upload').click(function () {
        var prefix = $.trim($('#app_url_prefix').val());
        var invoiceId = $("#current-invoice-id").val();
        var _token = $('[name="_token"]').val();

        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('image', files);
        fd.append('invoiceId', invoiceId);
        fd.append('_token', _token);

        // AJAX request
        $.ajax({
            url: prefix + "/upload-invoice-image",
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != 0) {
                    // Show image preview
                    refreshInvoiceImageList();
                } else {
                    alert('file not uploaded');
                }
            }
        });
    });
});


function refreshInvoiceImageList() {
    var prefix = $.trim($('#app_url_prefix').val());
    var invoiceId = $("#current-invoice-id").val();
    var _token = $('[name="_token"]').val();

    $.ajax({
        type: "post",
        url: prefix + "/get-invoice-images",
        data: {
            _token: _token,
            invoiceId: invoiceId
        },
        dataType: "json",
        success: function (response) {
            if (response.status == '1') {
                let images = response.data;
                let basePath = $("#user_doc_image_path").val();
                let html = '';
                $.each(images, function (id, image) {
                    html += '<div class="user-docs-images-wrapper">' +
                        '<img  class="user-docs-images" alt="' + basePath + '"' +
                        'src="' + basePath + '/' + image + '"' +
                        'onerror="this.onerror=null; this.src=\'' + prefix + '/img/not_found.png' + '\' ">' +
                        '<span class="close delete-invoice-image" data-id="' + id + '">x</span></div>';
                });
                $('#invoice-images-wrapper').html(html);
            } else {
                showFailureAlert('Unable to retrieve the invoice images. Please try again later');
            }
        },
        error: function (jqXHR) {
            console.log('failure response received');
            showFailureAlert('Unable to retrieve the invoice images. Please try again later');
        }
    });
}