<?php
require_once('builder/builderInterface.php');

class adminExecSave extends Controller_AdminExec
{
    protected function run($aArgs)
    {
        usbuilder()->init($this, $aArgs);
        $sUrl = usbuilder()->getUrl('adminPageContents');

        $start_time = str_pad($aArgs['start_time'],2,'0',STR_PAD_LEFT) . ':00:00';
        $end_time = str_pad($aArgs['end_time'],2,'0',STR_PAD_LEFT) . ':00:00';

        $start_date = str_replace('/','-',$aArgs['start_date'] . ' ' . $start_time);
        $end_date = str_replace('/','-',$aArgs['end_date'] . ' ' . $end_time);

        $bIsInsert = common()->modelAdmin()->insertRecord($aArgs);
        if($bIsInsert===false){
            usbuilder()->message('Saved failed!', 'warning');
        }else{
            usbuilder()->message('Saved succesfully!', 'success');
        }
        usbuilder()->message('Saved succesfully!', 'success');
        usbuilder()->jsMove($sUrl);
    }
}
