<?php

require_once('builder/builderInterface.php');
class adminPageList extends Controller_Admin
{
    private $_sPrefix;

    protected function run($aArgs)
    {

        /** usbuilder initializer.**/
        $sInitScript = usbuilder()->init($this->Request->getAppID(), $aArgs);
        $this->writeJs($sInitScript);
        /** usbuilder initializer.**/

        $iLimit = (isset($aArgs['row'])) ? $aArgs['row'] : 20;
        $iPage =(isset($aArgs['page'])) ? $aArgs['page'] : '1';
        $iRow = ($iPage - 1) * $iLimit;

        $sQryRow = isset($aArgs['row']) ? '&row=' . $aArgs['row'] : '';

        $sOrderBy = (isset($aArgs['sort']) && isset($aArgs['type']) && isset($aArgs)) ?" ORDER BY " . $aArgs['sort'] . (($aArgs['type']=='des') ? ' desc ' : ' asc ') : 'ORDER BY end_day';
        $sLimit = ' LIMIT ' . ((isset($aArgs['page'])) ?  $iRow . ', ' . $iLimit : $iLimit);
		$sSearchWhere = (isset($aArgs['keyword']) && 
					isset($aArgs['start_date']) && 
					isset($aArgs['end_date']) && 
					isset($aArgs['field_search'])) ? 
					" WHERE
					  ((DATE_FORMAT( start_day,  '%Y/%m/%d' ) >= '" . $aArgs['start_date'] . "' AND DATE_FORMAT( end_day,  '%Y/%m/%d' )  <= '" . $aArgs['end_date'] . "')
						OR
					  (DATE_FORMAT( start_day,  '%Y/%m/%d' ) <= '" . $aArgs['start_date'] . "' AND DATE_FORMAT( end_day,  '%Y/%m/%d' )  >= '" . $aArgs['start_date']."')
					  )
					  AND " . $aArgs['field_search'] . " LIKE '%".$aArgs['keyword']."'" 
					: 
					'';
		
        $this->_sPrefix = 'simpleschedule_';
        $aData = array();
        $model = new modelAdmin();
        $aList = $model->getList($sOrderBy,$sLimit,$sSearchWhere);
        $aCountList = $model->getCountList();

        $iResult = count($aCountList);
        $sUrlList = usbuilder()->getUrl('adminPageList');
        $sUrlAdd = usbuilder()->getUrl('adminPageAdd');
        $sUrlView = usbuilder()->getUrl('adminPageView');
        $incRow = 0;

        foreach($aList as $rows)
        {
           $aData[] = array(
                'row' => (($iPage==1) ? ( $iResult - $incRow ) : ($iResult-$iRow)-$incRow),
                'idx' => $rows['idx'],
                'title' => $rows['title'],
                'map_location' => $rows['map_location'],
                'latitude' => $rows['latitude'],
                'longtitude' => $rows['longtitude'],
                'longtitude' => $rows['longtitude'],
                'start_day' => $rows['start_day'],
                'start_time' => $rows['start_time'],
                'end_day' => $rows['end_day'],
                'end_time' => $rows['end_time'],
                'is_recursive' => $rows['is_recursive'],
                'date_created' => $rows['date_created'],
                'start_date' => $rows['start_date'],
                'end_date' => $rows['end_date'],
           		'status' => ((strtotime($rows['status_date'])<=strtotime($rows['date_now'])) ? 'Finished' : 'Expected')
           );
           $incRow++;
        }

        $sImagePath = '/_sdk/img/simpleschedule/';
        $this->importCss(__CLASS__);
        $this->importCss('jqueryCalendar');

        $this->importJs('jqueryCalendar');
        $this->importJs('jqueryShiftCheckbox');
        $this->importJs('adminPageContent');

        $this->assign('sSort',isset($aArgs['sort']) ? $aArgs['sort'] : '');
        $this->assign('sSortType',(!isset($aArgs['type']) || $aArgs['type']=='asc') ? 'des' : 'asc');

        /** query strings**/
        $this->assign('sQryRow',$sQryRow);
        $this->assign('iResult',$iResult);
        
        $this->assign('sFirstDay',($aArgs['start_date']) ? $aArgs['start_date'] : date("Y/m/") . '01');
        $this->assign('sLastDay',($aArgs['end_date']) ? $aArgs['end_date'] : date("Y/m/t"));
        $this->assign('sPrefix', $this->_sPrefix);
        $this->assign('iFinished',count($model->execGetFinished()));
        $this->assign('iExpected',count($model->execGetExpected()));
        $this->assign('sDateRange',$aArgs['date_range']);        
        $this->assign('sImagePath',$sImagePath);
        $this->assign('sPagination',(!$aData) ? '' : usbuilder()->pagination($iResult, $iLimit));
        $this->assign('sUrlList',$sUrlList);
        $this->assign('sFieldSearch',$aArgs['field_search']);
        $this->assign('sUrlAdd',$sUrlAdd);
        $this->assign('sUrlView',$sUrlView);
        $this->assign('sRows',(isset($aArgs['row'])) ? $aArgs['row'] : '20');
        $this->assign('sKeyword',$aArgs['keyword']);
        $this->assign('aList',$aData);
        $this->view(__CLASS__);
    }
}