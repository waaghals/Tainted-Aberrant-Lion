var goBackTo = null;
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
        $('#blackout_create_location').fadeIn();
    });

    $('#myprojects_add').click(function() {
        $('#blackout').fadeIn();
        $('#blackout_create_project').fadeIn();
    });
    
    $('#blackout').click(function(e) {
        if($(event.target).is($('#blackout'))) {
            $('#blackout').fadeOut(function() {
                $(this).children().hide();
            });
        }else{
            e.preventDefault(); 
        }
    });
    
    $('#create_location').click(function() {
        $(this).hide();
        $.post( "/Ajax/CreateLocation", $( "[name='create_location_form']" ).serialize(), function(data) {
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
    
    $('#create_project').click(function() {
        $(this).hide();
        $.post( "/Ajax/CreateProject", $( "[name='create_project_form']" ).serialize(), function(data) {
            console.log(data);
            if(data == "succes") {
                $('#blackout').fadeOut(function() {
                    location.reload();
                });
            }else{
                $('#create_project').show();
                $('#addProjectError').show().children().first().html(data);
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