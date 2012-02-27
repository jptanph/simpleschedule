<?php
require_once('builder/builderInterface.php');

class apiFrontViewInfo extends Controller_Api
{
    public function post($aArgs)
    {
        usbuilder()->init($this, $aArgs);
        return common()->modelFront()->execViewInfo($aArgs['idx'],$aArgs['seq']);
    }
}