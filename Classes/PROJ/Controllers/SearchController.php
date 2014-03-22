<?php

namespace PROJ\Controllers;

class SearchController extends BaseController{

    function IndexAction() {
        $array = $_SESSION['searchresult'];
        echo "Zoekresultaten:";
        if(empty($array)){
            echo "<p>Er zijn geen reviews gevonden.</p>";
        }
        foreach ($array as $value) {
        echo "<p>Instituut naam: " .$value['name'] ."<br> Review: " . $value['text']."<br> Rating: ". $value['rating'] . "<br> Long: " . $value['long'] . "<br> Lat: " . $value['lat'] . "</p>";   
        }
    }
}
?>

