<?php
require_once('builder/builderInterface.php');

class apiFrontSimpleScheduleCalendar extends Controller_Api
{
    public function post($aArgs)
    {
        usbuilder()->init($this, $aArgs);

		if($aArgs["iMonth"]==''){
			/** If empty set the date to current month */
			$aArgs["iMonth"] = date("n");
		}

		if($aArgs["iYear"]==''){
			/** If empty set the date to current year */
			$aArgs["iYear"]  = date("Y");
		}

		/** Gets the year and month from the PLUGIN.post request **/
	   $iMonth = $aArgs["iMonth"];
	   $iYear  = $aArgs["iYear"];

		/** Inititalized the previous and next month**/
		$prevMonth = ( $iMonth - 1 );
		$nextMonth = ( $iMonth + 1 );

		/** Inititalized the previous and next year**/
		$prevYear = $iYear;
		$nextYear = $iYear;

		/** Inititalized the previous and next year**/
		if($prevMonth == 0 ){
			$prevMonth = 12;
			$prevYear = ( $iYear - 1 );
		}
		if($nextMonth == 13 ){
			$nextMonth = 1;
			$nextYear = ( $iYear + 1 );
	   }

	   /** Gets the dates information (maximum days, start day, current day, current month,current year, etc..)**/
	    $aDays = array();
		$aSchedule = array();
		$timeStamp = mktime(0,0,0,$iMonth,1,$iYear);
		$maxday    = date("t",$timeStamp);
		$thismonth = getdate ($timeStamp);
		$startday  = $thismonth['wday'];
		$currentDay = date('d');
		$currentYear = date('Y');
		$currentMonth = date('m');

		/** Get the total empty days of the last week of month **/
		$timeStampNext = mktime(0,0,0,$iMonth+1,1,$iYear);
		$succeedingMonth = getdate ($timeStampNext);
		$countLastDay  = $succeedingMonth['wday'];
		$lastDay = 0;

		/** Assign total schedule in each day of the month **/
		$iM = str_pad($iMonth,2,'0',STR_PAD_LEFT);
		$today = $iYear."-".$iM;

		for( $i=0; $i< ( $maxday+$startday ); $i++ ){

			if(($i % 7) == 0 ){
				/** Catch only invalid days **/
			}
			if($i < $startday){
				/** Catch only invalid days **/
			}else{
				$iDay = ($i - $startday + 1);
				$iDay = str_pad($iDay,2,'0',STR_PAD_LEFT);
				$todayDate = $today."-".$iDay;

				$aSelectDay = common()->modelFront()->execGetDays($todayDate,$aArgs['seq']);

				/** Stores the total schedule in an array and passed on request in JSON Format **/
				foreach($aSelectDay as $val){
					$totalSchedule = ($val['total_schedule']!=0) ? $val['total_schedule'] : '';
					$aSchedule[] = array("schedDate"=>$todayDate,"totalSchedule"=>$totalSchedule);
				}
				if(($i % 7) == 6 ){
				/** Catch only invalid days **/
				}
			}
		}

		/** Creates the last empty days of the month <td>30</td><td>31</td><td>&nsbp;</td><td>&nsbp;</td>**/
		$lastDay = ((7-$countLastDay)==7) ? 0 : (7-$countLastDay) ;

		/** Sends the the information for the calendar **/
		$aDays[] = array(
			"month"=>$iMonth,
			"year"=>$iYear,
			"startDay"=>$startday,
			"maxDay"=>$maxday,
			"nextMonth"=>$nextMonth,
			"previousMonth"=>$prevMonth,
			"previousYear"=>$prevYear,
			"nextYear"=>$nextYear,
			"currentDay"=>$currentDay,
			"currentMonth"=>$currentMonth,
			"currentYear"=>$currentYear,
			"thisMonth"=>$iMonth,
			"thisYear"=>$iYear,
			"lastDay"=>$lastDay,
			"sSchedInfo"=>$aSchedule
		);
		/** Returns a callback of the date information requested **/
		return $aDays;
    }
}