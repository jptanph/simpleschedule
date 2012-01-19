<?php
require_once('builder/builderInterface.php');
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

    public function insertRecord($aData)
    {
        $sSql = " INSERT INTO " . SIMPLESCHEDULE_DATA .
        "(title,start_day,start_time,end_day,end_time)
        VALUES
        (
        '{$aData['title']}',
        '{$aData['start_date']}',
        '{$aData['start_time']}',
        '{$aData['end_date']}',
        '{$aData['end_time']}'
        )";

        return $this->query($sSql);

        //UNIX_TIMESTAMP(NOW()))
    }

    public function execDelete($iIdx)
    {
        $sSql = "DELETE FROM " . SIMPLESCHEDULE_DATA . " WHERE idx = " . $iIdx;
        $this->query($sSql);
    }
}