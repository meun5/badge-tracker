$(document).ready(function () {
    $("#add-req").click(function () {
        var clonedInput = $("#inputReq").clone(),
            clonedLabel = $("label[for="inputReq"]").clone(),
            count = $(this).parent().next(".req").children("input").lenght + 1;

            alert(count);

        $(clonedInput).attr("placeholder", "Requirement #" + count).val("");

        //$(this) = $(this).parent;

        $(this).parent().next(".req").append(clonedInput);

    });
});
