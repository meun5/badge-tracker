$(document).ready(function () {
    $("#inputDate").datepicker();
    $("#inputCheckOut").change(function () {
        $("#date").fadeToggle(400);
        $("#checkoutName").fadeToggle(400);
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
        
        var url = $(this).prop('action'),
            name = $("#inputName").val(),
            amount = $("#inputAmount option:selected").val(),
            brand = $("#inputBrand").val(),
            status = $("#inputStatus").val(),
            csrf_token = $("#check").val(),
            serial = $("#inputSerial").val();
        
        if (status === "other") {
            var statusOther = $("#inputStatusOther").val();
        }
        
        if ($("#inputCheckOut") === "on") {
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
                inputSerial: serial ? serial : null
            },
            success: function (v) {
                if (v.success) {
                    $("#modalContainer").removeAttr('style');
                    $(':input','#addGear').not(':button, :submit, :reset, :hidden, select').val('').removeAttr('checked');
                    $("#successModal").modal("show");
                } else {
                    console.log(v);
                }
            }
        });
    });
});
