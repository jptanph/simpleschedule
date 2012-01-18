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

        $iLimit = 5;
        $iPage =(isset($aArgs['page'])) ? $aArgs['page'] : '1';
        $iRow = ($iPage - 1) * $iLimit;

        $sOrderBy = (isset($aArgs['sort']) && isset($aArgs['type']) && isset($aArgs)) ?" ORDER BY " . $aArgs['sort'] . (($aArgs['type']=='des') ? ' desc ' : ' asc ') : 'ORDER BY end_day';
        $sLimit = ' LIMIT ' . ((isset($aArgs['page'])) ?  $iRow . ', ' . $iLimit : $iLimit);

        $this->_sPrefix = 'simpleschedule_';
        $aData = array();
        $model = new modelAdmin();
        $aList = $model->getList($sOrderBy,$sLimit);

//         usbuilder()->vd($aList);
//         return;
        $aCountList = $model->getCountList();

        $iResult = count($aCountList);
        $sUrl = usbuilder()->getUrl('adminPageList');
        $sUrlAdd = usbuilder()->getUrl('adminPageAdd');
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
        $this->importJs('adminPageContent');

        $this->assign('sSort',isset($aArgs['sort']) ? $aArgs['sort'] : '');
        $this->assign('sSortType',(!isset($aArgs['type']) || $aArgs['type']=='asc') ? 'des' : 'asc');

        $this->assign('sPrefix', $this->_sPrefix);
        $this->assign('sImagePath',$sImagePath);
        $this->assign('sPagination',usbuilder()->pagination($iResult, $iLimit));
        $this->assign('sUrl',$sUrl);
        $this->assign('sUrlAdd',$sUrlAdd);
        $this->assign('sKeyword',$aArgs['keyword']);
        $this->assign('aList',$aData);
        $this->view(__CLASS__);
    }
}