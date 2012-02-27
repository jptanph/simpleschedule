<?php

require_once('builder/builderInterface.php');

class adminPageView extends Controller_Admin
{
     private $_sPrefix;

     protected function run($aArgs)
     {
         $this->_sPrefix = 'simpleschedule_';
         /** usbuilder initializer.**/
         usbuilder()->init($this, $aArgs);
         usbuilder()->getFormAction($this->_sPrefix . 'edit_form','adminExecUpdate');
         /** usbuilder initializer.**/

         $sImagePath = '/_sdk/img/simpleschedule/';
         $sUrl = usbuilder()->getUrl('adminPageContents');
         $sUrlAdd = usbuilder()->getUrl('adminPageAdd');

         usbuilder()->validator(array('form' => $this->_sPrefix . 'edit_form'));

         if(!is_numeric($aArgs['idx']))
         {
            usbuilder()->jsMove($sUrl);
         }
         else
         {
             $aResult = common()->modelAdmin()->execViewRecord($aArgs);

             if(!$aResult)
             {
                usbuilder()->jsMove($sUrl);
             }
             else
             {
                 $this->externalJS("http://maps.google.com/maps/api/js?sensor=true");
                 $this->externalJS("http://code.google.com/apis/gears/gears_init.js");
                 $this->importJs('googleMapApi');

                 $this->importCss('adminPageContents');
                 $this->importCss('jqueryCalendar');
                 $this->importJs('jqueryCalendar');
                 $this->importJs(__CLASS__);

                 $this->assign('iSeq',$aArgs['seq']);
                 $this->assign('sUrl',$sUrl);
                 $this->assign('sUrlAdd',$sUrlAdd);
                 $this->assign('aResult',$aResult);
                 $this->assign('sImagePath',$sImagePath);
                 $this->assign('sPrefix',$this->_sPrefix);
                 $this->view(__CLASS__);
             }
        }
     }
}