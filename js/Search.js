/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function init() {
    key_count_global = 0; // Global variable
    document.getElementById("searchbar").onkeydown = function() {
        key_count_global++;
        setTimeout("lookup(" + key_count_global + ")", 750);
    }
}
window.onload = init;

function lookup(key_count) {
    if (key_count == key_count_global && $('#searchbar').val().trim() !== "") {
        $.post("/Ajax/getProjectInfo/", {tag: $('#searchbar').val()}, function(data) {
            $('#searchresult').show();
            $('#searchresult').html('');
            $.each(data, function(i, result) {
                //Review hit
                if (result['matchedOn'] === "review") {
                    var newelement = $("<div id='record" + (i + 1) + "' style='cursor:pointer;' onclick='fakeMarkerClick(" + result['instituteid'] + "," + result['lat'] + "," + result['lng'] + "); loadReview(" + result['revid'] + ");'></div>").appendTo('#searchresult');
                    newelement.append("<p style='font-weight:bold; margin-bottom:3px;'>Review by " + result['studentname'] + " " + result['studentsurname'] + "</p>");
                    newelement.append("<p>" + result['text'] + "</p>");
                    if (i !== data.length - 1) {
                        $('#searchresult').append("<div class='resultspacer'> </div>");
                    }
                }

                //Institute hit
                if (result['matchedOn'] === "instname") {
                    var newelement = $("<div id='record" + (i + 1) + "' style='cursor:pointer;' onclick='fakeMarkerClick(" + result['instituteid'] + "," + result['lat'] + "," + result['lng'] + ")'></div>").appendTo('#searchresult');
                    newelement.append("<p style='font-weight:bold; margin-bottom:3px;'> " + result['institutename'] + "</p>");
                    newelement.append("<p>" + result['instituteplace'] + "</p>");
                    if (i !== data.length - 1) {
                        $('#searchresult').append("<div class='resultspacer'> </div>");
                    }
                }
            });
            if (data.length === 0) {
                $('#searchresult').append("<p>No search results found.</p>");
            }
        }, "json");
    }
}

$(document).ready(function() {
    $(document).click(function() {
        $('#searchresult').hide();
    });
});
$(document).keypress(function(e) {
    if (e.which == 13) {
        if ($('#searchbar').is(":focus")) {
            lookup(key_count_global);
        }
    }
});