<?php
require_once('builder/builderInterface.php');
define('sPrefix','simpleschedule_');
define('SIMPLESCHEDULE_DATA' , sPrefix . 'data');
define('SIMPLESCHEDULE_SETTINGS', sPrefix . 'settings');


class modelFront extends Model
{
    public function execGetDays($todayDate)
    {
        $sSql = "SELECT COUNT(idx) as total_schedule FROM ". SIMPLESCHEDULE_DATA . " WHERE (date(start_day) <= '$todayDate') AND (date(end_day) >= '$todayDate') ORDER BY start_day DESC";
        return $this->query($sSql);
    }
}