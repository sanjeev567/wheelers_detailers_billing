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

    handleInvoiceTypeChange();

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
        $.ajax({
            url: prefix + "/generate-invoice",
            type: "POST",
            data: { _token: _token, customer: customer, data: newData },
            dataType: "json",
            success: function (response) {
                if (response.status == '1') {
                    window.location.href = prefix + '/invoice/' + response.data;
                } else {
                    if (response.msg != '' && response.msg != undefined) {
                        showFailureAlert(response.msg);
                    } else {
                        showFailureAlert('Unable to generate invoice. Please try again later');
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error in creating invoice');
            }
        });
    });

    $('#invoice_type').on('change', handleInvoiceTypeChange);

    function handleInvoiceTypeChange() {
        var type = $('#invoice_type').val();
        $('#new_item option').removeAttr('disabled');
        $('#new_item option[data-type!="'+type+'"]').prop('disabled', true);

        $("#new_item").val(null).trigger("change");
        $("#new_item").select2("destroy");
        $('#new_item').select2({
            containerCssClass: ':all:',
            placeholder: function () {
                $(this).data('placeholder');
            }
        });
    }
});