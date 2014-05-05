var goBackTo = null;
var tempID = 0;

var monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"];


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
    //Create new location button
    $('.mylocation_add').click(function() {
        //Prepare page
        $("#location_action").data("action", "create");
        $("#location_action").children("p").html("Create Location");
        $('[name="create_location_form"]')[0].reset();
        $('#location_action').show();
        $("#addLocationError").hide();

        //Start fade
        $('#blackout').fadeIn();
        $('#blackout').children().filter(':visible').fadeOut();
        $('#blackout_create_location').fadeIn();
    });

    //Remove location icon
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
                    $("#RemoveLocationLoc").children().first().html(json.place);
                    $("#RemoveLocationType").children().first().html(json.type);
                } catch (e) {
                    //error
                    $("#removeLocationError").html(data);
                    $("#removeLocationError").fadeIn();
                }
            });
        });
    });

    //Remove project icon
    $('.myprojects_remove').click(function() {
        var clicked = $(this);
        tempID = clicked.data("project-id");
        $('#blackout').fadeIn();
        $('#blackout').children().filter(':visible').fadeOut();
        $('.fullscreen_loading_icon').fadeIn(function() {
            $.post("/ajax/getMyLocationsInfo/", {id: clicked.data("project-id")}, function(data) {
                $('.fullscreen_loading_icon').fadeOut();
                $('#blackout_delete_project').fadeIn();
                try {
                    json = $.parseJSON(data);
                    $("#RemoveProjectnLoc").children().first().html(json.institute.name + "(" + json.institute.place + ")");
                    $("#RemoveProjectType").children().first().html(json.type);
                    $("#RemoveProjectStartDate").children().first().html(monthNames[json.start_month - 1] + " " + json.start_year);
                    $("#RemoveProjectEndDate").children().first().html(monthNames[json.end_month - 1] + " " + json.end_year);
                } catch (e) {
                    //error
                    $("#removeLocationError").html(data);
                    $("#removeLocationError").fadeIn();
                }
            });
        });
    });

    //Update location icon
    $('.mylocation_update').click(function() {
        var clicked = $(this);
        tempID = clicked.data("location-id");

        //Prepare page
        $("#location_action").data("action", "update");
        $("#location_action").children("p").html("Update Location");
        $('#location_action').show();
        $("#addLocationError").hide();

        //Start fades
        $('#blackout').fadeIn();
        $('#blackout').children().filter(':visible').fadeOut();
        $('.fullscreen_loading_icon').fadeIn(function() {
            $.post("/ajax/getLocationInfo/", {id: clicked.data("location-id")}, function(data) {
                $('.fullscreen_loading_icon').fadeOut();
                $('#blackout_create_location').fadeIn();
                try {
                    json = $.parseJSON(data);
                    $('[name="create_location_form"]').find('[name="type"]').children().each(function() {
                        if ($(this).html() === json.type) {
                            $(this).prop('selected', true);
                        }
                    });
                    $('[name="create_location_form"]').find('[name="country"]').children().each(function() {
                        if ($(this).html() === json.country) {
                            $(this).prop('selected', true);
                        }
                    });

                    var decodedName = $("<div/>").html(json.name).text();
                    $('[name="create_location_form"]').find('[name="name"]').val(decodedName);
                    $('[name="create_location_form"]').find('[name="city"]').val(json.place);
                    $('[name="create_location_form"]').find('[name="street"]').val(json.street);
                    $('[name="create_location_form"]').find('[name="housenumber"]').val(json.housenumber);
                    $('[name="create_location_form"]').find('[name="postalcode"]').val(json.postalcode);
                    $('[name="create_location_form"]').find('[name="email"]').val(json.email);
                    $('[name="create_location_form"]').find('[name="telephone"]').val(json.telephone);

                    $("#RemoveLocationName").children().first().html(json.name);
                    $("#RemoveLocationLoc").children().first().html(json.place);
                    $("#RemoveLocationType").children().first().html(json.type);
                } catch (e) {
                    //error
                    $("#removeLocationError").html(data);
                    $("#removeLocationError").fadeIn();
                }
            });
        });
    });

    //Update projects icon
    $('.myprojects_update').click(function() {
        var clicked = $(this);
        tempID = clicked.data("project-id");

        //Prepare page
        $("#projects_action").data("action", "update");
        $("#projects_action").children("p").html("Update Location");
        $('#projects_action').show();
        $("#addProjectError").hide();

        //Start fades
        $('#blackout').fadeIn();
        $('#blackout').children().filter(':visible').hide();
        $('.fullscreen_loading_icon').fadeIn(function() {
            $.post("/ajax/getMyLocationsInfo/", {id: clicked.data("project-id")}, function(data) {
                $('.fullscreen_loading_icon').fadeOut();
                $('#blackout_create_project').fadeIn();
                try {
                    json = $.parseJSON(data);
                    $('[name="create_project_form"]').find('[name="type"]').children().each(function() {
                        if ($(this).html() == json.type) {
                            $(this).prop('selected', true);
                        }
                    });
                    $('[name="create_project_form"]').find('[name="location"]').children().each(function() {
                        if ($(this).val() == json.institute.id) {
                            $(this).prop('selected', true);
                        }
                    });
                    $('[name="create_project_form"]').find('[name="start_year"]').children().each(function() {
                        if ($(this).val() == json.start_year) {
                            $(this).prop('selected', true);
                        }
                    });
                    $('[name="create_project_form"]').find('[name="start_month"]').children().each(function() {
                        if ($(this).val() == json.start_month) {
                            $(this).prop('selected', true);
                        }
                    });
                    $('[name="create_project_form"]').find('[name="end_year"]').children().each(function() {
                        if ($(this).val() == json.end_year) {
                            $(this).prop('selected', true);
                        }
                    });
                    $('[name="create_project_form"]').find('[name="end_month"]').children().each(function() {
                        if ($(this).val() == json.end_month) {
                            $(this).prop('selected', true);
                        }
                    });

                    $("#RemoveLocationName").children().first().html(json.name);
                    $("#RemoveLocationLoc").children().first().html(json.place);
                    $("#RemoveLocationType").children().first().html(json.type);
                } catch (e) {
                    //error
                    $("#addProjectError").html(data);
                    $("#addProjectError").fadeIn();
                }
            });
        });
    });

    //Create new project button
    $('.myprojects_add').click(function() {
        //Prepare page
        $("#projects_action").data("action", "create");
        $("#projects_action").children("p").html("Create Project");
        $('[name="create_project_form"]')[0].reset();
        $('#projects_action').show();
        $("#addProjectError").hide();

        //Start fade
        $('#blackout').fadeIn();
        $('#blackout').children().filter(':visible').fadeOut();
        $('#blackout_create_project').fadeIn();
    });

    //Create new review button
    $('.myreviews_add').click(function() {
        $('#blackout').fadeIn();
        $('#blackout').children().filter(':visible').fadeOut();
        $('#blackout_create_review').fadeIn();
    });

    //Blackout "cancel"
    $('#blackout').click(function(e) {
        if ($(event.target).is($('#blackout'))) {
            $('#blackout').fadeOut(function() {
                $(this).children().hide();
            });
        } else {
            e.preventDefault();
        }
    });

    //Any cancel button
    $('.blackout_cancel').click(function() {
        $('#blackout').fadeOut(function() {
            $(this).children().hide();
        });
    });

    //Create/Update new location confirmation button
    $('#location_action').click(function() {
        $(this).hide();
        var data = $("[name='create_location_form']").serializeArray();
        data.push({name: "action", value: $("#location_action").data("action")});
        data.push({name: "id", value: tempID});
        $.post("/Ajax/SaveLocation", data, function(data) {
            if (data == "succes") {
                $('#blackout').fadeOut(function() {
                    location.reload();
                });
            } else {
                $('#location_action').show();
                $('#addLocationError').show().children().first().html(data);
            }
        });
    });

    //Create/Update new project confirmation button
    $('#projects_action').click(function() {
        $(this).hide();
        var data = $("[name='create_project_form']").serializeArray();
        data.push({name: "action", value: $("#projects_action").data("action")});
        data.push({name: "id", value: tempID});
        $.post("/Ajax/SaveProject", data, function(data) {
            if (data == "succes") {
                $('#blackout').fadeOut(function() {
                    location.reload();
                });
            } else {
                $('#projects_action').show();
                $('#addProjectError').show().children().first().html(data);
            }
        });
    });

    //Create new review confirmation button
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
                $('#addReviewError').show().children().first().html(data);
            }
        });
    });

    //Remove location confirmation button
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

    //Remove project confirmation button
    $('#remove_project').click(function() {
        $(this).hide();
        $.post("/ajax/removeProject/", {id: tempID}, function(data) {
            if (data == "succes") {
                $('#blackout').fadeOut(function() {
                    location.reload();
                });
            } else {
                $('#remove_project').show();
                $('#removeProjectError').show().children().first().html(data);
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