    <!-- table header -->
        <table border="1" cellpadding="0" cellspacing="0" class="table_hor_03">
            <tr>
                <td>
                    <table cellpadding="3" cellspacing="3">
                        <tr>
                            <td><span  class="title">Show by</span></td>
                            <td>
                                <select class="optionbox">
                                    <option value="Customized Search">Customized Search</option>
                                    <option value="Today">Today</option>
                                    <option value="Current Week">Current Week</option>
                                    <option value="Current Month" selected="selected">Current Month</option>
                                    <option value="Last Month" >Last Month</option>
                                    <option value="Current Quarter">Current Quarter</option>
                                    <option value="Last Quarter">Last Quarter</option>
                                    <option value="Current Year">Current Year</option>
                                    <option value="Last Year">Last Year</option>
                                    <option value="All">All</option>
                                </select></td>
                            
                            <td><span  class="title">Start Date:</span> <input type="text" value="1/1/2011" class="input_text" readonly="readonly" /><a href="#"><img src="<?php echo $sImagePath;?>calendar_icon.png" /></a></td>
                            <td><span  class="title">End Date: </span><input type="text" value="1/19/2011" class="input_text" readonly="readonly" /><a href="#"><img src="<?php echo $sImagePath;?>calendar_icon.png" /></a></td>
                            
                        </tr>
                        <tr>
                            <td><span  class="title">Search Keyword</span></td>
                            <td>
                                <select class="optionbox">
                                        <option value="Memo">Memo</option>
                                        <option value="Title" selected="selected">Title</option>
                                    
                                </select></td>
                            
                            <td colspan="2"><input id="keyword" value="<?php echo $sKeyword;?>" type="text" title="keyword, title or memo" class="input_search"/> <a href="#none" onclick="adminPageContent.execSearch();" class="btn_nor_01 btn_width_st1" title="Search Keyword">Search</a><a href="#" class="add_link" title="Reset to default">Reset</a></td>
                            
                        
                        </tr>
            
                    </table>
                </td>
            </tr>   
            </table>
            <div class="table_header_area">
                <ul class="row_1">
                    
                    <li class="comment">
                        <a href="#" class="all selected" title="Show all posts">All(10)</a>
                        <a href="#" title="Show Expected Schedule only">Expected(7)</a>
                        <a href="#" title="Show Finished Schedule only">Finished(3)</a>
                    </li>                   
                </ul>
                <ul class="row_2">
                    <li>
                        <a href="#none" onclick="adminPageContent.deleteRow();" class="btn_nor_01 btn_width_st1" title="Delete selected schedule">Delete</a>
                    </li>
                    <li class="show">
                        <label for="show_row">Show Rows</label>
                        <select id="show_row">
                            <option>10</option>
                            <option selected="selected">20</option>
                            <option>30</option>
                            <option>50</option>
                            <option>100</option>
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
                <th class="chk"><input onclick="adminPageContent.selectAll(this.id)" type="checkbox" title="" class="input_chk" id="<?php echo $sPrefix?>select_all"/></th>
                <th>No.</th>
                <th>
                    <a href="<?php echo $sUrl?>&sort=title&type=<?php if($sSort!='title'){?>asc<?php }elseif($sSort=='title'){ echo $sSortType;}?>" class="<?php if($sSort=='title'){ echo $sSortType; }?>">Title</a>
                </th>              
                <th><a href="<?php echo $sUrl?>&sort=end_day&type=<?php if($sSort!='end_day'){?>asc<?php }elseif($sSort=='end_day'){ echo $sSortType;}?>" class="<?php if($sSort=='end_day'){ echo $sSortType; }?>">Status</a></th>     
                <th class="no_border"><a  href="<?php echo $sUrl?>&sort=start_day&type=<?php if($sSort!='start_day'){?>asc<?php }elseif($sSort=='start_day'){ echo $sSortType;}?>" class="<?php if($sSort=='start_day'){ echo $sSortType; }?>">Date</a></th> 
            </tr>
            </thead>
            <tbody>
            <?php if($aList){ ?>
                <?php foreach($aList as $rows){ ?>
                <tr onmouseover="this.className='over'" onmouseout="this.className=''">
                    <td><input type="checkbox" name="idx_val[]" title="" value="<?php echo $rows['idx'];?>" class="input_chk" /></td>
                    <td><?php echo $rows['row'];?></td>
                    <td class="table_subtitle"><a href="plugin_scheduler_edit.html" title="Edit Schedule"><?php echo $rows['title'];?></a></td>
                    <td>Expected</td>               
                    <td><?php echo $rows['start_day'];?> ~ <?php echo $rows['end_day'];?><!-- MM/DD/YYYY HH:mm ~ MM/DD/YYYY HH:mm --></td>
                            
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
                        <a href="#none" class="btn_nor_01 btn_width_st1" title="Delete selected schedule">Delete</a>
                    </li>
                    <li class="show">
                        <a href="<?php echo $sUrlAdd; ?>" class="btn_nor_01 btn_width_st2" title="Add New Schedule">Add New Schedule</a>
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
                    <a class="btn_nor_01 btn_width_st1" href="#" style='cursor:pointer' title="Delete" onclick="adminPageList.deleteBtn()"> Delete <a/>
                </div>
            </div>            