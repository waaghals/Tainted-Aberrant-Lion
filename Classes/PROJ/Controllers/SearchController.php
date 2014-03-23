<?php

namespace PROJ\Controllers;

class SearchController extends BaseController {

    function IndexAction() {
        $searchresult = $_SESSION['searchresult'];
        $html = null;
        $html .= "Zoekresultaten:";
        if (empty($searchresult)) {
            $html .= "<p>Er zijn geen reviews gevonden.</p>";
        }
        foreach ($searchresult as $value) {
            $html .= "<p>Instituut naam: " . $value['institutename'] . "<br> Long: " . $value['long'] . "<br> Lat: " . $value['lat'] . "<br> Review: " . $value['text'] . "<br> Rating: " . $value['rating'] . "<br>Review door: " . $value['studentname'] . " " . $value['studentsurname'] . "<br>Email: " . $value['email'] . "</p>";
        }
        echo $html;
    }

}
?>

