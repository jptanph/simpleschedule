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

        /** query string generator here.**/
        $sQryRow = isset($aArgs['row']) ? '&row=' . $aArgs['row'] : '';
        $sQryShow = isset($aArgs['show']) ? '&show=' . $aArgs['show'] : '';
        $sQrySE = (isset($aArgs['start_date']) && isset($aArgs['end_date'])) ? "&start_date=" . $aArgs['start_date'] . '&end_date=' . $aArgs['end_date'] : '';
        $sQryKeyword = (isset($aArgs['keyword'])) ? "&keyword=" . $aArgs['keyword'] : '';
        $sQryDateRange = (isset($aArgs['date_range'])) ? "&date_range=" . $aArgs['date_range'] : '';
        $sQryFieldSearch = (isset($aArgs['field_search'])) ? "&field_search=".$aArgs['field_search'] : '';
        $sQrySort = (isset($aArgs['sort']) &&  isset($aArgs['type'])) ? "&sort=".$aArgs['sort']."&type=".$aArgs['type'] : '';
        $sQryPage = (isset($aArgs['page'])) ? "&page=".$aArgs['page'] : '';
        /** query string generator here.**/

        $sHasWhere = isset($aArgs['show']) ? '' :  ' WHERE ';
        $sHasShow  = (isset($aArgs['keyword']) &&
                isset($aArgs['start_date']) &&
                isset($aArgs['end_date']) &&
                isset($aArgs['field_search'])) ? ' WHERE ' : ' WHERE ';

        $sHasAnd  = (isset($aArgs['keyword']) &&
                isset($aArgs['start_date']) &&
                isset($aArgs['end_date']) &&
                isset($aArgs['field_search'])) ? ' AND ' : '';

        $sSE = '';
        if($aArgs['sort']=='end_day' || $aArgs['sort']=='start_day'){
             $sSE .= " DATE_ADD(".$aArgs['sort'].", INTERVAL ";
                 if($aArgs['sort']=='end_day'){
                     $sSE.=" end_time HOUR)";
                 }elseif($aArgs['sort']=='start_day'){
                     $sSE.=" start_time HOUR)";
                 }
        }else{
            $sSE = $aArgs['sort'];
        }

        $sOrderBy = (isset($aArgs['sort']) && isset($aArgs['type']) && isset($aArgs)) ?" ORDER BY " . $sSE . (($aArgs['type']=='des') ? ' desc ' : ' asc ') : ' ORDER BY date_created DESC ';
        $sLimit = ' LIMIT ' . ((isset($aArgs['page'])) ?  $iRow . ', ' . $iLimit : $iLimit);
		$sSearchWhere = (isset($aArgs['keyword']) &&
					isset($aArgs['start_date']) &&
					isset($aArgs['end_date']) &&
					isset($aArgs['field_search'])) ?
					" $sHasWhere
					  ((DATE_FORMAT( start_day,  '%Y/%m/%d' ) >= '" . $aArgs['start_date'] . "' AND DATE_FORMAT( end_day,  '%Y/%m/%d' )  <= '" . $aArgs['end_date'] . "')
						OR
					  (DATE_FORMAT( start_day,  '%Y/%m/%d' ) <= '" . $aArgs['start_date'] . "' AND DATE_FORMAT( end_day,  '%Y/%m/%d' )  >= '" . $aArgs['end_date']."')
					  )
					  AND " . $aArgs['field_search'] . " LIKE '%".trim($aArgs['keyword'])."%'"
					:
					'';
		$sShow = (isset($aArgs['show'])) ? $aArgs['show'] : '';
		$sShowType = $this->_showType($sShow,$sHasShow,$sHasAnd);

        $this->_sPrefix = 'simpleschedule_';
        $aData = array();
        $model = new modelAdmin();
        $aList = $model->getList($sOrderBy,$sLimit,$sSearchWhere,$sShowType);
        $aCountList = $model->getCountList($sSearchWhere,$sShowType);

        $iResult = count($aCountList);
        $sUrlList = usbuilder()->getUrl('adminPageList');
        $sUrlAdd = usbuilder()->getUrl('adminPageAdd');
        $sUrlView = usbuilder()->getUrl('adminPageView');
        $incRow = 0;

        foreach($aList as $rows)
        {
           $aData[] = array(
                'row' => (($iPage==1) ? ( $iResult - $incRow ) : ($iResult-$iRow) - $incRow),
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
        $this->importJs(__CLASS__);

        $this->assign('sSort',isset($aArgs['sort']) ? $aArgs['sort'] : '');
        $this->assign('sSortType',(!isset($aArgs['type']) || $aArgs['type']=='asc') ? 'des' : 'asc');

        /** query strings assigns.**/
        $this->assign('sQryRow',$sQryRow);
        $this->assign('sQryShow',$sQryShow);
        $this->assign('sQrySEDate',$sQrySE);
        $this->assign('sQryKeyword',$sQryKeyword);
        $this->assign('sQryDateRange',$sQryDateRange);
        $this->assign('sQryFieldSearch',$sQryFieldSearch);
        $this->assign('sQrySort',$sQrySort);
        $this->assign('sQryPage',$sQryPage);
        /** query strings assigns.**/

        $this->assign('sFirstDay',($aArgs['start_date']) ? $aArgs['start_date'] : date("Y/m/") . '01');
        $this->assign('sLastDay',($aArgs['end_date']) ? $aArgs['end_date'] : date("Y/m/t"));
        $this->assign('sPrefix', $this->_sPrefix);
        $this->assign('iResult',count($model->execGetTotalRecord()));
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

    private function _showType($sViewType,$sHasShow,$sHasAnd)
    {
    	$sSqlViewType = '';
    	if($sViewType=='finished'){
    		$sSqlViewType = " $sHasShow DATE_ADD(end_day,INTERVAL end_time HOUR) < DATE_FORMAT(NOW(),'%Y-%m-%d %H:00:00') $sHasAnd ";
    	}elseif($sViewType=='expected'){
    		$sSqlViewType = " $sHasShow DATE_ADD(end_day,INTERVAL end_time HOUR) > DATE_FORMAT(NOW(),'%Y-%m-%d %H:00:00') $sHasAnd ";
    	}else{
    		$sSqlViewType = '';
    	}
    	return $sSqlViewType;
    }
}