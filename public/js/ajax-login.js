function getDomain() {return }
function onLoad() {
    "use strict";

    var override = {
        beforeSend: function () {
                $(".modal-footer").add("<span style="height: 50px; width: 50px;" class="image-holder"><img src="" + $(".ajax-login").attr("data-url") + "/images/auth/beforeSend.svg" height="50px;" width="50px;" alt="Login Image" class="login-image"></span>").appendTo($(".modal-footer"));
                $(".image-holder").prop("style", "display: inline;");
            },
        callback: function (e) {
                if (e.success) {
                    $(".login-image").prop("src", $(".ajax-login").attr("data-url") + "/images/auth/success.svg");
                    setTimeout(function () {
                        $("#loginModal").modal("hide");
                        setTimeout(function () {
                            location.reload();
                        }, 500);
                    }, 3000);
                } else {
                    $(".image-holder").prop("style", "display: none;");
                    $(".modal-footer").add("<p style="color: red;"> Invalid Credentials </p>").appendTo($(".modal-footer"));
                    $(".form-control").each(function () {
                        $(this).parent().attr("class", "form-group has-error has-feedback");
                    });
                }
            },
            returnType: "json"
        };

    return override;
}

$(document).ready(function () {
    $(".login").click(function (e) {
        $("#modalContainer").removeAttr("style");
        e.preventDefault();
        $("#loginModal").modal("show");
    });
    $(".form-control").focusout(function () {
        $(this).parent().attr("class", "form-group");
    });
});
