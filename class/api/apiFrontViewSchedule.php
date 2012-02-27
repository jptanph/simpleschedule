<?php
require_once('builder/builderInterface.php');

class apiFrontViewSchedule extends Controller_Api
{
    public function post($aArgs)
    {
        usbuilder()->init($this, $aArgs);
        $aData = common()->modelFront()->execViewSchedule($aArgs['sSchedDate'],$aArgs['seq']);
        return $aData;
    }
}




