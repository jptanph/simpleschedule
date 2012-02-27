
<h3>Add New Schedule</h3>
<p class="require"><span class="neccesary">*</span> Required</p>
<!-- input area -->
<div id="sdk_message_box"></div>

<form id="<?php echo $sPrefix?>add_form" method="POST" class="<?php echo $sPrefix?>add_form" name="<?php echo $sPrefix?>add_form">
    <input type="hidden" name='seq' value='<?php echo $iSeq;?>'>
	<input type="hidden" name="lg_field" id="lg_field">
	<input type="hidden" name="lt_field" id="lt_field">
	<input type='hidden' name='seq' id='seq' value="<?php echo $iSeq;?>" />

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
					<td><input  fw-filter="isFill" fw-label="start_date" type="text" value="<?php echo $sDate; ?>" class="fix" id="start_date" name="start_date" readonly="true" /></td>
					<td><label style="cursor:pointer" for="start_date"><a><img src="/_sdk/img/simpleschedule/calendar_icon.png" /></a></label></td>
					<td><label for="start_time">Time:</label></td>
					<td>
                        <select id="start_time" name="start_time"  class="select_option">
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
					<td><input type="text" fw-filter="isFill" fw-label="end_date" id="end_date" name="end_date" value="<?php echo $sDate; ?>" class="fix"  readonly="true" /></td>
					<td ><label style="cursor:pointer" for="end_date"><a><img src="/_sdk/img/simpleschedule/calendar_icon.png" /></a></label></td>
					<td><label for="end_time">Time:</label></td>
					<td>
                        <select id="end_time" name="end_time" class="select_option">
                            <?php for($i = 1 ; $i <= 24 ; $i++){?>
                                <option value="<?php echo $i;?>"><?php echo str_pad($i,2,'0',STR_PAD_LEFT);?>:00</option>
                            <?php }?>
                        </select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><th><label for="textarea_memo">Title</label></th><td><span class="neccesary">*</span><input fw-filter="isFill" fw-label="<?php echo $sPrefix?>title" id="<?php echo $sPrefix?>title" name="title" type="text" value="" class="fix2"  /></td></tr>
	<tr><th><label for="textarea_memo">Location</label></th><td><span class="neccesary">&nbsp;&nbsp;</span><input type="text" value="" id="location" name="location" class="fix2" readonly="true" />
	<a href="#none" onclick="adminPageAdd.execGMAP();" title="Google Map Location"><img src="/_sdk/img/simpleschedule/u89_original.gif"  /></a>
	</td></tr>
	<tr>
		<th><label for="textarea_memo">Memo</label></th>
		<td>
			<textarea id="textarea_memo" name="memo"></textarea>
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

    <div id="<?php echo $sPrefix?>google_map" style='display:none;'>
        <div class="admin_popup_contents">
            <center><input type="text" name="map_search_address" id="map_search_address" style="margin:0 0 15px 0;width:345px;border:solid 1px #CCCCCC;padding: 0 2px 0 2px"> <a class="btn_nor_01 btn_width_st1" href="#none" title="Search Map" style="margin:0 0 15px 0;" onclick="googleMapApi.searchGeoAddress()"> Search </a></center>
            <input type="hidden" id="pg_scheduleradv_lat">
            <input type="hidden" id="pg_scheduleradv_lng">
            <input type="hidden" id="pg_scheduleradv_hlocation">
            <div id="sdk_scheduleradv_gmap" style="height:320px;width:420px;border:solid 1px gray;"></div>

            <div id="search_result_area"></div>
            <!--
            <div class="search_result">
                <span class="search_title">Search Result</span>
                <ul class="search_location">
                    <li><input type="radio" class="radio_btn" /><span><label>asdfasd</label></span></li>
                    <li><input type="radio" class="radio_btn" /><span><label>asdfasd</label></span></li>
                </ul>
            </div>
            -->
            <center><a class="btn_nor_01 btn_width_st1" href="#none" title="Select" style="margin:15px 0 0 0;width:100px" onclick="googleMapApi.selectLocation()"> Select Location</a></center>
        </div>
    </div>


