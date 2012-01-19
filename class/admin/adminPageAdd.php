<?php
require_once('builder/builderInterface.php');

class adminPageAdd extends Controller_Admin
{
    private $_sPrefix;

    protected function run($aArgs)
    {
         $this->_sPrefix = 'simpleschedule_';
         /** usbuilder initializer.**/
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $sFormScript = usbuilder()->getFormAction($this->_sPrefix . 'add_form','adminExecSave');
        $this->writeJs($sInitScript);
        $this->writeJs($sFormScript);
        /** usbuilder initializer.**/

        usbuilder()->validator(array('form' => $this->_sPrefix . 'add_form'));
        $sImagePath = '/_sdk/img/simpleschedule/';
        $sUrl = usbuilder()->getUrl('adminPageList');
        $sUrlAdd = usbuilder()->getUrl('adminPageAdd');
        $this->importCss('adminPageList');
        $this->importCss('jqueryCalendar');
        $this->importJs('jqueryCalendar');
        $this->importJs(__CLASS__);
        $this->assign('sDate',date('Y/m/d'));
        $this->assign('sPrefix',$this->_sPrefix);
        $this->assign('sUrl',$sUrl);
        $this->assign('sUrlAdd',$sUrlAdd);
        $this->assign('sImagePath',$sImagePath);
        $this->view(__CLASS__);
    }
}