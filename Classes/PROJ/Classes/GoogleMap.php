<?php

/**
 * Class for easily generating a google map on a page. this generates the html+javascript code 
 */

namespace PROJ\Classes;

class GoogleMap {

    private static $mapTypes = array("ROADMAP", "SATELLITE", "HYBRID", "TERRAIN");
    private $showOwnMarker;
    private $mapName;
    private $APIKey;
    private $ownMarker;
    private $zoom;
    private $mapType;
    private $userLocation;
    private $isFirstMap;
    private $secondZoomLevel;
    private $css;
    private $autoGenerate;
    private $allowStreetView;
    private $allowScrollZoom;
    private $allowManualZoom;
    private $allowPanning;
    private $allowMapTypeControl;
    private $isDraggable;
    private $markerURL;

    function __construct() {
        $this->showOwnMarker = false;
        $this->mapName = "gMap";
        $this->APIKey = "";
        $this->zoom = 7;
        $this->mapType = "ROADMAP";
        $this->isFirstMap = true;
        $this->secondZoomLevel = 18;
        $this->css = "width:500px; height:500px;";
        $this->autoGenerate = true;
        $this->allowStreetView = true;
        $this->allowScrollZoom = true;
        $this->allowManualZoom = true;
        $this->allowPanning = true;
        $this->allowMapTypeControl = true;
        $this->isDraggable = true;
        $this->markerURL = "";

        $this->ownMarker = new Marker();
        $this->ownMarker->setColor("FFFB89");
    }

    /**
     * Returns map types.
     */
    public static function getMapTypes() {
        return self::$mapTypes;
    }

    /**
     * Set to true if the user is allowed to use the streetview function.
     * @param boolean $allowStreetView
     * @throws exception
     */
    public function setAllowStreetView($allowStreetView) {
        if (gettype($allowStreetView) == "boolean")
            $this->allowStreetView = $allowStreetView;
        else
            throw new \exception('allowStreetView should be a boolean.');
    }

    /**
     * Set to true if the user is allowed to zoom with their scroll wheel.
     * @param boolean $allowScrollZoom
     * @throws exception
     */
    public function setAllowScrollZoom($allowScrollZoom) {
        if (gettype($allowScrollZoom) == "boolean")
            $this->allowScrollZoom = $allowScrollZoom;
        else
            throw new \exception('allowScrollZoom should be a boolean.');
    }

    /**
     * Set to true if the user is allowed to manual zoom in on the map.
     * @param boolean $allowManualZoom
     * @throws exception
     */
    public function setAllowManualZoom($allowManualZoom) {
        if (gettype($allowManualZoom) == "boolean")
            $this->allowManualZoom = $allowManualZoom;
        else
            throw new \exception('allowManualZoom should be a boolean.');
    }

    /**
     * Set to true if the user is allowed to use the pan control.
     * @param boolean $allowPanning
     * @throws exception
     */
    public function setAllowPanning($allowPanning) {
        if (gettype($allowPanning) == "boolean")
            $this->allowPanning = $allowPanning;
        else
            throw new \exception('allowPanning should be a boolean.');
    }

    /**
     * Set to true if the user is allowed to switch map types.
     * @param boolean $allowMapTypeControl
     * @throws exception
     */
    public function setAllowMapTypeControl($allowMapTypeControl) {
        if (gettype($allowMapTypeControl) == "boolean")
            $this->allowMapTypeControl = $allowMapTypeControl;
        else
            throw new \exception('allowMapTypeControl should be a boolean.');
    }

    /**
     * Set to true if the user is allowed to drag the map.
     * @param boolean $isDraggable
     * @throws exception
     */
    public function setIsDraggable($isDraggable) {
        if (gettype($isDraggable) == "boolean")
            $this->isDraggable = $isDraggable;
        else
            throw new \exception('isDraggable should be a boolean.');
    }

    /**
     * Set to false if you want to open the map manualy.
     * @param boolean $autoGenerate 
     * @throws exception 
     */
    public function setAutoGenerate($autoGenerate) {
        if (gettype($autoGenerate) == "boolean")
            $this->autoGenerate = $autoGenerate;
        else
            throw new \exception('autoGenerate should be a boolean.');
    }

    /**
     * If set to true places a marker on the users location
     * @param boolean $value
     * @throws exception 
     */
    public function setShowOwnLocation($value) {
        if (gettype($value) == "boolean")
            $this->showOwnMarker = $value;
        else
            throw new \exception('ShowOwnLocation should be a boolean.');
    }

    /**
     * Name of the map, also the name of the DIV element.
     * @param string $name
     * @throws exception 
     */
    public function setMapName($name) {
        if (gettype($name) == "string")
            $this->mapName = $name;
        else
            throw new \exception('MapName should be a string.');
    }

    /**
     * Can be used to overwrite the API key in the config
     * @param string $key
     * @throws exception 
     */
    public function setAPIKey($key) {
        if (gettype($key) == "string")
            $this->APIKey = $key;
        else
            throw new \exception('APIKey should be a string.');
    }

    /**
     * Can be used to overwrite the Own Location Marker.
     * @param Marker $marker
     * @throws exception 
     */
    public function setOwnMarker($marker) {
        if (is_a($marker, "\PROJ\Classes\Marker"))
            $this->ownMarker = $marker;
        else
            throw new \exception('Marker is not a Marker Class.');
    }

    /**
     * Can be used to change the zoom level of the map (higher is more zoom (0-21)).
     * @param integer $zoom
     * @throws exception 
     */
    public function setZoom($zoom) {
        if (gettype($zoom) == "integer")
            $this->zoom = $zoom;
        else
            throw new \exception('ZoomLevel should be an integer.');
    }

    /**
     * Sets the type of the map (Roadmap / Satellite / Hybrid / Terrain) 
     * @param string $type
     * @throws exception if maptype is not supported
     */
    public function setMapType($type) {
        if (in_array(strtoupper($type), self::$mapTypes))
            $this->mapType = strtoupper($type);
        else
            throw new \exception('MapType is incorrect.');
    }

    /**
     * Sets the center (user) location of the map 
     * @param string $location
     * @throws exception 
     */
    public function setCenterLocation($location) {
        if (gettype($location) == "string")
            $this->userLocation = $location;
        else
            throw new \exception('CenterLocation should be a string.');
    }

    /**
     * Set to false if this is NOT the first map on the page. 
     * @param boolean $value
     * @throws exception 
     */
    public function setIsFirstMap($value) {
        if (gettype($value) == "boolean")
            $this->isFirstMap = $value;
        else
            throw new \exception('IsFirstMap should be a boolean.');
    }

    /**
     * Set the zoom level of a marker (onclick) (higher is more zoom (0-21)).
     * @param integer $level
     * @throws exception 
     */
    public function setMarkerZoomLevel($level) {
        if (gettype($level) == "integer")
            $this->secondZoomLevel = $level;
        else
            throw new \exception('MarkerZoomLevel should be an integer.');
    }

    /**
     * Set the style for the Map DIV.
     * @param string $css
     * @throws exception 
     */
    public function setStyle($css) {
        if (gettype($css) == "string")
            $this->css = $css;
        else
            throw new \exception('CSS should be a string.');
    }

    /**
     * Set the style for the marker URL
     * This URL should contain a JSON array (MarkerCollection) with marker information.
     * @param string $markerURL
     * @throws exception 
     */
    public function setMarkerURL($markerURL) {
        if (gettype($markerURL) == "string")
            $this->markerURL = $markerURL;
        else
            throw new \exception('markerURL should be a string.');
    }

    /**
     * Returns HTML code of the map.
     * @return string
     * @throws exception 
     */
    public function getHtml() {
        //if($this->APIKey == "") 
        //throw new exception('Missing API key.');

        if ($this->userLocation == "")
            throw new \exception('No user location found.');

        $sHtml = null;

        if ($this->isFirstMap) {
            $sHtml .= '
        <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?sensor=true">
        </script>
        <script type="text/javascript">
            var MapsReady = new Array();
            var MapsMarkerReady = new Array();
            var RegisteredFunctions = new Array();
            var RegisteredMarkerFunctions = new Array();
            
            function RegisterGmapReadyFunction(mapName, func) {
                if (typeof RegisteredFunctions[mapName] === "undefined") 
                    RegisteredFunctions[mapName] = new Array();
                
                if(MapsReady.indexOf(mapName) == -1)         //Not ready yet, queue it
                    RegisteredFunctions[mapName].push(func);
                else                                         //Ready fire function
                    func();
            }
            
            function RegisterGmapMarkersReadyFunction(mapName, func) {
                if (typeof RegisteredMarkerFunctions[mapName] === "undefined") 
                    RegisteredMarkerFunctions[mapName] = new Array();
                    
                if(MapsMarkerReady.indexOf(mapName) == -1)   //Not ready yet, queue it
                    RegisteredMarkerFunctions[mapName].push(func);
                else                                         //Ready fire function
                    func();
                
            }
        </script>';
        }
        $sHtml .= '<script type="text/javascript">
        if (typeof GMapsArray === "undefined") 
            var GMapsArray = new Array();
        if (typeof GMapsMarkerArray === "undefined") 
            var GMapsMarkerArray = new Array();
            
        GMapsMarkerArray["' . $this->mapName . '"] = new Array();
            
        function drawmap_' . $this->mapName . '() {
            
            var geocoder, ' . $this->mapName . ';

            //Make a list of adresses
            var adresslist = new Array();';

        $sHtml .= '
            geocoder = new google.maps.Geocoder();
            infowindow_' . $this->mapName . ' = new google.maps.InfoWindow();
            geocoder.geocode( { \'address\': \'' . $this->userLocation . '\'}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) { 
                    var myOptions = {
                        zoom: ' . $this->zoom . ',
                        center: results[0].geometry.location,
                        mapTypeId: google.maps.MapTypeId.' . $this->mapType . ',
                        scrollwheel: ' . ($this->allowScrollZoom ? 'true' : 'false') . ',
                        streetViewControl: ' . ($this->allowStreetView ? 'true' : 'false') . ',
                        zoomControl: ' . ($this->allowManualZoom ? 'true' : 'false') . ',
                        panControl: ' . ($this->allowPanning ? 'true' : 'false') . ',
                        mapTypeControl: ' . ($this->allowMapTypeControl ? 'true' : 'false') . ',
                        draggable: ' . ($this->isDraggable ? 'true' : 'false') . '
                    }
                    ' . $this->mapName . ' = new google.maps.Map(document.getElementById("' . $this->mapName . '"), myOptions);
                    
                    GMapsArray["' . $this->mapName . '"] = ' . $this->mapName . ';
                        
                    google.maps.event.addListenerOnce(' . $this->mapName . ', \'idle\', function(){
                    });
                        
                    MapsReady.push("' . $this->mapName . '");
                    if (typeof RegisteredFunctions["' . $this->mapName . '"] !== "undefined")
                        for (var i=0;i<RegisteredFunctions["' . $this->mapName . '"].length;i++)
                            RegisteredFunctions["' . $this->mapName . '"][i]();
                        
                    makeMarkers(' . $this->mapName . ', adresslist);';

        if ($this->showOwnMarker) {
            $sHtml .= $this->ownMarker->generateMarker();

            $sHtml .= '

                        var marker = new google.maps.Marker({
                            map: ' . $this->mapName . ',
                            icon: pinImage,
                            shadow: pinShadow,
                            position: results[0].geometry.location
                        });
                    
                        google.maps.event.addListener(marker, \'click\', function() { 
                            ' . $this->mapName . '.setCenter(new google.maps.LatLng(marker.position.lat(), marker.position.lng())); 
                            ' . $this->mapName . '.setZoom(' . $this->secondZoomLevel . '); 
                            if(htmlcode != "") {
                                onItemClick(infowindow_' . $this->mapName . ', ' . $this->mapName . ', marker, htmlcode); 
                            }
                        }); ';
        }
        $sHtml .= '}
            });
        }
        function makeMarkers(forMap, adresslist) {';
        if ($this->markerURL != "") {
            $sHtml .= '
                
            $.getJSON( "' . $this->markerURL . '", function( data ) {
                $.each( data, function( key, val ) {
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(val.GeoLocation.lat, val.GeoLocation.lng),
                        map: forMap,
                        title: val.MarkerObj.Title,
                        icon: pinImage,
                        shadow: pinShadow,
                    });
                    
                    var MarkerArrayEntry = new Array();
                    MarkerArrayEntry[0] = marker;
                    MarkerArrayEntry[1] = val.MarkerObj.Html;
                    GMapsMarkerArray["' . $this->mapName . '"][key] = MarkerArrayEntry; 
                        
                    var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld="+val.MarkerObj.Sign+"|"+val.MarkerObj.Color,
                        new google.maps.Size(21, 34),
                        new google.maps.Point(0,0),
                        new google.maps.Point(10, 34));
                    var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
                        new google.maps.Size(40, 37),
                        new google.maps.Point(0, 0),
                        new google.maps.Point(12, 35));
                        
                    google.maps.event.addListener(GMapsMarkerArray["' . $this->mapName . '"][key][0], \'click\', function(event) { 
                        GMapsArray["' . $this->mapName . '"].setCenter(new google.maps.LatLng(GMapsMarkerArray["' . $this->mapName . '"][key][0].position.lat(), GMapsMarkerArray["' . $this->mapName . '"][key][0].position.lng())); 
                        GMapsArray["' . $this->mapName . '"].setZoom(' . $this->secondZoomLevel . '); 
                        if(GMapsMarkerArray["' . $this->mapName . '"][key][1] != "") {
                            onItemClick(infowindow_' . $this->mapName . ', GMapsArray["' . $this->mapName . '"], GMapsMarkerArray["' . $this->mapName . '"][key][0], GMapsMarkerArray["' . $this->mapName . '"][key][1]); 
                        }
                    });
                });
                
                //Fire marker ready functions
                MapsMarkerReady.push("' . $this->mapName . '");
                if (typeof RegisteredMarkerFunctions["' . $this->mapName . '"] !== "undefined")
                    for (var i=0;i<RegisteredMarkerFunctions["' . $this->mapName . '"].length;i++)
                        RegisteredMarkerFunctions["' . $this->mapName . '"][i]();
            });
            ';
        }
        $sHtml .= '     
            }

            function onItemClick(ifwind, map, pin, html) { 
                ifwind.setContent(html); 
                ifwind.setPosition(pin.position); 
                ifwind.open(map) 
            } 
        </script>
        <div id="' . $this->mapName . '" style="' . $this->css . '"></div>';

        if ($this->autoGenerate == true) {
            $sHtml .= '<script type="text/javascript">
                drawmap_' . $this->mapName . '();
            </script>';
        }

        return $sHtml;
    }

}

?>