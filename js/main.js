$(document).ready(function() {
    $('#login_button').click(function() {
        $(this).parent().parent().submit();
    });
    $('#register_button').click(function() {
        $(this).parent().parent().submit();
    });
});

$(document).keypress(function(e) {
    if(e.which == 13) {
        if($('#register_container').length !== 0)
            $('#register_container').children()[0].submit();
        if($('#login_container').length !== 0)
            $('#login_container').children()[0].submit();
    }
});