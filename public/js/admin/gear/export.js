$(document).ready(function () {
    function sendAjax(type, email) {
         var url = $("email-form").prop("action"),
             csrf = $("#check").val(),
             domain = $(".js-container").attr("data-url"),
             id = $("#check").attr("submit-id"),

             post = {
                id: $("#check").attr("submit-id"),
                email: (!email) ? null : email,
                csrf_token: csrf,
                download: (type == "email") ? "email" : "file"
             };

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: post,
            beforeSend: function () {
                if ($(".transit-image").length <= 0) {
                    $(".image-holder").add("<img src="" + domain + "/images/auth/beforeSend.svg" height="50px;" width="50px;" alt="Transit Image" class="transit-image">").appendTo($(".image-holder"));
                    $(".image-holder").prop("style", "display: inline;");
                }
            },
            success: function (response) {
                if (response.success) {
                    $(".transit-image").prop("src", domain + "/images/auth/success.svg");
                    setTimeout(function () {
                        $("#reportModal").modal("hide");
                        setTimeout(function () {
                            console.log(response.callback);
                            $.fileDownload(response.callback);
                            $(".transit-image").remove();
                        }, 500);
                    }, 2000);
                } else {
                    console.log(response);
                }
            }
        });
    }
    $("#report-modal").removeAttr("style");
    $(".gen-report").click(function () {
        var id = $(this).prop("id");
        $("#check").attr("submit-id", id);
        $("#reportModal").modal("show");
    });
    $(".download").click(function (e) {
        e.preventDefault();
        sendAjax("file");
    });
    $(".email-form").submit(function (e) {
        e.preventDefault();
        sendAjax("email", $("#inputEmail").val());
    });
});
