$(function () {
    var datatable = $('#item-list-table').DataTable({
        select: true
    });

    $('.advisor-custom-select').select2({
        containerCssClass: ':all:',
        placeholder: function () {
            $(this).data('placeholder');
        }
    });

    $("#invoice-form").validate({
        rules: {
            name: {
                required: true,
                maxlength: 100
            },
            quantity: {
                required: true
            },
        },
        errorPlacement: function (error, element) {
            $(element).parent().append(error);
        }
    });

    $('#new_item').on('change', function () {
        $("#selling_price").val($('#new_item').find(":selected").data("price"));
    });

    $(document).on('click', '.add-item-btn', function (event) {
        event.preventDefault();

        if (!$("#invoice-form").valid()) {
            return false;
        }
        let price = $('#new_item').find(":selected").data("price");
        let quantity = $('#new-quantity').val();
        let buying_price = $('#buying_price').val();

        datatable.row.add([
            $('#new_item').val(),
            $('#new_item').find(":selected").html(),
            buying_price,
            price,
            quantity,
            Math.round(price * quantity * 100)/100,
            '<button class="btn btn-danger delete_btn">Remove</button>'
        ]).draw(false);
    });

    $('#item-list-table tbody').on('click', '.delete_btn', function () {
        datatable
            .row($(this).parents('tr'))
            .remove()
            .draw();
    });

    $('#generate_invoice_btn').click(function (event) {
        event.preventDefault();
        let customer = $('#customer').val();
        let selectedData = datatable.rows().data();
        let newData = [];
        let formData = new FormData($('#invoice-form')[0]);
        for (i = 0; i < selectedData.length; i++) {
            let temp = selectedData[i].slice(); // clone array
            temp.pop(); // remove action column
            newData.push(temp);
        }
        formData.append('data', JSON.stringify(newData));
        formData.append('customer', customer);

        var prefix = $.trim($('#app_url_prefix').val());
        $.ajax({
            url: prefix + "/add-stock-invoice",
            type: "POST",
            data:formData,
            dataType: "json",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == '1') {
                    window.location.href = prefix + '/stock-invoice-list';
                } else {
                    showFailureAlert('Unable to generate invoice. Please try again later');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error in creating invoice');
            }
        });
    });

    $('.user-docs-images').on('click', function (e) {
        $('#img-cover').fadeIn();
        var img = $(this);
        $(img).addClass('maximize-img');
        $('#img-container').html(img.clone())
            .css({
                'margin-top': '-' + (img.height() / 2 + 100) + 'px',
                'margin-left': '-' + (img.width() / 2 + 100) + 'px'
            }).fadeIn();

        $(img).removeClass('maximize-img');
    });

    $('#img-cover, #img-container').on('click', function () {
        $('#img-cover').fadeOut();
        $('#img-container').fadeOut();
    });

    $('.user-doc-delete-image').on('click', function (e) {
        if (!verifyRemove('Are you sure you want to delete this image permanently?')) {
            return false;
        }
        var prefix = $.trim($('#app_url_prefix').val());
        var id = $(this).data('id');
        var _token = $('[name="_token"]').val();

        $.ajax({
            type: "post",
            url: prefix + "/delete-user-doc-image",
            data: {
                _token: _token,
                id: id
            },
            dataType: "json",
            success: function (response) {
                if (response.status == '1') {
                    showSuccessAlert('Image deleted successfully');
                    window.setTimeout(function () {
                        window.location.reload('/');
                    }, 2000);
                } else {
                    showFailureAlert('Unable to delete the image. Please try again later');
                }
            },
            error: function (jqXHR) {
                console.log('failure response received');
                showFailureAlert('Unable to delete the image. Please try again later');
            }
        });
    });
});