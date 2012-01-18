<?php

class adminPageAdd extends Controller_Admin
{
    protected function run($aArgs)
    {
        $this->importCss('plugin');
        $this->view(__CLASS__);
    }
}