var goBackTo = null;
var tempID = null;
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
        //$('[id^=blackout_]:visible').fadeOut();
        $('#blackout').children().filter(':visible').fadeOut();
        $('#blackout_create_location').fadeIn();
    });

    $('.mylocation_remove').click(function() {
        var clicked = $(this);
        tempID = clicked.data("location-id");
        $('#blackout').fadeIn();
        $('#blackout').children().filter(':visible').fadeOut();
        $('.fullscreen_loading_icon').fadeIn(function() {
            $.post("/ajax/getLocationInfo/", {id: clicked.data("location-id")}, function(data) {
                $('.fullscreen_loading_icon').fadeOut();
                $('#blackout_delete_location').fadeIn();
                try {
                    json = $.parseJSON(data);
                    $("#RemoveLocationName").children().first().html(json.name);
                    $("#RemoveLocationLoc").children().first().html(json.location);
                    $("#RemoveLocationType").children().first().html(json.type);
                } catch (e) {
                    //error
                    $("#removeLocationError").html(data);
                    $("#removeLocationError").fadeIn();
                }
            });
        });
    });

    $('#remove_location').click(function() {
        $(this).hide();
        $.post("/ajax/removeLocation/", {id: tempID}, function(data) {
            if (data == "succes") {
                $('#blackout').fadeOut(function() {
                    location.reload();
                });
            } else {
                $('#remove_location').show();
                $('#removeLocationError').show().children().first().html(data);
            }
        });
    });

    $('.myprojects_add').click(function() {
        $('#blackout').fadeIn();
        $('#blackout').children().filter(':visible').fadeOut();
        $('#blackout_create_project').fadeIn();
    });

    $('.myreviews_add').click(function() {
        $('#blackout').fadeIn();
        $('#blackout').children().filter(':visible').fadeOut();
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