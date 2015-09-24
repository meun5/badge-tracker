$(document).ready(function () {
   $(".checkouturl").click(function () {
       var url = window.location.href,
           id = $(this).prop('id'),
           csrf = $(".post").prop('id');

       $.ajax({
           url: url,
           type: "POST",
           dataType: "json",
           data: {
               id: id,
               csrf_token: csrf
           },
           success: function (v) {
               if (v.success) {
                   console.info(v.success);
                   console.log(v);
                   //$(location).attr('href', v.url);
               } else {
                   console.log(v);
               }
           }
       });
   });
});
