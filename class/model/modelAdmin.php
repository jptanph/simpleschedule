<?php
require_once('builder/builderInterface.php');
define('sPrefix','simpleschedule_');
define('SIMPLESCHEDULE_DATA' , sPrefix . 'data');
define('SIMPLESCHEDULE_SETTINGS', sPrefix . 'settings');


class modelAdmin extends Model
{
    public function getList($sOrderBy,$sLimit)
    {
        $sSql = "SELECT
        *,
        DATE_FORMAT(DATE_ADD(end_day,INTERVAL end_time HOUR),'%Y-%m-%d %H:00:00') as status_date,
		DATE_FORMAT(NOW(),'%Y-%m-%d %H:00:00') as date_now,        
        DATE_FORMAT(DATE_ADD(start_day,INTERVAL start_time HOUR),'%Y/%m/%d %H:00') as start_date,
        DATE_FORMAT(DATE_ADD(end_day,INTERVAL end_time HOUR),'%Y/%m/%d %H:00') as end_date
        FROM " . SIMPLESCHEDULE_DATA . " $sOrderBy $sLimit";
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
        //UNIX_TIMESTAMP(NOW()))

        $sSql = " INSERT INTO " . SIMPLESCHEDULE_DATA .
        "(title,memo,map_location,start_day,start_time,end_day,end_time)
        VALUES
        (
        '{$aData['title']}',
        '{$aData['memo']}',
        '{$aData['location']}',
        '{$aData['start_date']}',
        '{$aData['start_time']}',
        '{$aData['end_date']}',
        '{$aData['end_time']}'
        )";

        return $this->query($sSql);

    }

    public function execDelete($iIdx)
    {
        $sSql = "DELETE FROM " . SIMPLESCHEDULE_DATA . " WHERE idx = " . $iIdx;
        $this->query($sSql);
    }

    public function execCheckSave()
    {
        $sSql = "SELECT
        DATE_ADD(start_day,INTERVAL start_time HOUR) as start_date,
        DATE_ADD(end_day,INTERVAL end_time HOUR) as end_date,
        start_time as start_time,
        end_time as end_time
        FROM ". SIMPLESCHEDULE_DATA;
        return $this->query($sSql);
    }

    public function execCheckUpdate($idx)
    {
		$sSql = "SELECT
		DATE_ADD(start_day,INTERVAL start_time HOUR) as start_date,
		DATE_ADD(end_day,INTERVAL end_time HOUR) as end_date,
		start_time as start_time,
		end_time as end_time 
		FROM ". SIMPLESCHEDULE_DATA . " WHERE psd_idx != $idx";
		return $this->query($sSql);		
    }
    
    public function execDateRange()
    {
    	$sSql = "SELECT 
    	DATE_FORMAT(MIN(start_day),'%Y/%m/%d') as min_sday,
    	DATE_FORMAT(MAX(end_day),'%Y/%m/%d') AS max_eday 
    	FROM " . SIMPLESCHEDULE_DATA;
    	return $this->query($sSql,'row');
    }
    
    public function execGetExpected()
    {
    	$sSql = "SELECT * FROM " . SIMPLESCHEDULE_DATA . " WHERE DATE_ADD(end_day,INTERVAL end_time HOUR) > DATE_FORMAT(NOW(),'%Y-%m-%d %H:00:00')";
    	return $this->query($sSql);
    }
    
    public function execGetFinished()
    {
    	$sSql  = "SELECT * FROM " . SIMPLESCHEDULE_DATA . " WHERE DATE_ADD(end_day,INTERVAL end_time HOUR) < DATE_FORMAT(NOW(),'%Y-%m-%d %H:00:00')";
    	return $this->query($sSql);
    }
    
    public function execViewRecord($iIdx)
    {

		$aData = array();
		$sSql = "SELECT 
		idx,
		title,
		memo,
		map_location,
		latitude,
		longitude,
		start_time,
		end_time,
		DATE_FORMAT(start_day,'%Y/%m/%d') as start_day,
		DATE_FORMAT(end_day,'%Y/%m/%d') as end_day 
		FROM " . SIMPLESCHEDULE_DATA . " WHERE idx = " . $iIdx;		
		return $this->query($sSql);
		
    }
}