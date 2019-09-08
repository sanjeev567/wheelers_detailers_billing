$(function () {
    $("#item-form").validate({
        rules: {
            name: {
                required: true
            },
            price: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            error.insertAfter($(element).parents('.input-group'));
        }
    });

    $('#add-item-btn').on('click', function (event) {
        event.preventDefault();
        if ($("#item-form").valid()) {
            var data = $("#item-form").serialize();
            var prefix = $.trim($('#app_url_prefix').val());

            $.ajax({
                type: "post",
                url: prefix + "/add-item",
                data: data,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.status == '1') {
                        showSuccessAlert('Item Added Successfully');
                        window.setTimeout(function () {
                            window.location.reload('/');
                        }, 2000);
                    } else {
                        showFailureAlert('Unable to add the item. Please try again later');
                    }
                },
                error: function (jqXHR) {
                    console.log(jqXHR.responseText);
                    showFailureAlert('Unable to add the item. Please try again later');
                }
            });
        } else {
            $('label.error').css('margin-top', '-29px');
            $('label.error').css('display', 'block');
        }

        return false;
    });

});