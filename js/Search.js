/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function init() {
    key_count_global = 0; // Global variable
    document.getElementById("searchbar").onkeypress = function() {
        key_count_global++;
        setTimeout("lookup(" + key_count_global + ")", 750); //Function will be called 1 second after user types anything. Feel free to change this value.
    }
}
window.onload = init; //or $(document).ready(init); - for jQuery

function lookup(key_count) {

    if (key_count == key_count_global) {


        // Do the ajax lookup here.
        var http = new XMLHttpRequest();
        var url = "Ajax/getProjectInfo/";
        var params = "tag=" + document.getElementById("searchbar").value;
        http.open("POST", url, true);
        //Send the proper header information along with the request
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.setRequestHeader("Content-length", params.length);
        http.setRequestHeader("Connection", "close");
        http.onreadystatechange = function() {//Call a function when the state changes.
            if (http.readyState == 4 && http.status == 200) {
                console.log(jQuery.parseJSON(http.responseText)[0]);
                
            }
        }
        http.send(params);
    }
}