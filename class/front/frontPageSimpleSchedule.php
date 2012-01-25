<?php
require_once('builder/builderInterface.php');

class frontPageSimpleSchedule extends Controller_Front
{
    private $_sHtmlPrefix;
    protected function run($aArgs)
    {
        $this->_sHtmlPrefix = "sdk_simpleschedule_";
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $this->writeJs($sInitScript);

        $sHtml = '';
        $sHtml .= "<div id='{$this->_sHtmlPrefix}holder'>";
        $sHtml .= "<div id='{$this->_sHtmlPrefix}container'>";
        $sHtml .= "    <div id='{$this->_sHtmlPrefix}calendar'></div>";
        $sHtml .= "    <div id='{$this->_sHtmlPrefix}expand'>";
        $sHtml .= "    <div class='pg_scheduleradv_overlay3'>";
        $sHtml .= "    <div class='pg_scheduleradv_overlay4'>";
        $sHtml .= "    <div class='pg_scheduleradv_loader'></div>";
        $sHtml .= "    </div>";
        $sHtml .= "    </div>";
        $sHtml .= "    <div class='{$this->_sHtmlPrefix}output'></div>";
        $sHtml .= "    </div>";
        $sHtml .= "    </div>";
        $sHtml .= "    </div>";
        $sHtml .= "    <div class='{$this->_sHtmlPrefix}overlaycontainer'>";
        $sHtml .= "    </div>";
        $this->importCss(__CLASS__);
        $this->importJs(__CLASS__);
        $this->assign('simpleschedule',$sHtml);
    }
}