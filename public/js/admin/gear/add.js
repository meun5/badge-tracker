$(document).ready(function () {
    $("#inputDate").datepicker();
    $("#inputCheckOut").change(function () {
        if ($("#inputCheckOut").prop("checked")) {
            $("#date").fadeIn(400);
            $("#checkoutName").fadeIn(400);
        } else {
            $("#date").fadeOut(400);
            $("#checkoutName").fadeOut(400);
        }
    });
    $("#inputStatus").change(function () {
       if ($("#inputStatus option:selected").val() === "other") {
           $("#inputStatusOther").fadeToggle(400);
       } else {
           $("#inputStatusOther").fadeOut(400);
       }
    });
    $(".form-add").submit(function (e) {
        e.preventDefault();
        
        var url = $(this).prop("action"),
            name = $("#inputName").val(),
            amount = $("#inputAmount option:selected").val(),
            brand = $("#inputBrand").val(),
            status = $("#inputStatus").val(),
            csrf_token = $("#check").val(),
            serial = $("#inputSerial").val(),
            checkout = $("#inputCheckOut").prop("checked");
        
        if (status === "other") {
            var statusOther = $("#inputStatusOther").val();
        }
        
        if (checkout === true) {
            var check_name = $("#inputCheckOutName").val(),
                check_date = $("#inputDate").val();
        }
        
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                inputName: name,
                inputAmount: amount,
                inputBrand: brand,
                inputStatus: status,
                inputStatusOther: statusOther ? statusOther : null,
                csrf_token: csrf_token,
                inputSerial: serial ? serial : null,
                inputCheckOut: checkout ? "on" : undefined,
                inputDate: check_date ? check_date : null,
                inputCheckOutName: check_name ? check_name : null
            },
            success: function (v) {
                if (v.success) {
                    $("#modalContainer").removeAttr("style");
                    $(":input","#addGear").not(":button, :submit, :reset, :hidden, select").val("").removeAttr("checked");
                    $("#date").fadeOut(400);
                    $("#checkoutName").fadeOut(400);
                    $("#successModal").modal("show");
                } else {
                    console.log(v);
                }
            }
        });
    });
});
