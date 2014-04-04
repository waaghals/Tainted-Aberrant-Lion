$(document).ready(function() {
    $('#login_button').click(function() {
        $(this).parent().parent().submit();
    });
    $('#register_button').click(function() {
        $(this).parent().parent().submit();
    });
    $('#management_cancel').click(function() {
        window.location = location.href;
    });
    $('#management_save').click(function() {
        $(this).parent().parent().submit();
    });
    $('#mylocation_add').click(function() {
        $('#blackout').fadeIn();
        $('#blackout_content').fadeIn();
    });
    
    $('#blackout').click(function(e) {
        console.log($(event.target));
        if($(event.target).is($('#blackout'))) {
            $('#blackout').fadeOut();
        }else{
            e.preventDefault(); 
        }
    });
    
    $('#create_location').click(function() {
        $(this).hide();
        console.log(';test');
        $.post( "/Ajax/CreateLocation", $( "[name='create_location_form']" ).serialize(), function(data) {
            console.log(data);
            if(data == "succes") {
                $('#blackout').fadeOut(function() {
                    location.reload();
                });
            }else{
                $('#create_location').show();
                $('#addLocationError').show().children().first().html(data);
            }
        });
    });
});

$(document).keypress(function(e) {
    if(e.which == 13) {
        if($('#register_container').length !== 0)
            $('#register_container').children()[0].submit();
        if($('#login_container').length !== 0)
            $('#login_container').children()[0].submit();
        if($('#contact_container').length !== 0)
            $('#contact_container').children()[0].submit();
    }
});