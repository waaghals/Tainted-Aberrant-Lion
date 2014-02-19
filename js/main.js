$(document).on( "click", ".AllReviews", function() {
    $("#blackout_content").html('');
    $('#blackout').fadeIn();
    $.post("/ajax/getReviews/", { instantie: $(this).attr("instantie") }, function(data) {
        $("#blackout_content").html('<div style="padding:10px;">' + data + '</data>');
    });
});
$(document).ready(function() {
    $('#blackout').click(function() {
        if(event.target.id === "blackout") {
            $(this).fadeOut();
            GMapsArray['gMap'].setZoom(9);
            infowindow_gMap.close();
        }
    });
});