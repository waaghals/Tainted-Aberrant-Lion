<?php

/**
 * Class for easily generating a google map on a page. this generates the html+javascript code 
 */

namespace PROJ\Classes;

class Marker {

    private $color;
    private $sign;
    private $title;
    private $html;
    private $long;
    private $lat;

    function __construct() {
        $this->color = "FE7569";
        $this->sign = "•";
        $this->title = "";
        $this->html = "";
        $this->long = -1;
        $this->lat = -1;
    }

    /**
     * Changes the color of the marker.
     * @param string $color
     * @throws exception 
     */
    public function setColor($color) {
        if (gettype($color) == "string")
            $this->color = str_replace('#', '', $color);
        else
            throw new \exception('MarkerColor should be a string.');
    }

    /**
     * Changes the sign on the marker.
     * @param string $sign
     * @throws exception 
     */
    public function setSign($sign) {
        if (gettype($sign) == "string")
            $this->sign = $sign;
        else
            throw new \exception('MarkerSign should be a string.');
    }

    /**
     * Changes the title of the marker.
     * @param string $title
     * @throws exception 
     */
    public function setTitle($title) {
        if (gettype($title) == "string")
            $this->title = $title;
        else
            throw new \exception('MarkerTitle should be a string.');
    }

    /**
     * Changes the HTML window of the marker.
     * @param string $html
     * @throws exception 
     */
    public function setHtml($html) {
        if (gettype($html) == "string")
            $this->html = str_replace('"', '\"', preg_replace('/\s\s+/', ' ', $html));
        else
            throw new \exception('MarkerHtml should be a string.');
    }

    /**
     * Optional: Set the Longitude of this marker (If set doesn't call the google geocode function)
     * @param double $long
     * @throws exception
     */
    public function setLong($long) {
        if (gettype($long) == "double")
            $this->long = $long;
        else
            throw new \exception('Longitude should be a double.');
    }

    /**
     * Optional: Set the Latitude of this marker (If set doesn't call the google geocode function)
     * @param double $lat
     * @throws exception
     */
    public function setLat($lat) {
        if (gettype($lat) == "double")
            $this->lat = $lat;
        else
            throw new \exception('Latitude should be a double.');
    }

    /**
     * Getter for the Long. Required for GoogleMap class to work.
     * @return double
     */
    public function getLong() {
        return $this->long;
    }

    /**
     * Getter for the Lat. Required for GoogleMap class to work.
     * @return double
     */
    public function getLat() {
        return $this->lat;
    }

    /**
     * Getter for the Color.
     * @return string
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * Getter for the Sign.
     * @return string
     */
    public function getSign() {
        return $this->sign;
    }

    /**
     * Getter for the Title.
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Getter for the Html.
     * @return string
     */
    public function getHtml() {
        return $this->html;
    }

    /**
     * Returns javascript code of the marker image.
     *
     * @return string
     */
    public function generateMarker() {
        $sHtml = null;
        $sHtml .= '
            var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=' . urlencode($this->sign) . '|' . $this->color . '",
                new google.maps.Size(21, 34),
                new google.maps.Point(0,0),
                new google.maps.Point(10, 34));
            var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
                new google.maps.Size(40, 37),
                new google.maps.Point(0, 0),
                new google.maps.Point(12, 35));
            var marker_title = "' . $this->title . '";
            var htmlcode = "' . $this->html . '";';

        return $sHtml;
    }

}
?>