<?php


class DynamicGoogleMapSmarter extends Object
{

    /**
     * points are formatted like this:
     *  - points:[
     *      - id: ...
     *      - title: ....
     *      - address: ...
     *      - lat: ...
     *      - lng: ....
     *    ]
     * address OR lat / lng are optional (set lat / lng to zero to )
     *
     * @param  array $points
     * @param  string $markerCallback (optional)
     * @return this
     */
    public function createMap($points, $markerCallback = null)
    {
        $googleJS =
            "//maps.googleapis.com/maps/api/js"
            ."?v=".Config::inst()->get('GoogleMapSmarter', "api_version")
            ."&libraries=places"
            ."&key=".Config::inst()->get('GoogleMapSmarter', "api_key");
        Requirements::javascript($googleJS);
        Requirements::javascript('google_map_smarter/javascript/GoogleMapSmarter.js');
        $fx = $this->getMapVariable('markerCallbackFX', 'marker_callback_fx');
        $dLat = $this->getMapVariable('defaultLocationLat', 'default_location_lat');
        $dLng = $this->getMapVariable('defaultLocationLng', 'default_location_lng');
        Requirements::customScript('
                if(typeof GoogleMapSmarterOptions === "undefined") {
                    var GoogleMapSmarterOptions = [];
                }
                GoogleMapSmarterOptions.push({
                    id: "'.$this->getMapVariable('mapID', 'map_id').'",
                    iconIsRetinaSize:  '.($this->getMapVariable('iconIsRetinaSize', 'icon_is_retina_size') ? 1 : 0).',
                    iconURL:  "'.$this->getMapVariable('iconURL', 'icon_url').'",
                    iconWidth:  '.$this->getMapVariable('iconWidth', 'icon_width').',
                    iconHeight: '.$this->getMapVariable('iconHeight', 'icon_height').',
                    defaultZoom: '.$this->getMapVariable('defaultZoom', 'default_zoom').',
                    defaultLocation: {
                        lat: '.($dLat ? $dLat : 0).',
                        lng: '.($dLng ? $dLng : 0).'
                    },
                    points: '.json_encode($points).',
                    markerCallbackFX: '.($fx ? $fx : 'null').'
                });
            ',
            'CustomScript'.$this->getMapVariable('mapID', 'map_id')
        );

        return $this;
    }

    private static $map_id = 'google-map';

    private static $icon_is_retina_size = true;

    private static $icon_url = 'http://icons.iconarchive.com/icons/paomedia/small-n-flat/1024/map-marker-icon.png';

    private static $icon_width = 90;

    private static $icon_height = 90;

    private static $default_zoom = 7;

    private static $default_location_lat = -45;

    private static $default_location_lng = 174;

    private static $marker_callback_fx = null;

    protected $mapID = null;

    protected $iconIsRetinaSize = null;

    protected $iconURL = null;

    protected $iconWidth = null;

    protected $iconHeight = null;

    protected $defaultZoom = null;

    protected $defaultLocationLat = null;

    protected $defaultLocationLng = null;

    protected $markerCallbackFx = null;

    function setMapID($s)
    {
        return $this->setMapVariable('mapID', $s);
    }

    function getMapID($s) {
        return $this->getMapVariable('mapID', 'map_id');
    }

    function setIconIsRetinaSize($s)
    {
        return $this->setMapVariable('iconIsRetinaSize',  $s);
    }

    function getIconIsRetinaSize($s) {
        return $this->getMapVariable('iconIsRetinaSize', 'icon_is_retina_size');
    }


    function setIconURL($s)
    {
        return $this->setMapVariable('iconURL',  $s);
    }

    function getIconURL($s) {
        return $this->getMapVariable('iconURL', 'icon_url');
    }

    function setIconWidth($s)
    {
        return $this->setMapVariable('iconWidth',  $s);
    }

    function getIconWidth($s) {
        return $this->getMapVariable('iconWidth', 'icon_width');
    }

    function setIconHeight($s)
    {
        return $this->setMapVariable('iconHeight', $s);
    }

    function getIconHeight($s) {
        return $this->getMapVariable('iconHeight', 'icon_height');
    }

    function setDefaultZOom($s)
    {
        return $this->setMapVariable('defaultZoom', $s);
    }

    function getDefaultZoom($s) {
        return $this->getMapVariable('defaultZoom', 'defaultZoom');
    }

    function setDefaultLocationLat($s)
    {
        return $this->setMapVariable('defaultLocationLat', $s);
    }

    function getDefaultLocationLat($s) {
        return $this->getMapVariable('defaultLocationLat', 'defaultLocation_lat');
    }

    function setDefaultLocationLng($s)
    {
        return $this->setMapVariable('defaultLocationLng', $s);
    }

    function getDefaultLocationLng($s) {
        return $this->getMapVariable('defaultLocationLng', 'defaultLocation_lng');
    }

    function setMarkerCallbackFX($s)
    {
        return $this->setMapVariable('markerCallbackFX', $s);
    }

    function getMarkerCallbackFX($s) {
        return $this->getMapVariable('markerCallbackFX', 'marker_callback_fx');
    }

    /**
     *
     *
     * @param string $internalVariableName the variable name
     * @param string $staticVariableName   the static variable name
     *
     * @param return this
     */
    protected function getMapVariable($internalVariableName, $staticVariableName)
    {
        if($this->$internalVariableName !== null) {
            return $this->$internalVariableName;
        } else {
            return $this->Config()->$staticVariableName;
        }
    }

    /**
     *
     *
     * @param string $internalVariableName the variable name
     * @param mixed $s                     the variable to set
     *
     * @param return this
     */
    protected function setMapVariable($internalVariableName, $s)
    {
        $this->$internalVariableName = $s;
        return $this;
    }


}
