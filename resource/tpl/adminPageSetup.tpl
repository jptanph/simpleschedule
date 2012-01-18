
<!-- message box -->            
<div class="msg_suc_box" style='display:none' id="{$sHtmlPrefix}template_status">
    <p><span>Saved successfully.</span></p>
</div>  
<p class="require"><span class="neccesary">*</span> Required</p>
<!-- input area -->         
<h3>Settings</h3>
<p>APP Id : simpleschedule</p><br />
<table border="1" cellspacing="0" class="table_input_vr">
<colgroup>
    <col width="115px" />
    <col width="*" />
</colgroup>
<tr>
    <th><label for="template_setting">Template</label></th>
    <td>    
        <div class="template_setting" id="template_setting">
            <div class="template_icon">
            <label><input name="{$sHtmlPrefix}template" id="{$sHtmlPrefix}template" value="blue" type="radio" {if $sTemplate=='blue'}checked="checked"{/if} class="input_rdo" /> 
            Blue<img src="/_sdk/img/simpleschedule/u106_original.png" alt="Original Template Blue" /></label>
            </div>
            <div class="template_icon">
                <label><input name="{$sHtmlPrefix}template" id="{$sHtmlPrefix}template"  value="gray"  {if $sTemplate=='gray'}checked="checked"{/if}  type="radio"class="input_rdo" />Gray
                <img src="/_sdk/img/simpleschedule/u108_original.png" alt="Original Template Gray" /></label>
            </div>
        </div>
    </td>
</tr>   
</table>
<div class="tbl_lb_wide_btn">
    <a href="#" class="btn_apply" title="Save changes" onclick="Plugin_Scheduleradv_Setup.changeTemplate('')">Save</a>
    <a href="#" class="add_link" title="Reset to default" onclick="Plugin_Scheduleradv_Setup.restoreTemplate('')">Reset to Default</a>
</div>
<input type='hidden' value='{$sServerUrl}' name='sServerUrl' id='sServerUrl'>