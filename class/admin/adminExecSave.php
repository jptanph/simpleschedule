<?php
require_once('builder/builderInterface.php');

class adminExecSave extends Controller_AdminExec
{
    protected function run($aArgs)
    {
        $model = new modelAdmin();

        usbuilder()->vd($aArgs);

    }
}
