$(document).ready(function() {
    $('#login_button').click(function() {
        $(this).parent().parent().submit();
    });
});