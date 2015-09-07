$(document).ready(function () {

    function error (errors) {
        if (errors.success !== true) {
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
            remember = $("#inputRemember").val(),
            csrf_name = $("#check").name,
            csrf_token = $("#check").val(),
            url = $(this).attr("action");

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
                    $("#loginModal").modal("hide");
                    window.location.reload();
                } else {
                    error(response);
                }
            }
        });
    });
});