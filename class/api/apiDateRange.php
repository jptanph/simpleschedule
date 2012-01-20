<?php
require_once('builder/builderInterface.php');

class apiDateRange extends Controller_Api
{
	public function post($aArgs)
	{
		$model = new modelAdmin();
		$aDate = array();
		$sDate = '';
		$eDate = '';
		
		switch($aArgs['requestDate']){
		
			case'today':
				$sDate = date("Y/m/d");
				$eDate = date("Y/m/d");
				break;
		
			case'currentWeek':
				$timestamp = time();
				$sDate = date("Y/m/d", strtotime("last sunday", $timestamp));
				$eDate = date("Y/m/d", strtotime("next saturday", $timestamp));
				break;
		
			case'currentMonth':
				$sDate = date("Y/m")."/01";
				$eDate = date("Y/m/t");
				break;
		
			case'currentYear':
				$sDate = date("Y/01/01");
				$eDate = date("Y/12/31");
				break;
		
			case'all':
				$aResult = $model->execDateRange();

				$sDate =  $aResult['min_sday'];
				$eDate =  $aResult['max_eday'];
			break;	
		}
		$aDate['sDate'] =  $sDate;
		$aDate['eDate'] =  $eDate;
		return $aDate;
	}
}