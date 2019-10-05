(function ($) {
    'use strict';
    /*==================================================================
        [ Daterangepicker ]*/
    try {
        $('.js-datepicker').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoUpdateInput": false,
            locale: {
                format: 'DD/MM/YYYY'
            },
        });

        var myCalendar = $('.js-datepicker');
        var isClick = 0;

        $(window).on('click', function () {
            isClick = 0;
        });

        $(myCalendar).on('apply.daterangepicker', function (ev, picker) {
            isClick = 0;
            $(this).val(picker.startDate.format('YYYY/MM/DD'));

        });

        $('.js-btn-calendar').on('click', function (e) {
            e.stopPropagation();

            if (isClick === 1) isClick = 0;
            else if (isClick === 0) isClick = 1;

            if (isClick === 1) {
                myCalendar.focus();
            }
        });

        $(myCalendar).on('click', function (e) {
            e.stopPropagation();
            isClick = 1;
        });

        $('.daterangepicker').on('click', function (e) {
            e.stopPropagation();
        });


    } catch (er) { console.log(er); }
    /*[ Select 2 Config ]
        ===========================================================*/

    try {
        var selectSimple = $('.js-select-simple');

        selectSimple.each(function () {
            var that = $(this);
            var selectBox = that.find('select');
            var selectDropdown = that.find('.select-dropdown');
            selectBox.select2({
                dropdownParent: selectDropdown
            });
        });

    } catch (err) {
        console.log(err);
    }


})(jQuery);


$(function () {
    $("#customer-form").validate({
        rules: {
            name: {
                required: true
            },
            mobile: {
                required: true
            },
            email: {
                email: true
            },
            state:{
                required:true
            }
        },
        errorPlacement: function (error, element) {
            error.insertAfter($(element).parents('.input-group'));
        }
    });

    $('#add-customer-btn').on('click', function (event) {
        event.preventDefault();
        if ($("#customer-form").valid()) {
            var data = $("#customer-form").serialize();
            var prefix = $.trim($('#app_url_prefix').val());

            $.ajax({
                type: "post",
                url: prefix + "/add-customer",
                data: data,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.status == '1') {
                        showSuccessAlert('Customer Added Successfully');
                        window.setTimeout(function () {
                            window.location.href = prefix+'/?cust='+(response.data.id || $('#id').val());
                        }, 500);
                    } else {
                        showFailureAlert('Unable to add the customer. Please try again later');
                    }
                },
                error: function (jqXHR) {
                    console.log(jqXHR.responseText);
                    showFailureAlert('Unable to add the customer. Please try again later');
                }
            });
        } else {
            $('label.error').css('margin-top', '-29px');
            $('label.error').css('display', 'block');
        }

        return false;
    });

});