<?php
require_once('builder/builderInterface.php');

class adminPageView extends Controller_Admin
{
     private $_sPrefix;

     protected function run($aArgs)
     {
         $this->_sPrefix = 'simpleschedule_';
         /** usbuilder initializer.**/
         $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
         $sFormScript = usbuilder()->getFormAction($this->_sPrefix . 'add_form','adminExecUpdate');
         $this->writeJs($sInitScript);
         $this->writeJs($sFormScript);
         /** usbuilder initializer.**/
         usbuilder()->validator(array('form' => $this->_sPrefix . 'edit_form'));

         $model = new modelAdmin();
         $aResult = $model->execViewRecord($aArgs['idx']);


         $sImagePath = '/_sdk/img/simpleschedule/';
         $sUrl = usbuilder()->getUrl('adminPageList');
         $sUrlAdd = usbuilder()->getUrl('adminPageAdd');

         $this->externalJS("http://maps.google.com/maps/api/js?sensor=true");
         $this->externalJS("http://code.google.com/apis/gears/gears_init.js");
         $this->importJs('googleMapApi');

         $this->importCss('adminPageList');
         $this->importCss('jqueryCalendar');
         $this->importJs('jqueryCalendar');
         $this->importJs(__CLASS__);

         $this->assign('sUrl',$sUrl);
         $this->assign('sUrlAdd',$sUrlAdd);
         $this->assign('aResult',$aResult);
         $this->assign('sImagePath',$sImagePath);
         $this->assign('sPrefix',$this->_sPrefix);
         $this->view(__CLASS__);
     }
}