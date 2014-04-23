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
    $('.mylocation_add').click(function() {
        $('#blackout').fadeIn();
        $('[id^=blackout_]:visible').fadeOut();
        $('#blackout_create_location').fadeIn();
    });

    $('.mylocation_remove').click(function() {
        $('#blackout').fadeIn();
        $('[id^=blackout_]:visible').fadeOut();
        $('.fullscreen_loading_icon').fadeIn();
        //$('#blackout_delete_location').fadeIn();
    });

    $('.myprojects_add').click(function() {
        $('#blackout').fadeIn();
        $('[id^=blackout_]:visible').fadeOut();
        $('#blackout_create_project').fadeIn();
    });

    $('.myreviews_add').click(function() {
        $('#blackout').fadeIn();
        $('[id^=blackout_]:visible').fadeOut();
        $('#blackout_create_review').fadeIn();
    });

    $('#blackout').click(function(e) {
        if ($(event.target).is($('#blackout'))) {
            $('#blackout').fadeOut(function() {
                $(this).children().hide();
            });
        } else {
            e.preventDefault();
        }
    });
    
    $('.blackout_cancel').click(function() {
        $('#blackout').fadeOut(function() {
            $(this).children().hide();
        });
    });

    $('#create_location').click(function() {
        $(this).hide();
        $.post("/Ajax/CreateLocation", $("[name='create_location_form']").serialize(), function(data) {
            if (data == "succes") {
                $('#blackout').fadeOut(function() {
                    location.reload();
                });
            } else {
                $('#create_location').show();
                $('#addLocationError').show().children().first().html(data);
            }
        });
    });

    $('#create_project').click(function() {
        $(this).hide();
        $.post("/Ajax/CreateProject", $("[name='create_project_form']").serialize(), function(data) {
            if (data == "succes") {
                $('#blackout').fadeOut(function() {
                    location.reload();
                });
            } else {
                $('#create_project').show();
                $('#addProjectError').show().children().first().html(data);
            }
        });
    });

    $('#create_review').click(function() {
        $(this).hide();
        $.post("/Ajax/CreateReview", $("[name='create_review_form']").serialize(), function(data) {
            console.log(data);
            if (data == "succes") {
                $('#blackout').fadeOut(function() {
                    location.reload();
                });
            } else {
                $('#create_review').show();
                $('#addProjectError').show().children().first().html(data);
            }
        });
    });
});

$(document).keypress(function(e) {
    if (e.which == 13) {
        if ($('#register_container').length !== 0)
            if ($('#blackout').length === 0)
                $('#register_container').children()[0].submit();
        if ($('#login_container').length !== 0)
            $('#login_container').children()[0].submit();
        if ($('#contact_container').length !== 0)
            $('#contact_container').children()[0].submit();
    }
});