<?php
require_once('builder/builderInterface.php');
class apiAdminDeleteContent extends Controller_Api
{

    protected function post($aArgs)
    {
        $model = new modelAdmin();

        foreach($aArgs['idx'] as $rows){
            $model->execDelete($rows);
        }
    }
}