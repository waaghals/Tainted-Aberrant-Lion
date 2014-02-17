$(document).on( "click", ".AllReviews", function() {
    $('#blackout').fadeIn();
});
$(document).ready(function() {
    $('#blackout').click(function() {
        $(this).fadeOut();
        GMapsArray['gMap'].setZoom(9);
        infowindow_gMap.close();
    });
});