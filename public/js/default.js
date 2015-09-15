$(document).ready(function () {
    $("#modalContainer").removeAttr('style');
    $(".login").click(function (e) {
        e.preventDefault();
        $("#loginModal").modal();
    });
});
