<?php

namespace PROJ\View;

class DemoGmap {

    public function getContent() {
       if(@!strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            //Map weergeven
            $gmap = new \PROJ\Classes\GoogleMap();
            $gmap->setCenterLocation("Hilversum");
            $gmap->setZoom(9);
            $gmap->setStyle("width:100%; height:100%;");
            $gmap->setMarkerURL("/GoogleMap/");
            $gmap->setAllowStreetView(false);

            return $gmap->getHtml();
        }else{
            //Markers terug geven
            $mc = new \PROJ\Classes\MarkerCollection();

            $demoMarker = new \PROJ\Classes\Marker();
            $demoMarker->setLat(51.688945);
            $demoMarker->setLong(5.287256);
            $demoMarker->setHtml("<b>Avans</b> Hogeschool Den Bosch<br>
                Onderwijsboulevard 256<br>
                5223 DJ 's-Hertogenbosch<br>
                073 629 5295");
            $demoMarker->setTitle("Avans Hogeschool");

            $mc->addMarkerLocation("Avans Hogeschool", $demoMarker);
            return $mc->generateMarkerJSON();
        }
    }

}

?>