<?php

class apiValidateUpdate extends Controller_Api
{
	public function post($aArgs)
	{
		$conflict = 0;
		$start_time = str_pad($_POST['sStartTime'],2,'0',STR_PAD_LEFT) . ':00:00';
		$end_time = str_pad($_POST['sEndTime'],2,'0',STR_PAD_LEFT) . ':00:00';
		
		$start_date = str_replace('/','-',$_POST['sStartDay'] . ' ' . $start_time);
		$end_date = str_replace('/','-',$_POST['sEndDay'] . ' ' . $end_time);

		$model = new modelAdmin();
		$aResult = $model->execCheckUpdate($aArgs['idx']);
		
		foreach($aData as $rows)
		{
			if(
				($start_date>=$rows['start_date'] && $end_date<= $rows['end_date']) //start date greater than db start date and end_date less than db end_date
				|| ($start_date<=$rows['start_date'] && $end_date>= $rows['end_date']) //start date less than db start date and end_date greater than db end_date
				|| ($start_date<=$rows['end_date'] && $end_date>=$rows['start_date'])
			){
				if(
					($_POST['sStartTime']>=$rows['start_time'] && $_POST['sEndTime']<=$rows['end_time'])
					|| ($rows['start_time'] >= $_POST['sStartTime'] && $rows['end_time']<=$_POST['sEndTime'])
					|| ($_POST['sStartTime']<=$rows['end_time']&& $_POST['sEndTime']>=$rows['start_time'])
					|| ($rows['end_time']==$_POST['sStartTime'] || $_POST['sStartTime']==$rows['start_time'])
				){
					$conflict +=1;
				}
			}
		}
		
		
		if($conflict==0)
		{
			$this->aVars['sqlUpdate'] = "UPDATE
			".$this->pgSAC->pgScheduleradvData."
			SET psd_title = '" . $this->_oInput->filter_data($this->aVars['sTitle']) . "',
			psd_memo = '".$this->_oInput->filter_data($this->aVars['sMemo'])."' ,
			psd_map_location = '".$this->_oInput->filter_data($this->aVars['sLocation'])."',
			psd_start_day = '".$this->aVars['sStartDay']."',
			psd_end_day = '".$this->aVars['sEndDay']."',
			psd_start_time=".$_POST['sStartTime'].",
			psd_end_time=".$_POST['sEndTime'].",
			psd_latitude = '".$this->aVars['fLat']."',
			psd_longitude = '".$this->aVars['fLng']."',
			psd_date_updated = NOW() WHERE psd_idx = ".$this->aVars['sPsdIdx']." AND psd_pm_idx = ".$userid;
			$this->utilDb->query($this->aVars['sqlUpdate']);
		}
		else{
			echo "conflict";
		}		
	}
}