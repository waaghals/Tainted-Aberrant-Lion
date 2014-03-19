<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PROJ\Controllers;

/**
 * Description of HomeController
 *
 * @author Patrick
 */
class HomeController extends BaseController {
    
    public function indexAction($val = "default") {
        $mapView = new \PROJ\Tools\Template("MainMapView");
        
        echo $mapView;
    }
    
    public function otherAction() {
        die("Home - Other");
    }
}
