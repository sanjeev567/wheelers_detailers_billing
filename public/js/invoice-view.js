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
        $("#new-price").val($('#new_item').find(":selected").data("price"));
    });

    $(document).on('click', '.add-item-btn', function (event) {
        event.preventDefault();

        if (!$("#invoice-form").valid()) {
            return false;
        }
        let price = $('#new_item').find(":selected").data("price");
        let quantity = $('#new-quantity').val();
        let discount = $('#new-discount').val();

        datatable.row.add([
            $('#new_item').val(),
            $('#new_item').find(":selected").html(),
            price,
            quantity,
            discount,
            Math.round(((price * quantity) - (price * quantity * discount / 100)) * 100)/100,
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
        createInvoice(false);
    });

    function createInvoice (force) {
        var _token = $('[name="_token"]').val();
        let customer = $('#customer').val();
        let selectedData = datatable.rows().data();
        let newData = [];
        for (i = 0; i < selectedData.length; i++) {
            let temp = selectedData[i].slice();
            temp.pop(); // remove action column
            newData.push(temp);
        }

        var prefix = $.trim($('#app_url_prefix').val());
        let url = prefix + "/generate-invoice";
        let invoiceId = $('#id').val();

        if (invoiceId != '' && invoiceId != undefined) {
            url = prefix + "/invoice-edit";
        }

        $.ajax({
            url: url,
            type: "POST",
            data: { _token: _token, customer: customer, data: newData, force: force, id: invoiceId },
            dataType: "json",
            success: function (response) {
                if (response.status == '1') {
                    window.location.href = prefix + '/invoice/' + response.data;
                } else {
                    if (response.status == '-1' && response.msg != '' && response.msg != undefined) {
                        if (!verifyRemove(response.msg)) {
                            return false;
                        } else {
                            createInvoice(true);
                        }
                    } else {
                        showFailureAlert('Unable to generate invoice. Please try again later');
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error in creating invoice');
            }
        });
    }
});