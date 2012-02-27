<?php

require_once('builder/builderInterface.php');

class adminPageContents extends Controller_Admin
{
    private $_sPrefix;

    protected function run($aArgs)
    {
        $iQryStrStatus = 0;

        /** usbuilder initializer.**/
        $sInitScript = usbuilder()->init($this, $aArgs);
        /** usbuilder initializer.**/

        /** common urls.**/
        $sUrlList = usbuilder()->getUrl('adminPageContents');
        $sUrlAdd = usbuilder()->getUrl('adminPageAdd');
        $sUrlView = usbuilder()->getUrl('adminPageView');
        /** common urls.**/

        /** FOR PAGE REDIRECTION (IF THE FOLLOWING VARIABLES BELOW IS INVALID.).**/
            if(isset($aArgs['search'])){
                if($aArgs['search']!=='init'){
                    usbuilder()->jsMove($sUrlList);
                    $iQryStrStatus +=1;
                }else{
                    if(
                        !isset($aArgs['keyword']) ||
                        !isset($aArgs['start_date']) ||
                        !isset($aArgs['end_date']) ||
                        !isset($aArgs['date_range']) ||
                        !isset($aArgs['field_search'])
                    )
                    {
                        usbuilder()->jsMove($sUrlList);
                        $iQryStrStatus +=1;
                    }
                }
            }
            /** for FIELD SEARCH **/
            if(isset($aArgs['field_search']))
            {
                if(trim($aArgs['field_search'])!=='title' && trim($aArgs['field_search'])!=='memo')
                {
                   usbuilder()->jsMove($sUrlList);
                   $iQryStrStatus +=1;
                }
                else
                {
                    /** ok here.**/
                }
            }
            /** FOR FIELD SEARCH **/

            /** FOR DATE RANGE. **/
            if(isset($aArgs['date_range']))
            {
                if(
                    trim($aArgs['date_range'])!=='today' &&
                    trim($aArgs['date_range'])!=='currentMonth' &&
                    trim($aArgs['date_range'])!=='currentWeek' &&
                    trim($aArgs['date_range'])!=='currentYear' &&
                    trim($aArgs['date_range'])!=='customSearch' &&
                    trim($aArgs['date_range'])!=='all'
                    )
                {
                    usbuilder()->jsMove($sUrlList);
                    $iQryStrStatus +=1;
                }
                else
                {
                    /** ok here.**/
                }
            }
            /** FOR DATE RANGE. **/

            /** FOR SORTING OF RECORDS.**/
            if(isset($aArgs['sort']) | isset($Args['type']))
            {
                if($aArgs['type']!=='asc' && $aArgs['type'] !=='des')
                {
                    usbuilder()->jsMove($sUrlList);
                    $iQryStrStatus +=1;
                }

                if(
                    $aArgs['sort']!=='title' &&
                    $aArgs['sort'] !=='start_day' &&
                    $aArgs['sort'] !=='end_day'
                )
                {

                    usbuilder()->jsMove($sUrlList);

                    $iQryStrStatus +=1;
                }
            }
            /** FOR SORTING OF RECORDS.**/


            /** FOR SHOW TYPE.**/
            if(isset($aArgs['show']))
            {
                if($aArgs['show'] !=='expected' && $aArgs['show']!=='finished')
                {
                    usbuilder()->jsMove($sUrlList);

                    $iQryStrStatus +=1;
                }
            }
            /** FOR SHOW TYPE.**/

            /** FOR ROWS**/
            if(isset($aArgs['row']))
            {
                if(
                    !is_numeric($aArgs['row']) ||
                    $aArgs['row'] !=='10' &&
                    $aArgs['row'] !=='20' &&
                    $aArgs['row'] !=='30' &&
                    $aArgs['row'] !=='50' &&
                    $aArgs['row'] !=='100'
                )
                {
                    usbuilder()->jsMove($sUrlList);

                    $iQryStrStatus +=1;
                }
            }
            /** FOR ROWS**/

            /** FOR DATE **/
            if(isset($aArgs['start_date']) || isset($aArgs['end_date']))
            {
                if(!$this->checkDateFormat($aArgs['start_date']) && $this->checkDateFormat($aArgs['end_date']))
                {
                    usbuilder()->jsMove($sUrlList);

                    $iQryStrStatus +=1;
                }
            }
            /** FOR DATE **/

        /** FOR PAGE REDIRECTION (IF THE FOLLOWING VARIABLES ABOVE IS INVALID.).**/

        if($iQryStrStatus==0){

            $iLimit = (isset($aArgs['row'])) ? $aArgs['row'] : 20;
            $iPage =(isset($aArgs['page'])) ? $aArgs['page'] : '1';
            $iRow = ($iPage - 1) * $iLimit;


         /** query string generator here.**/
            $sQryRow = isset($aArgs['row']) ? '&row=' . $aArgs['row'] : '';
            $sQryShow = isset($aArgs['show']) ? '&show=' . $aArgs['show'] : '';
            $sQrySE = (isset($aArgs['start_date']) && isset($aArgs['end_date'])) ? "&start_date=" . $aArgs['start_date'] . '&end_date=' . $aArgs['end_date'] : '';
            $sQryKeyword = (isset($aArgs['keyword'])) ? "&keyword=" . $aArgs['keyword'] : '';
            $sQryDateRange = (isset($aArgs['date_range'])) ? "&date_range=" . $aArgs['date_range'] : '';
            $sQryFieldSearch = (isset($aArgs['field_search'])) ? "&field_search=".$this->filter_data($aArgs['field_search']) : '';
            $sQrySort = (isset($aArgs['sort']) &&  isset($aArgs['type'])) ? "&sort=".$aArgs['sort']."&type=".$aArgs['type'] : '';
            $sQryPage = (isset($aArgs['page'])) ? "&page=".$aArgs['page'] : '';
            /** query string generator here.**/

            $sHasWhere = isset($aArgs['show']) ? ' AND ' :  ' AND ';
            $sHasShow  = (isset($aArgs['keyword']) &&
                    isset($aArgs['start_date']) &&
                    isset($aArgs['end_date']) &&
                    isset($aArgs['field_search'])) ? '  ' : '  ';

            $sHasAnd  = (isset($aArgs['keyword']) &&
                    isset($aArgs['start_date']) &&
                    isset($aArgs['end_date']) &&
                    isset($aArgs['field_search'])) ? '  ' : '';

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
    		$sSearchWhere = (
                isset($aArgs['keyword']) &&
    			isset($aArgs['start_date']) &&
    			isset($aArgs['end_date']) &&
    			isset($aArgs['field_search'])) &&
    			isset($aArgs['seq'])
    			?
    				" $sHasWhere
    				  ((DATE_FORMAT( start_day,  '%Y/%m/%d' ) >= '" . $this->filter_data($aArgs['start_date']) . "' AND DATE_FORMAT( end_day,  '%Y/%m/%d' )  <= '" . $this->filter_data($aArgs['end_date']) . "')
    					OR
    				  (DATE_FORMAT( start_day,  '%Y/%m/%d' ) <= '" . $this->filter_data($aArgs['start_date']) . "' AND DATE_FORMAT( end_day,  '%Y/%m/%d' )  >= '" . $this->filter_data($aArgs['end_date'])."')
    				  )
    				  AND " . $aArgs['field_search'] . " LIKE '%".$this->filter_data(trim($aArgs['keyword']))."%' "
    			: " ";
    		$sShow = (isset($aArgs['show'])) ? $aArgs['show'] : '';
    		$sShowType = $this->_showType($sShow,$sHasShow,$sHasAnd,$aArgs);

            $this->_sPrefix = 'simpleschedule_';
            $aData = array();
            $aList = common()->modelAdmin()->getList($sOrderBy,$sLimit,$sSearchWhere,$sShowType);
            $aCountList = common()->modelAdmin()->getCountList($sSearchWhere,$sShowType);

            $iResult = count($aCountList);
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
                'end_date'=>(($rows['end_time']==24) ? $rows['end_date1'] . ' ' . '24:00' : $rows['end_date']),
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

            $this->assign('sSeq',$aArgs['seq']);
            $this->assign('sFirstDay',($aArgs['start_date']) ? $this->filter_data($aArgs['start_date']) : date("Y/m/") . '01');
            $this->assign('sLastDay',($aArgs['end_date']) ? $this->filter_data($aArgs['end_date']) : date("Y/m/t"));
            $this->assign('sPrefix', $this->_sPrefix);
            $this->assign('iResult',count(common()->modelAdmin()->execGetTotalRecord()));
            $this->assign('iFinished',count(common()->modelAdmin()->execGetFinished()));
            $this->assign('iExpected',count(common()->modelAdmin()->execGetExpected()));
            $this->assign('sDateRange',$aArgs['date_range']);
            $this->assign('sImagePath',$sImagePath);
            $this->assign('sPagination',(!$aData) ? '' : usbuilder()->pagination($iResult, $iLimit));
            $this->assign('sUrlList',$sUrlList);
            $this->assign('sFieldSearch',$this->filter_data($aArgs['field_search']));
            $this->assign('sUrlAdd',$sUrlAdd);
            $this->assign('sUrlView',$sUrlView);
            $this->assign('sRows',(isset($aArgs['row'])) ? $aArgs['row'] : '20');
            $this->assign('sKeyword',$aArgs['keyword']);
            $this->assign('aList',$aData);
            $this->view(__CLASS__);

        }
    }

    private function _showType($sViewType,$sHasShow,$sHasAnd,$aArgs)
    {
    	$sSqlViewType = '';
    	if($sViewType=='finished')
    	{
    		$sSqlViewType = "  WHERE seq = {$aArgs['seq']} AND $sHasShow DATE_ADD(end_day,INTERVAL end_time HOUR) < DATE_FORMAT(NOW(),'%Y-%m-%d %H:00:00') $sHasAnd AND seq={$aArgs['seq']}";
    	}
    	elseif($sViewType=='expected')
    	{
    		$sSqlViewType = " WHERE seq = {$aArgs['seq']} AND $sHasShow DATE_ADD(end_day,INTERVAL end_time HOUR) > DATE_FORMAT(NOW(),'%Y-%m-%d %H:00:00') $sHasAnd  AND seq={$aArgs['seq']}";
    	}
    	else
    	{
    		$sSqlViewType = " WHERE seq = {$aArgs['seq']}";
    	}
    	return $sSqlViewType;
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

    private function checkDateFormat($sDate)
    {
        return preg_match( '`^\d{4}/\d{1,2}/\d{1,2}$`', $sDate );
    }
}