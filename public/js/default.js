$(document).ready(function () {
    $(".login").click(function (e) {
        $("#modalContainer").removeAttr('style');
        e.preventDefault();
        $("#loginModal").modal("show");
    });
});
