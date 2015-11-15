if("undefined"==typeof jQuery)throw new Error("form.js requires jQuery");
+function(a){"use strict";var b=a.fn.jquery.split(" ")[0].split(".");if(b[0]<2&&b[1]<9||1==b[0]&&9==b[1]&&b[2]<1)throw new Error("form.js requires jQuery version 1.9.1 or higher")}(jQuery)

function doPost(action, data, type, dataType, callback, beforeSend) {
    'use strict';

    $.ajax({
        url: action,
        type: type,
        dataType: dataType,
        beforeSend: beforeSend,
        data: data,
        success: callback
    });
}
$(document).ready(function () {
    $("form.doPost").submit(function (e) {
        e.preventDefault();

        console.info(e);

        var defaults = {
                action: $(this).attr("action"),
                data: false,
                type: "POST",
                dataType: "text",
                beforeSend: null,
                callback: function (e) {
                    if (e.success) {
                        $(location).attr("href", e.url);
                    } else {
                        console.warn(e);
                    }
                }
            };

        var override = onLoad(), sendOut = {};
        $(this).find("input, textarea").each(function (e) {
            console.info(this);
            if (this.type == "checkbox") {
                sendOut[this.name] = $(this).prop("checked");
            } else {
                sendOut[this.name] = this.value;
            }
        });
        console.log(sendOut);

        if (!$.isEmptyObject(sendOut)) {
            defaults.data = sendOut;
        } else {
            throw new Error('No fields found!');
        }

        if ($.isFunction(override.callback)) {
            defaults.callback = override.callback;
        }

        if ($.isFunction(override.beforeSend)) {
            defaults.beforeSend = override.beforeSend;
        }

        if (typeof override.returnType !== 'undefined') {
            switch (override.returnType) {
                case "url":
                    defaults.dataType = "text";
                    break;
                case "html":
                    defaults.dataType = "html";
                    break;
                default:
                    defaults.dataType = "json";
                    break;
            }
        }

        console.info(defaults);

        doPost(defaults.action, defaults.data, defaults.type, defaults.dataType, defaults.callback, defaults.beforeSend);
    });
});
