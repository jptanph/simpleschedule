<?php
require_once('builder/builderInterface.php');
define('sPrefix','simpleschedule_');
define('SIMPLESCHEDULE_CONTENTS' , sPrefix . 'contents');
define('SIMPLESCHEDULE_SETTINGS', sPrefix . 'settings');


class modelAdmin extends Model
{
    public function getList($sOrderBy,$sLimit,$sSearchWhere,$sShowType)
    {
        $sSql = "SELECT
        *,
		DATE_FORMAT(NOW(),'%Y-%m-%d %H:00:00') as date_now,
        DATE_FORMAT(DATE_ADD(end_day,INTERVAL end_time HOUR),'%Y-%m-%d %H:00:00') as status_date,
        DATE_FORMAT(DATE_ADD(start_day,INTERVAL start_time HOUR),'%Y/%m/%d %H:00') as start_date,
        DATE_FORMAT(DATE_ADD(end_day,INTERVAL end_time HOUR),'%Y/%m/%d %H:00') as end_date,
        DATE_FORMAT(DATE_ADD(end_day,INTERVAL end_time HOUR),'%Y/%m/%d') as end_date1

        FROM " . SIMPLESCHEDULE_CONTENTS . " $sShowType $sSearchWhere $sOrderBy $sLimit";
//         usbuilder()->vd($sSql);
        return $this->query($sSql);
    }

    public function getCountList($sSearchWhere,$sShowType)
    {
        $sSql = "SELECT * FROM " . SIMPLESCHEDULE_CONTENTS . " $sShowType $sSearchWhere";
        return $this->query($sSql);
    }

    public function getExpected()
    {
        $sSql = "SELECT * FROM " . SIMPLESCHEDULE_CONTENTS;
        return $this->query($sSql);
    }

    public function execDelete($iIdx,$aArgs)
    {
        $sSql = "DELETE FROM " . SIMPLESCHEDULE_CONTENTS . " WHERE idx = " . $iIdx . " AND seq = {$aArgs['seq']}";
        $this->query($sSql);
    }

    public function execCheckSave($aArgs)
    {
        $sSql = "SELECT
        DATE_ADD(start_day,INTERVAL start_time HOUR) as start_date,
        DATE_ADD(end_day,INTERVAL end_time HOUR) as end_date,
        start_time as start_time,
        end_time as end_time
        FROM ". SIMPLESCHEDULE_CONTENTS . " WHERE seq = {$aArgs['seq']}";
        return $this->query($sSql);
    }

    public function execCheckUpdate($aArgs)
    {
		$sSql = "SELECT
		DATE_ADD(start_day,INTERVAL start_time HOUR) as start_date,
		DATE_ADD(end_day,INTERVAL end_time HOUR) as end_date,
		start_time as start_time,
		end_time as end_time
		FROM ". SIMPLESCHEDULE_CONTENTS . " WHERE idx != {$aArgs['idx']} AND seq = {$aArgs['seq']}";

		return $this->query($sSql);
    }

    public function execDateRange()
    {
    	$sSql = "SELECT
    	DATE_FORMAT(MIN(start_day),'%Y/%m/%d') as min_sday,
    	DATE_FORMAT(MAX(end_day),'%Y/%m/%d') AS max_eday
    	FROM " . SIMPLESCHEDULE_CONTENTS;
    	return $this->query($sSql,'row');
    }

    public function execGetExpected()
    {
    	$sSql = "SELECT * FROM " . SIMPLESCHEDULE_CONTENTS . " WHERE DATE_ADD(end_day,INTERVAL end_time HOUR) > DATE_FORMAT(NOW(),'%Y-%m-%d %H:00:00')";
    	return $this->query($sSql);
    }

    public function execGetFinished()
    {
    	$sSql  = "SELECT * FROM " . SIMPLESCHEDULE_CONTENTS . " WHERE DATE_ADD(end_day,INTERVAL end_time HOUR) < DATE_FORMAT(NOW(),'%Y-%m-%d %H:00:00')";
    	return $this->query($sSql);
    }

    public function execGetTotalRecord()
    {
    	$sSql  = "SELECT * FROM " . SIMPLESCHEDULE_CONTENTS;
    	return $this->query($sSql);
    }

    public function execViewRecord($aArgs)
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
		FROM " . SIMPLESCHEDULE_CONTENTS . " WHERE idx = " . $aArgs['idx'] . " AND seq = " . $aArgs['seq'];
		return $this->query($sSql);
    }

    public function execUpdate($aData)
    {
       $sSql = "UPDATE  " . SIMPLESCHEDULE_CONTENTS . "
           SET
           title = '" . $this->filter_data($aData['title']) . "',
           memo = '" . $this->filter_data($aData['memo']) . "',
           map_location = '" . $this->filter_data($aData['location']) . "',
           latitude = '" . $aData['latitude'] . "',
           longitude = '" . $aData['longitude'] . "',
           start_day = '" . $aData['start_date'] . "',
           start_time = '" . $aData['start_time'] . "',
           end_day = '" . $aData['end_date'] . "',
           end_time = '" . $aData['end_time'] . "'

           WHERE idx = ".$aData['idx']." AND seq = {$aData['seq']}
       ";
       return $this->query($sSql);
    }

    public function insertRecord($aData)
    {
            $sSql = " INSERT INTO " . SIMPLESCHEDULE_CONTENTS .
            "(seq,title,memo,map_location,latitude,longitude,start_day,start_time,end_day,end_time,date_created)
            VALUES
            (
            {$aData['seq']},
            '".$this->filter_data($aData['title'])."',
            '".$this->filter_data($aData['memo'])."',
            '".$this->filter_data($aData['location'])."',
            '{$aData['lt_field']}',
            '{$aData['lg_field']}',
            '{$aData['start_date']}',
            '{$aData['start_time']}',
            '{$aData['end_date']}',
            '{$aData['end_time']}',
            UNIX_TIMESTAMP(NOW())
        )";

        return $this->query($sSql);
    }
    public function filter_data($sData)
    {
        $htmlSpecialChars = htmlspecialchars($sData);

        return strip_tags($this->_remove_injection($htmlSpecialChars));
    }

    private function _remove_injection($sData)
    {
        $s = filter_var($sData,FILTER_SANITIZE_STRING);
        return filter_var($s,FILTER_SANITIZE_MAGIC_QUOTES);
    }

    public function deleteContentsBySeq($aSeq)
    {
        $sSeqs = implode(',', $aSeq);
        $sQuery = "DELETE FROM " . SIMPLESCHEDULE_CONTENTS . " WHERE seq in($sSeqs)";
        $mResult = $this->query($sQuery);
        return $mResult;
    }

}