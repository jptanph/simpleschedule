<?php
/**
 * @return builderCore
 */
function usbuilder()
{
    require_once('builder/loader.php');
    require_once('builder/conf.func.php');
    require_once('builder/builderCore.php');
    return getInstance('builderCore');
}

/**
 * @return common
 */
function common()
{
    include_once('common.php');
    return getInstance('common');
}
