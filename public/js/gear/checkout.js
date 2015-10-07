$(document).ready(function () {
    $("#inputDate").datepicker();
    $("#dateContainer").removeAttr('style');
    $("#successContainer").removeAttr('style');

    $("#checkoutGear").submit(function (e) {
        var url = $(this).attr("action"),
           date = $("#inputDate").val(),
           name = $("#inputCheckOutName").val(),
           csrf = $("#check").prop("value");

        e.preventDefault();

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                inputDate: date,
                inputCheckOutName: name,
                csrf_token: csrf
            },
            success: function (v) {
                if (v.success) {
                    $(':input','#addGear').not(':button, :submit, :reset, :hidden, select').val('');
                    $("#successModal").modal("show");
                } else {
                    console.log(v);
                }
            }
        })
    });
    $(".inline-span").click(function () {
        $("#inDate").datepicker();
        var id = $(this).prop('id'),
            csrf = $("#check").prop("value");

        $("#dateModal").modal("show");

        $("#inDateForm").submit(function (e) {
            e.preventDefault();
            var inDate = $("#inDate").val(),
                inName = $("#inName").val();

            $.ajax({
                url: $(".form-add").attr('action'),
                type: "POST",
                dataType: "json",
                data: {
                    inputDateIn: inDate,
                    inputCheckInName: inName,
                    id: id,
                    csrf_token: csrf
                },
                success: function (v) {
                    if (v.success) {
                        $("#dateModal").modal("hide");
                        $("body").delay(2000);
                        $("#successModal").modal("show");
                    } else {
                        console.log(v);
                    }
                }
            });
        });
    });
    $("#modalDismiss").click(function () {
        $("body").delay(6000);
        location.reload();
    });
});
