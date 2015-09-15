$(document).ready(function () {
    $("#addCompBadge").click(function (e) {
        var inputSelect = $('#selectCompBadge').clone();

        $('#inputCompBadge').append(inputSelect);
    });
    $("#addIncBadge").click(function (e) {
        var $div = $('select[name^="inputIncBadge"]:last'),
            num = parseInt($div.prop("name").match(/\d+/g), 10) + 1,
            $clone = $div.clone().prop('name', 'inputIncBadge[' + num + ']').prop('id', 'selectIncBadge[' + num + ']');

        $('#inputIncBadge').append($clone);
    });
    $(document).on('change', '.inc-badge', function (e) {
        var name = $(this).attr("name"),
            url = $("#addScout").attr("action"),
            csrf_name = $("#check").name,
            csrf_token = $("#check").val();

        console.log(e);

        $.ajax({
            url: url + "/badges",
            type: "POST",
            dataType: "json",
            data: {
                name: name,
                csrf_token: csrf_token
            },
            success: function (v) {
                alert(v);
            }
        });
    });
});
