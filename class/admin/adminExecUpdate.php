<?php
require_once('builder/builderInterface.php');
class adminExecUpdate extends Controller_AdminExec
{
    protected function run($aArgs)
    {
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $this->writeJs($sInitScript);
        $sUrl = usbuilder()->getUrl('adminPageView');

        $model = new modelAdmin();
        $bIsUpdate = $model->execUpdate($aArgs);

        if($bIsUpdate===false){
            usbuilder()->message('Saved failed!', 'warning');
        }else{
            usbuilder()->message('Saved succesfully!', 'success');
        }
        $sJsMove = usbuilder()->jsMove($sUrl . '&idx=' . $aArgs['idx']);
        $this->writeJS($sJsMove);
    }
}