<?php
require_once('builder/builderInterface.php');
class apiAdminValidateUpdate extends Controller_Api
{

	public function post($aArgs)
	{
	    usbuilder()->init($this, $aArgs);
		$conflict = 0;
        $sStartTime  = str_pad($aArgs['start_time'],2,'0',STR_PAD_LEFT) . ':00:00';
        $sEndTime = str_pad($aArgs['end_time'],2,'0',STR_PAD_LEFT) . ':00:00';

        $sStartDate = str_replace('/','-',$aArgs['start_date'] . ' ' . $sStartTime);
        $sEndDate = str_replace('/','-',$aArgs['end_date'] . ' ' . $sEndTime);

		$aData = common()->modelAdmin()->execCheckUpdate($aArgs);

		foreach($aData as $rows)
		{
			if(
				($sStartDate>=$rows['start_date'] && $sEndDate<= $rows['end_date']) //start date greater than db start date and end_date less than db end_date
				|| ($sStartDate<=$rows['start_date'] && $sEndDate>= $rows['end_date']) //start date less than db start date and end_date greater than db end_date
				|| ($sStartDate<=$rows['end_date'] && $sEndDate>=$rows['start_date'])
			){
				if(
					($aArgs['start_time']>=$rows['start_time'] && $aArgs['end_time']<=$rows['end_time'])
					|| ($rows['start_time'] >= $aArgs['start_time'] && $rows['end_time']<=$aArgs['end_time'])
					|| ($aArgs['start_time']<=$rows['end_time'] && $aArgs['end_time']>=$rows['start_time'])
					|| ($rows['end_time']==$aArgs['start_time'] || $aArgs['start_time']==$rows['start_time'])
				){
					$conflict +=1;
				}
			}
		}

        return $conflict;
	}
}