
            <h3>Add New Schedule</h3>
            <p class="require"><span class="neccesary">*</span> Required</p>
            <!-- input area -->

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
                            <td><input type="text" value="1/1/2011" class="fix" id="scheduler_date" /></td>
                            <td><a href="#"><img src="/_sdk/img/simpleschedule/calendar_icon.png" /></a></td>
                            <td><label for="scheduler_time">Time:</label></td>
                            <td>
                                <select id="scheduler_time" class="select_option">
                                    <option value="00:00">00:00</option>
                                    <option value="01:00">01:00</option>
                                    <option value="02:00">02:00</option>
                                    <option value="03:00">03:00</option>
                                    <option value="04:00">04:00</option>
                                    <option value="05:00">05:00</option>
                                    <option value="06:00">06:00</option>
                                    <option value="07:00">07:00</option>
                                    <option value="08:00">08:00</option>
                                    <option value="09:00">09:00</option>
                                    <option value="10:00">10:00</option>
                                    <option value="11:00">11:00</option>
                                    <option value="12:00" selected="selected">12:00</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="15:00">15:00</option>
                                    <option value="16:00">16:00</option>
                                    <option value="17:00">17:00</option>
                                    <option value="18:00">18:00</option>
                                    <option value="19:00">19:00</option>
                                    <option value="20:00">20:00</option>
                                    <option value="21:00">21:00</option>
                                    <option value="22:00">22:00</option>
                                    <option value="23:00">23:00</option>
                                    <option value="24:00">24:00</option>
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
                            <td><input type="text" value="1/1/2011" id="scheduler_date" class="fix" /></td>
                            <td ><a href="#"><img src="/_sdk/img/simpleschedule/calendar_icon.png" /></a></td>
                            <td><label for="scheduler_time">Time:</label></td>
                            <td>
                                <select id="scheduler_time" class="select_option">
                                    <option value="00:00">00:00</option>
                                    <option value="01:00">01:00</option>
                                    <option value="02:00">02:00</option>
                                    <option value="03:00">03:00</option>
                                    <option value="04:00">04:00</option>
                                    <option value="05:00">05:00</option>
                                    <option value="06:00">06:00</option>
                                    <option value="07:00">07:00</option>
                                    <option value="08:00">08:00</option>
                                    <option value="09:00">09:00</option>
                                    <option value="10:00">10:00</option>
                                    <option value="11:00">11:00</option>
                                    <option value="12:00" selected="selected">12:00</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="15:00">15:00</option>
                                    <option value="16:00">16:00</option>
                                    <option value="17:00">17:00</option>
                                    <option value="18:00">18:00</option>
                                    <option value="19:00">19:00</option>
                                    <option value="20:00">20:00</option>
                                    <option value="21:00">21:00</option>
                                    <option value="22:00">22:00</option>
                                    <option value="23:00">23:00</option>
                                    <option value="24:00">24:00</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><th><label for="textarea_memo">Title</label></th><td><span class="neccesary">*</span><input type="text" value="" class="fix2"  /></td></tr>
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
                <a href="#" class="btn_apply" title="Save changes" onclick="chk_validate();">Save</a>
                <a href="<?php echo $sUrl;?>" class="add_link" title="Return to Scheduler">Return to Scheduler</a>
            </div>