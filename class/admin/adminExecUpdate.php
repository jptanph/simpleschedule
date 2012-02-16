<?php
require_once('builder/builderInterface.php');
class adminExecUpdate extends Controller_AdminExec
{
    protected function run($aArgs)
    {
        usbuilder()->init($this, $aArgs);

        $sUrl = usbuilder()->getUrl('adminPageView');

        $model = new modelAdmin();
        $bIsUpdate = $model->execUpdate($aArgs);

        if($bIsUpdate===false){
            usbuilder()->message('Saved failed!', 'warning');
        }else{
            usbuilder()->message('Saved succesfully!', 'success');
        }
        usbuilder()->jsMove($sUrl . '&idx=' . $aArgs['idx']);
    }
}