<?php
require_once('builder/builderInterface.php');
class apiGoogleMap extends Controller_Api
{
    /** Use for splitting the Latitude and Longitude for Google Map API **/
    public function post($aArgs)
    {
        $aLatLngHandler = array();
        $latLng = str_replace('(','',$aArgs['fLatLng']);
        $latLng = str_replace(')','',$latLng);
        $aExp = explode(',',$latLng);
        $aLatLngHandler['fLatitude'] = $aExp[0];
        $aLatLngHandler['fLongitude'] = $aExp[1];
        return $aLatLngHandler;
    }
}