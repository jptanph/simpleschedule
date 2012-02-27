<?php
require_once('builder/builderInterface.php');

class frontPageSimpleSchedule extends Controller_Front
{
    private $_sHtmlPrefix;
    protected function run($aArgs)
    {
        $this->_sHtmlPrefix = "sdk_simpleschedule_";
        usbuilder()->init($this, $aArgs);
        $iSequence = $this->getSequence();
        $sHtml = '';
        $sHtml .= "<div id='{$this->_sHtmlPrefix}holder$iSequence' class='{$this->_sHtmlPrefix}holder'>";
        $sHtml .= "<div id='{$this->_sHtmlPrefix}container'>";
        $sHtml .= "    <div id='{$this->_sHtmlPrefix}calendar'></div>";
        $sHtml .= "    <div id='{$this->_sHtmlPrefix}expand'>";
        $sHtml .= "    <div class='{$this->_sHtmlPrefix}overlay3'>";
        $sHtml .= "    <div class='{$this->_sHtmlPrefix}overlay4'>";
        $sHtml .= "    <div class='pg_scheduleradv_loader'></div>";
        $sHtml .= "    </div>";
        $sHtml .= "    </div>";
        $sHtml .= "    <div class='{$this->_sHtmlPrefix}output' id='{$this->_sHtmlPrefix}output$iSequence'></div>";
        $sHtml .= "    </div>";
        $sHtml .= "    </div>";
        $sHtml .= "    </div>";
        $sHtml .= "    <div class='{$this->_sHtmlPrefix}overlaycontainer' id='{$this->_sHtmlPrefix}overlaycontainer$iSequence'></div>";
        $this->importCss(__CLASS__);
        $this->importJs(__CLASS__);
        $this->importJs('googleMapApi');
        $this->assign('simpleschedule',$sHtml);
    }
}