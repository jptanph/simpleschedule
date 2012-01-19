<?php
require_once('builder/builderInterface.php');

class adminPageView extends Controller_Admin
{

     protected function run($aArgs)
     {
         /** usbuilder initializer.**/
         $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
         $this->writeJs($sInitScript);
         /** usbuilder initializer.**/

         $sImagePath = '/_sdk/img/simpleschedule/';
         $sUrl = usbuilder()->getUrl('adminPageList');
         $sUrlAdd = usbuilder()->getUrl('adminPageAdd');

         $this->importCss('adminPageList');
         $this->assign('sUrl',$sUrl);
         $this->assign('sUrlAdd',$sUrlAdd);
         $this->assign('sImagePath',$sImagePath);
         $this->view(__CLASS__);
     }
}