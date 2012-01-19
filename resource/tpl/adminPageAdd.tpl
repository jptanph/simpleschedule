
	<h3>Add New Schedule</h3>
	<p class="require"><span class="neccesary">*</span> Required</p>
	<!-- input area -->
    <form id="<?php echo $sPrefix?>add_form" class="<?php echo $sPrefix?>add_form" method="post" name="<?php echo $sPrefix?>add_form">
    	<table border="1" cellspacing="0" class="table_input_vr">
    	<colgroup>
    		<col width="80px" />
    		<col />
    	</colgroup>
    	<tr>
    		<th><label for="clock_location1">From</label></th>
    		<td style="padding:0;">
    			<table border="0" cellspacing="2" celllpaddding="2">
    				<tr>
    					<td><span class="neccesary">*</span><label for="scheduler_date">Date:</label></td>
    					<td><input  fw-filter="isFill" fw-label="<?php echo $sPrefix?>start_date" type="text" value="<?php echo $sDate; ?>" class="fix" id="<?php echo $sPrefix?>start_date" readonly="true" /></td>
    					<td><label style="cursor:pointer" for="<?php echo $sPrefix?>start_date"><a><img src="/_sdk/img/simpleschedule/calendar_icon.png" /></a></label></td>
    					<td><label for="<?php echo $sPrefix;?>start_time">Time:</label></td>
    					<td>
                            <select id="<?php echo $sPrefix?>start_time" class="select_option">
                                <?php for($i = 1 ; $i <= 24 ; $i++){?>
                                    <option value="<?php echo $i;?>"><?php echo str_pad($i,2,'0',STR_PAD_LEFT);?>:00</option>    
                                <?php }?>
                            </select>
    					</td>
    				</tr>
    			</table>
    		</td>
    	</tr>
    
    	<tr>
    		<th><label for="clock_location1">To</label></th>
    		<td>
    			<table border="0" cellspacing="2" celllpaddding="2">
    				<tr>
    					<td><span class="neccesary">*</span><label for="scheduler_date">Date:</label></td>
    					<td><input type="text" fw-filter="isFill" fw-label="<?php echo $sPrefix?>end_date" id="<?php echo $sPrefix?>end_date" value="<?php echo $sDate; ?>" class="fix"  readonly="true" /></td>
    					<td ><label style="cursor:pointer" for="<?php echo $sPrefix?>end_date"><a><img src="/_sdk/img/simpleschedule/calendar_icon.png" /></a></label></td>
    					<td><label for="<?php echo $sPrefix;?>end_time">Time:</label></td>
    					<td>
                            <select id="<?php echo $sPrefix?>end_time" class="select_option">
                                <?php for($i = 1 ; $i <= 24 ; $i++){?>
                                    <option value="<?php echo $i;?>"><?php echo str_pad($i,2,'0',STR_PAD_LEFT);?>:00</option>    
                                <?php }?>
                            </select>
    					</td>
    				</tr>
    			</table>
    		</td>
    	</tr>
    	<tr><th><label for="textarea_memo">Title</label></th><td><span class="neccesary">*</span><input fw-filter="isFill" fw-label="<?php echo $sPrefix?>title" id="<?php echo $sPrefix?>title" type="text" value="" class="fix2"  /></td></tr>
    	<tr><th><label for="textarea_memo">Location</label></th><td><span class="neccesary">&nbsp;&nbsp;</span><input type="text" value="" class="fix2"  />
    	<a href="#" title="Google Map Location"><img src="/_sdk/img/simpleschedule/u89_original.gif"  /></a>
    	</td></tr>
    	<tr>
    		<th><label for="textarea_memo">Memo</label></th>
    		<td>
    			<textarea id="textarea_memo"></textarea>
    		</td>
    	</tr>
    	</table>
        </form>
    	<script type="text/javascript">
    	//<![CDATA[
    		function toggle(no) {
    		  var obj = document.getElementById('item' + no);
    		  if (obj.style.display == '' || !obj.style.display) obj.style.display = 'none';
    		  else obj.style.display = '';
    		}
    	//]]>
    	</script>
    
    
    	<!-- // input area -->
    
    	<script type="text/javascript">
    	//<![CDATA[
    	function chk_validate (){
    		document.getElementById('module_label_wrap').className='warn_border';
    	}
    	//]]>
    	</script>
    	<div class="tbl_lb_wide_btn">
    		<a href="#none" class="btn_apply" title="Save changes" onclick="adminPageAdd.execSave();">Save</a>
    		<a href="<?php echo $sUrl;?>" class="add_link" title="Return to Scheduler">Return to Scheduler</a>
    	</div>