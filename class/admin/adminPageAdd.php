<?php
require_once('builder/builderInterface.php');

class adminPageAdd extends Controller_Admin
{
    private $_sPrefix;

    protected function run($aArgs)
    {
         $this->_sPrefix = 'simpleschedule_';
         /** usbuilder initializer.**/
        usbuilder()->init($this, $aArgs);
        usbuilder()->getFormAction($this->_sPrefix . 'add_form','adminExecSave');
        /** usbuilder initializer.**/

        usbuilder()->validator(array('form' => $this->_sPrefix . 'add_form'));
        $sImagePath = '/_sdk/img/simpleschedule/';
        $sUrl = usbuilder()->getUrl('adminPageContents');
        $sUrlAdd = usbuilder()->getUrl('adminPageAdd');
        $this->importCss('adminPageContents');
        $this->importCss('jqueryCalendar');

        $this->externalJS("http://maps.google.com/maps/api/js?sensor=true");
        $this->externalJS("http://code.google.com/apis/gears/gears_init.js");
        $this->importjs('googleMapApi');
        $this->importJs('jqueryCalendar');
        $this->importJs(__CLASS__);
        $this->assign('iSeq',$aArgs['seq']);
        $this->assign('sDate',date('Y/m/d'));
        $this->assign('sPrefix',$this->_sPrefix);
        $this->assign('sUrl',$sUrl);
        $this->assign('sUrlAdd',$sUrlAdd);
        $this->assign('sImagePath',$sImagePath);
        $this->view(__CLASS__);
    }
}