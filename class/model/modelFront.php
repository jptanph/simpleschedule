<?php
require_once('builder/builderInterface.php');
define('sPrefix','simpleschedule_');
define('SIMPLESCHEDULE_CONTENTS' , sPrefix . 'contents');

class modelFront extends Model
{
    public function execGetDays($todayDate,$rows)
    {
        $sSql = "SELECT COUNT(idx) as total_schedule
            FROM ". SIMPLESCHEDULE_CONTENTS . "
            WHERE
            (date(start_day) <= '$todayDate')
            AND
            (date(end_day) >= '$todayDate')
            AND seq = $rows
            ORDER BY start_day DESC";
        return $this->query($sSql);
    }

    public function execViewSchedule($sSchedDate,$iSeq)
    {
        $sSql = "SELECT * FROM  ". SIMPLESCHEDULE_CONTENTS . "  WHERE (date(start_day) <= '{$sSchedDate}') AND (date(end_day) >= '{$sSchedDate}') AND seq = $iSeq ORDER BY start_time DESC";
        return $this->query($sSql);
    }

    public function execViewInfo($iIdx,$iSequence)
    {
        $sSql = "SELECT idx, title,map_location,memo,latitude,longitude FROM "  . SIMPLESCHEDULE_CONTENTS . " WHERE idx = $iIdx AND seq = $iSequence";
        return $this->query($sSql);
    }

    public function execCheckSeq($iSequence)
    {
        $sSql = "SELECT seq
        FROM ". SIMPLESCHEDULE_CONTENTS . "
        WHERE
        seq = $iSequence";
        return $this->query($sSql,'row');
    }
}
