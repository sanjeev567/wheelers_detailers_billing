$(function(){
    $( "#login-form" ).validate({
		rules: {
			email: {
				required: true
			},
			password: {
				required: true
			}
		}
	});
});

$('#login-btn').on('click', function(){

    if ($( "#login-form" ).valid()) {
        var data = $( "#login-form" ).serialize();
        var prefix = $.trim($('#app_url_prefix').val());

        $.ajax({
            type: "post",
            url: prefix+"/login",
            data: data,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.status == "1") {
                    window.location.reload('/');
                }
            },
            error: function (jqXHR) {
                console.log(jqXHR.responseText);
                var response = jqXHR.responseText;

                response = JSON.parse(response);
                $.each(response, function (index, error) {
                  var errorHtml = '<label id="'+index+'-error" class="error" for="'+index+'">'+error+'</label>';

                  if ($('#'+index+'-error').length) {
                    $('#'+index+'-error').remove();
                  }

                  $('[name="'+index+'"]').parent().append(errorHtml);
                  $('[name="'+index+'"]').addClass('error');
                });
            }
        });
    }

    return false;
});
