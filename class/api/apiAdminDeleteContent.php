<?php
require_once('builder/builderInterface.php');
class apiAdminDeleteContent extends Controller_Api
{

    protected function post($aArgs)
    {
        usbuilder()->init($this, $aArgs);


        foreach($aArgs['idx'] as $rows)
        {
            common()->modelAdmin()->execDelete($rows,$aArgs);
        }
    }
}