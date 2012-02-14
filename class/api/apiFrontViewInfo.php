<?php
require_once('builder/builderInterface.php');

class apiFrontViewInfo extends Controller_Api
{
    public function post($aArgs)
    {
        $model = new modelFront();

        return $model->execViewInfo($aArgs['idx']);
    }
}