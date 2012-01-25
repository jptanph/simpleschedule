<?php
require_once('builder/builderInterface.php');

class apiFrontViewSchedule extends Controller_Api
{
    public function post($aArgs)
    {
        $model = new modelFront();
        $aData = $model->execViewSchedule($aArgs['sSchedDate']);
        return $aData;
    }
}




