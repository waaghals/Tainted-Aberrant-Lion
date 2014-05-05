var goBackTo = null;
var tempID = 0;
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

    //Update review icon
    $('.myreview_update').click(function() {
        var clicked = $(this);
        tempID = clicked.data("review-id");

        //Prepare page
        $("#review_action").data("action", "update");
        $("#review_action").children("p").html("Update Review");
        $('#review_action').show();
        $("#addReviewError").hide();

        //Start fades
        $('#blackout').fadeIn();
        $('#blackout').children().filter(':visible').fadeOut();
        $('.fullscreen_loading_icon').fadeIn(function() {
            $.post("/ajax/getReviewInfo/", {id: clicked.data("review-id")}, function(data) {
                $('.fullscreen_loading_icon').fadeOut();
                $('#blackout_create_review').fadeIn();
                try {
                    json = $.parseJSON(data);
                    $('[name="create_review_form"]').find('[name="project"]').children().each(function() {
                        if ($(this).val() == json.project.id) {
                            $(this).prop('selected', true);
                        }
                    });
                    $('[name="create_review_form"]').find('[name="assignment_score"]').children().each(function() {
                        if ($(this).val() == json.assignmentrating) {
                            $(this).prop('selected', true);
                        }
                    });
                    $('[name="create_review_form"]').find('[name="guidance_score"]').children().each(function() {
                        if ($(this).val() == json.guidancerating) {
                            $(this).prop('selected', true);
                        }
                    });
                    $('[name="create_review_form"]').find('[name="accomodation_score"]').children().each(function() {
                        if ($(this).val() == json.accommodationrating) {
                            $(this).prop('selected', true);
                        }
                    });
                    $('[name="create_review_form"]').find('[name="overall_score"]').children().each(function() {
                        if ($(this).val() == json.rating) {
                            $(this).prop('selected', true);
                        }
                    });

                    var decodedName = $("<div/>").html(json.text).text();
                    $('[name="create_review_form"]').find('[name="review"]').val(decodedName);
                } catch (e) {
                    //error
                    $("#removeLocationError").html(data);
                    $("#removeLocationError").fadeIn();
                }
            });
        });
    });

    //Remove review icon
    $('.myreview_remove').click(function() {
        var clicked = $(this);
        tempID = clicked.data("review-id");
        $('#blackout').fadeIn();
        $('#blackout').children().filter(':visible').fadeOut();
        $('.fullscreen_loading_icon').fadeIn(function() {
            $.post("/ajax/getReviewInfo/", {id: clicked.data("review-id")}, function(data) {
                $('.fullscreen_loading_icon').fadeOut();
                $('#blackout_delete_review').fadeIn();
                try {
                    json = $.parseJSON(data);
                    $("#RemoveProjectProject").children().first().html(json.project.institute.name + " (" + json.project.institute.place + ")");
                    $("#RemoveProjectScore").children().first().html(json.rating);
                } catch (e) {
                    //error
                    $("#removeReviewError").html(data);
                    $("#removeReviewError").fadeIn();
                }
            });
        });
    });

    //Create new project button
    $('.myprojects_add').click(function() {
        $('#blackout').fadeIn();
        $('#blackout').children().filter(':visible').fadeOut();
        $('#blackout_create_project').fadeIn();
    });

    //Create new review button
    $('.myreviews_add').click(function() {
        //Prepare page
        $("#review_action").data("action", "create");
        $("#review_action").children("p").html("Create Review");
        $('[name="create_review_form"]')[0].reset();
        $('#review_action').show();
        $("#addReviewError").hide();

        //Start fade
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

    //Create new project confirmation button
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

    //Create new review confirmation button
    $('#review_action').click(function() {
        $(this).hide();
        var data = $("[name='create_review_form']").serializeArray();
        data.push({name: "action", value: $("#review_action").data("action")});
        data.push({name: "id", value: tempID});
        $.post("/Ajax/SaveReview", data, function(data) {
            if (data == "succes") {
                $('#blackout').fadeOut(function() {
                    location.reload();
                });
            } else {
                $('#review_action').show();
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

    //Remove location confirmation button
    $('#remove_review').click(function() {
        $(this).hide();
        $.post("/ajax/removeReview/", {id: tempID}, function(data) {
            if (data == "succes") {
                $('#blackout').fadeOut(function() {
                    location.reload();
                });
            } else {
                $('#remove_review').show();
                $('#removeReviewError').show().children().first().html(data);
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