$(document).ready(function () {
    function error (errors) {
        if (errors.success !== true) {
            $(".cover-container").add('<p style="color: red;"> Invalid Credentials </p>').appendTo($(".cover-container"));
            $(".form-control").each(function () {
                $(this).parent().attr("class", "form-group has-error has-feedback");
            });
        }
    }
    $("#login").submit(function (e) {
        e.preventDefault();
        var user = $("#inputUser").val(),
            password = $("#inputPassword").val(),
            remember = $("#inputRemember").prop('checked'),
            csrf_name = $("#check").name,
            csrf_token = $("#check").val(),
            url = $(this).attr("action");

        (remember == true) ? remember = 'on' : remember = undefined;

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                    inputUser: user,
                    inputPassword: password,
                    inputRemember: remember,
                    csrf_token: csrf_token
               },
            success: function (response) {
                if (response.success) {
                    $(location).attr('href', response.url);
                } else {
                    error(response);
                }
            }
        });
    });
});
