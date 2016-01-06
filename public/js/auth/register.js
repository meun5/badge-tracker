function onLoad() {
    "use strict";
    var override = {
        callback: function (e) {
                if (e.success !== true) {
                    console.info(e);
                    $(".form-signin").parent().add("<p class="red" id="errors"></p>").appendTo($(".form-signin").parent());
                    if (!$.isEmptyObject(e.errors)) {
                        console.log(e.errors);
                        $(e.errors).each(function (n) {
                            $(".form-signin").parent().add("<p class="red" id="errors" + n + ""></p>").appendTo($(".form-signin").parent());
                            String.prototype.capitalizeFirstLetter = function() {
                                return this.charAt(0).toUpperCase() + this.slice(1);
                            }
                            console.log(e.errors[n].item);
                            $("#input" + e.errors[n].item.capitalizeFirstLetter()).parent().addClass("has-error has-feedback");
                            console.log("#input" + e.errors[n].item.capitalizeFirstLetter());
                            $("p#errors" + n).text(e.errors[n].message);
                        });
                    }

                } else {
                    $("#modalContainer").removeAttr("style");
                    $("#successModal").modal("show");
                    setTimeout(function () {
                        $("#successModal").modal("hide");
                        setTimeout(function () {
                            $(location).attr("href", e.url);
                        }, 1000);
                    }, 3000);
                }
            },
            returnType: "json"
        };

    return override;
}
