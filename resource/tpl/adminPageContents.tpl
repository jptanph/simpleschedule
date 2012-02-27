<div id="sdk_message_box"></div>
<!-- table header -->
<input type='hidden' id="<?php echo $sPrefix;?>seq" value="<?php echo $sSeq;?>">
<table border="1" cellpadding="0" cellspacing="0" class="table_hor_03">
    <tr>
        <td>
            <table cellpadding="3" cellspacing="3">
                <tr>
                    <td><span  class="title">Show by</span></td>
                    <td>
                        <select class="optionbox" id="date_range" onchange="adminPageContents.execDateRange();">
                            <option value="customSearch">Customized Search</option>
                            <option value="today" <?php if($sDateRange=='today'){?> selected="selected" <?php }?>>Today</option>
                            <option value="currentWeek" <?php if($sDateRange=='currentWeek'){?> selected="selected" <?php }?>>Current Week</option>
                            <option value="currentMonth"  <?php if($sDateRange=='currentMonth' || $sDateRange==''){?> selected="selected" <?php }?>>Current Month</option>
                            <option value="currentYear" <?php if($sDateRange=='currentYear'){?> selected="selected" <?php }?>>Current Year</option>
                            <option value="all" <?php if($sDateRange=='all'){?> selected="selected" <?php }?>>All</option>
                        </select>
                    </td>
                    <td><span  class="title">Start Date:</span> <input type="text" class="input_text" readonly="readonly"  id="<?php echo $sPrefix ?>start_date" value="<?php echo $sFirstDay;?>" onclick="adminPageContents.customSearch()" title="Start Date"/><a href="#"><label for="<?php echo $sPrefix ?>start_date" style="cursor:pointer;"><img  title="Start Date" src="<?php echo $sImagePath;?>calendar_icon.png" /></label></a></td>
               		<td><span  class="title">End Date: </span><input type="text" id="<?php echo $sPrefix ?>end_date" class="input_text" readonly="readonly" value="<?php echo $sLastDay;?>" onclick="adminPageContents.customSearch()" title="End Date" /><a href="#"><label for="<?php echo $sPrefix ?>end_date" style="cursor:pointer;"><img  title="End Date" src="<?php echo $sImagePath;?>calendar_icon.png" /></a></label></td>
            </tr>
            <tr>
                <td><span  class="title">Search Keyword</span></td>
                <td>
                    <select class="optionbox" id="field_type_search">
                        <option value="memo" id="1" <?php if($sFieldSearch=='memo'){?> selected=="selected" <?php } ?>>Memo</option>
                        <option value="title" id="2" <?php if($sFieldSearch=='' || $sFieldSearch=='title'){?> selected="selected" <?php } ?>>Title</option>
                    </select></td>
                <td colspan="2"><input type="hidden" value="init" id="search" name="search"><input id="keyword" value="<?php echo $sKeyword;?>" type="text" title="keyword, title or memo" class="input_search"/> <a href="#none" onclick="adminPageContents.execSearch('<?php echo $sQryShow?>');" class="btn_nor_01 btn_width_st1" title="Search Keyword" style="width:50px;padding-left:0;padding-bottom:6px;text-align:center;">Search</a><a href="#none" onclick="adminPageContents.execReset();" class="add_link" title="Reset to default">Reset</a></td>
            </tr>
        </table>
    </td>
</tr>
</table>
<div class="table_header_area">
    <ul class="row_1">
        <li class="comment">
            <a href="<?php echo $sUrlList;?>" class="all selected" title="Show all posts">All(<?php echo $iResult;?>)</a>
            <a href="<?php echo $sUrlList;?>&show=expected" title="Show Expected Schedule only">Expected(<?php echo $iExpected;?>)</a>
            <a href="<?php echo $sUrlList;?>&show=finished" title="Show Finished Schedule only">Finished(<?php echo $iFinished;?>)</a>
        </li>
    </ul>
    <ul class="row_2">
        <li>
            <a href="#none" style="height:13px;"  onclick="adminPageContents.deleteRow();" class="btn_nor_01 btn_width_st1" title="Delete selected schedule">Delete</a>
        </li>
        <li class="show">
            <label for="show_row">Show Rows</label>
            <select id="show_rows" onchange="adminPageContents.execSelectRow('<?php echo $sQryShow.$sQrySEDate.$sQryKeyword.$sQryFieldSearch.$sQryDateRange.$sQrySort;?>');" >
                <option value="10" <?php if($sRows=='10'){?>selected="selected"<?php }?>>10</option>
                <option value="20" <?php if($sRows=='20' || $sRows==''){?>selected="selected"<?php }?>>20</option>
                <option value="30" <?php if($sRows=='30'){?>selected="selected"<?php }?>>30</option>
                <option value="50" <?php if($sRows=='50'){?>selected="selected"<?php }?>>50</option>
                <option value="100" <?php if($sRows=='100'){?>selected="selected"<?php }?>>100</option>
            </select>
        </li>
    </ul>
</div>
<!-- // table header -->
<!-- table horizontal -->
<table border="1" cellpadding="0" cellspacing="0" class="table_hor_02">
<colgroup>
    <col width="44px" />
    <col width="48px" />
    <col  />
    <col width="200px" />
    <col width="350px" />
</colgroup>
<thead>
<tr>
    <th class="chk"><input onclick="adminPageContents.selectAll(this.id)" type="checkbox" title="" class="input_chk" id="<?php echo $sPrefix?>select_all"/></th>
    <th>No.</th>
    <th>
        <a href="<?php echo $sUrlList?>&sort=title&type=<?php if($sSort!='title'){?>asc<?php }elseif($sSort=='title'){ echo $sSortType;}?><?php echo $sQryRow.$sQryShow.$sQryKeyword.$sQrySEDate.$sQryDateRange.$sQryFieldSearch.$sQryPage;?>" class="<?php if($sSort=='title'){ echo $sSortType; }?>">Title</a>
    </th>
    <th><a href="<?php echo $sUrlList?>&sort=end_day&type=<?php if($sSort!='end_day'){?>asc<?php }elseif($sSort=='end_day'){ echo $sSortType;}?><?php echo $sQryRow.$sQryShow.$sQryKeyword.$sQrySEDate.$sQryDateRange.$sQryFieldSearch.$sQryPage;?>" class="<?php if($sSort=='end_day'){ echo $sSortType; }?>">Status</a></th>
    <th class="no_border"><a  href="<?php echo $sUrlList?>&sort=start_day&type=<?php if($sSort!='start_day'){?>asc<?php }elseif($sSort=='start_day'){ echo $sSortType;}?><?php echo $sQryRow.$sQryShow.$sQryKeyword.$sQrySEDate.$sQryDateRange.$sQryFieldSearch.$sQryPage;?>" class="<?php if($sSort=='start_day'){ echo $sSortType; }?>">Date</a></th>
</tr>
</thead>
<tbody>
<?php if($aList){ ?>
    <?php foreach($aList as $rows){ ?>
    <tr onmouseover="this.className='over'" onmouseout="this.className=''">
        <td><input onclick="adminPageContents.checkThis()" type="checkbox" name="idx_val[]" title="" value="<?php echo $rows['idx'];?>" class="input_chk" /></td>
        <td><?php echo $rows['row'];?></td>
        <td class="table_subtitle"><a href="<?php echo $sUrlView?>&idx=<?php echo $rows['idx']; ?>" title="Edit Schedule"><center><?php echo $rows['title'];?></center></a></td>
        <td><?php echo $rows['status'];?></td>
        <td><?php echo $rows['start_date'];?> ~ <?php echo $rows['end_date'];?></td>
    </tr>
    <?php }?>
<?php }else{?>
    <tr>
        <td colspan="5" class="not_fnd">There's no content.</td>
    </tr>
<?php }?>
</tbody>
</table>
<!-- // table horizontal -->
<div class="table_header_area">
    <ul class="row_2">
        <!--<li>
            <select>
                <option>Select Action</option>
                <option>Expected</option>
                <option>Finished</option>
                <option>Delete</option>
                <option>Move</option>
            </select>
            <a href="#none" class="btn_nor_01 btn_width_st1" title="Apply selected action">Apply</a>
        </li>-->
        <li>
            <a href="#none" class="btn_nor_01 btn_width_st1" style="height:13px;" onclick="adminPageContents.deleteRow();"  title="Delete selected schedule">Delete</a>
        </li>
        <li class="show">
            <a href="<?php echo $sUrlAdd; ?>" class="btn_nor_01 btn_width_st2" title="Add New Schedule" style="width:119px;height:13px">Add New Schedule</a>
        </li>
    </ul>
</div>
<!-- pagination -->
<?php echo $sPagination;?>
<!-- // pagination -->
<!-- // table horizontal -->
<div id='simplesample_delete_popup_contents' style='display:none'>
    <div class="admin_popup_contents">
        Are you sure you want to delete the record?
        <br />
        <br />
        <a class="btn_nor_01 btn_width_st1" href="#none" style='cursor:pointer;' title="Delete" onclick="adminPageContents.execDelete()"> Delete <a/>
    </div>
</div>
<input type="hidden" id="total_schedule" value="<?php echo $iResult;?>">