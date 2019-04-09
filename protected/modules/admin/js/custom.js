function change(e){
    var href=$(e).data("href");
    var id = $(e).val();
    var data = {id:id};
    $.ajax({
         async: false,
         type: "POST",
         url: href,
         data : data,
         success: function(data) {
            //$(" .parent").last().remove();
            $(".buttons").before(data);
         },
         dataType:"html"
    });
}