<?php

require_once('builder/builderInterface.php');

class adminPageManage extends Controller_Admin
{
    protected function run($aArgs)
    {
        usbuilder()->init($this, $aArgs);
        usbuilder()->getAppInfo('seq');
        $aOption = array(
            'module_name' => 'Simple Schedule',
        	'default_class' => 'adminPageContents'
        );

        $sHtml = usbuilder()->helper('sequence')->get($aOption)->getManageUI();
    	$this->assign('manage_ui', $sHtml);

    	$this->view(__CLASS__);
    }
}