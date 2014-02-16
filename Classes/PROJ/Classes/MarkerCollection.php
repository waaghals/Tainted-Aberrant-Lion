<?php

/**
 * Class for easily generating a google map on a page. this generates the html+javascript code 
 */

namespace PROJ\Classes;

class MarkerCollection {

    private $defaultMarker;
    private $markerLocations;

    function __construct() {
        $this->markerLocations = array();

        $this->defaultMarker = new Marker();
        $this->defaultMarker->setColor("FE7569");
    }

    /**
     * Adds a new marker location 
     * @param string $location
     * @param Marker $marker [optional]
     * @throws exception 
     */
    public function addMarkerLocation($location, $marker = null) {
        if ($marker == null)
            $marker = $this->defaultMarker;

        if (gettype($location) == "string" && is_a($marker, "\PROJ\Classes\Marker")) {
            //Create a temp array
            $locArray = array();
            array_push($locArray, $location);
            array_push($locArray, $marker);

            //Push the location
            array_push($this->markerLocations, $locArray);
        } else if (gettype($location) == "string" && !is_a($marker, "\PROJ\Classes\Marker"))
            throw new \exception('MarkerLocation argument 2 should be of type Marker.');
        else
            throw new \exception('MarkerLocation argument 1 should be a string.');
    }

    /**
     * Function to create a JSON array for the google map
     * @return JSON
     */
    public function generateMarkerJSON() {
        $totalArray = array();
        $i = 0;

        foreach ($this->markerLocations as $location) {
            $GeoCoding = !($location[1]->getLong() != -1 && $location[1]->getLat() != -1);
            if ($GeoCoding) {
                $Geocoder = new GoogleMapsGeocoder();
                $Geocoder->setAddress($location[0]);
                $Geocoder->setFormat('json');
                $res = $Geocoder->geocode();
                $totalArray[$i]['GeoLocation'] = $res['results'][0]['geometry']['location'];
            } else {
                $totalArray[$i]['GeoLocation'] = array('lat' => $location[1]->getLat(), 'lng' => $location[1]->getLong());
            }

            $totalArray[$i]['MarkerObj']['Color'] = $location[1]->getColor();
            $totalArray[$i]['MarkerObj']['Sign'] = urlencode($location[1]->getSign());
            $totalArray[$i]['MarkerObj']['Title'] = $location[1]->getTitle();
            $totalArray[$i]['MarkerObj']['Html'] = $location[1]->getHtml();
            $i++;
        }

        return json_encode($totalArray);
    }

}
?>