<?php

define('sPrefix','simpleschedule_');
define('SIMPLESCHEDULE_DATA' , sPrefix . 'data');
define('SIMPLESCHEDULE_SETTINGS', sPrefix . 'settings');


class modelAdmin extends Model
{
    public function getList($sOrderBy,$sLimit)
    {
        $sSql = "SELECT * FROM " . SIMPLESCHEDULE_DATA . " $sOrderBy $sLimit";
        return $this->query($sSql);
    }

    public function getCountList()
    {
        $sSql = "SELECT * FROM " . SIMPLESCHEDULE_DATA;
        return $this->query($sSql);
    }

    public function getExpected()
    {
        $sSql = "SELECT * FROM " . SIMPLESCHEDULE_DATA;
        return $this->query($sSql);
    }

    public function insertSchedule($aData)
    {

    }
}