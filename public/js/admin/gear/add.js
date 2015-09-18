$(function () {
    $("#inputDate").datepicker();
});

$(document).ready(function () {
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
});
