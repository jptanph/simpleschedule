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

        $this->_sPrefix = 'simpleschedule_';
        $aData = array();
        $model = new modelAdmin();
        $aList = $model->getList($sOrderBy,$sLimit);
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
                'date_created' => $rows['date_created']
           );
           $incRow++;
        }


        $sImagePath = '/_sdk/img/simpleschedule/';
        $this->importCss(__CLASS__);
        $this->importCss('jqueryCalendar');




        $this->importJs('jqueryCalendar');

        $this->importJs('adminPageContent');

        $this->assign('sSort',isset($aArgs['sort']) ? $aArgs['sort'] : '');
        $this->assign('sSortType',(!isset($aArgs['type']) || $aArgs['type']=='asc') ? 'des' : 'asc');

        /** query strings**/
        $this->assign('sQryRow',$sQryRow);

        $this->assign('sPrefix', $this->_sPrefix);
        $this->assign('sImagePath',$sImagePath);
        $this->assign('sPagination',(!$aData) ? '' : usbuilder()->pagination($iResult, $iLimit));
        $this->assign('sUrlList',$sUrlList);
        $this->assign('sUrlAdd',$sUrlAdd);
        $this->assign('sUrlView',$sUrlView);
        $this->assign('sRows',(isset($aArgs['row'])) ? $aArgs['row'] : '20' );
        $this->assign('sKeyword',$aArgs['keyword']);
        $this->assign('aList',$aData);
        $this->view(__CLASS__);
    }
}