$('#item-list-table').DataTable({
    select: true,
    dom: 'Bfrtip',
    buttons: [
        $.extend( true, {}, {
            extend: 'excelHtml5', footer: true,
            messageTop: $('#partyName').html()
        } )
    ],
});

$(document).on('click', '.delete-item-btn', function () {
    if(!verifyRemove('Are you sure you want to delete this item?')){
        return false;
    }
    var prefix = $.trim($('#app_url_prefix').val());
    var id = $(this).data('id');
    var _token = $('[name="_token"]').val();

    $.ajax({
        type: "post",
        url: prefix + "/delete-item",
        data: {
            _token:_token,
            id:id
        },
        dataType: "json",
        success: function (response) {
            if (response.status == '1') {
                showSuccessAlert('Item deleted successfully');
                window.setTimeout(function () {
                    window.location.reload('/');
                }, 1200);
            } else {
                showFailureAlert('Unable to delete the item. Please try again later');
            }
        },
        error: function (jqXHR) {
            console.log('failure response received');
            showFailureAlert('Unable to delete the item. Please try again later');
        }
    });
});