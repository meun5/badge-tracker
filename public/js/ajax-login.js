$(document).ready(function () {
    function error (errors) {
        if (errors.success !== true) {
            $(".image-holder").prop('style', "display: none;");
            $(".modal-footer").add('<p style="color: red;"> Invalid Credentials </p>').appendTo($(".modal-footer"));
            $(".form-control").each(function () {
                $(this).parent().attr("class", "form-group has-error has-feedback");
            });
        }
    }
    $(".form-control").focusout(function () {
        $(this).parent().attr("class", "form-group");
    });
    $("#login").submit(function (e) {
        e.preventDefault();
        var user = $("#inputUser").val(),
            password = $("#inputPassword").val(),
            remember = $("#inputRemember").prop('checked'),
            csrf_name = $("#check").name,
            csrf_token = $("#check").val(),
            url = $(this).attr("action"),
            domain = $(".ajax-login").attr('data-url');

        (remember == true) ? remember = 'on' : remember = undefined;

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                $(".modal-footer").add('<span style="height: 50px; width: 50px;" class="image-holder"><img src="' + domain + '/images/auth/beforeSend.svg" height="50px;" width="50px;" alt="Login Image" class="login-image"></span>').appendTo($(".modal-footer"));
                $(".image-holder").prop("style", "display: inline;");
            },
            data: {
                    inputUser: user, 
                    inputPassword: password, 
                    inputRemember: remember, 
                    csrf_token: csrf_token
               },
            success: function (response) {
                if (response.success) {
                    $(".login-image").prop('src', domain + "/images/auth/success.svg");
                    setTimeout(function () {
                        $("#loginModal").modal("hide");
                        setTimeout(function () {
                            location.reload();
                        }, 500);
                    }, 3000);
                } else {
                    error(response);
                }
            }
        });
    });
});
