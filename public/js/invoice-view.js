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
            $('#new_item').find(":selected").html(),
            price,
            quantity,
            discount,
            (price * quantity) - discount,
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

        var selectedData = datatable.rows().data();
        let newData = [];
        for (i = 0; i < selectedData.length; i++) {
            selectedData[i].pop(); // remove action column
            newData.push(selectedData[i]);
        }
        console.log(newData);
        jsonData = JSON.stringify({ data: newData });
        console.log(jsonData);

        var prefix = $.trim($('#app_url_prefix').val());
        $.ajax({
            url: prefix + "/delete-service/generate-invoice",
            type: "POST",
            data: jsonData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (data) {
                data.forEach(function (e) {
                    console.log(e);
                })
                console.log(data);
                alert("sheet created successfully");

                $('#btnSel').text('create');
                $('#btnSel').attr('disabled', false);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error in creating invoice');
            }
        });
    });
});