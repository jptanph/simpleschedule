
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$sModuleTitle}</title>
<link href="{$sPrgDir}{$setupCss}" type="text/css" rel="stylesheet">
<link href="{$jqueryuicss}" type="text/css" rel="stylesheet">
<script type="text/javascript" src="{$jquerylib}"></script>
<script type="text/javascript" src="{$jqueryuijs}"></script>
<script type="text/javascript" src="{$sPrgDir}{$setupJs}"></script>
<!--[if IE 7]>
<link href="css/ie7.css" rel="stylesheet" type="text/css" media="screen" />	
<![endif]-->
<!--[if lte IE 7]>
<link href="css/lte_ie7.css" rel="stylesheet" type="text/css" media="screen" />
<script defer type="text/javascript" language="Javascript" src="pngfix.js"></script>
<![endif]-->
<!--[if IE 6]>
<link href="css/ie6.css" rel="stylesheet" type="text/css" media="screen" />	
<![endif]-->
</head>
<body>
{$sScriptCrossDomain}
<!-- message box -->			
<div class="msg_suc_box" style='display:none' id="{$sHtmlPrefix}template_status">
	<p><span>Saved successfully.</span></p>
</div>	
<p class="require"><span class="neccesary">*</span> Required</p>
<!-- input area -->			
<h3>Settings</h3>
<p>Plugin ID: Scheduleradv</p><br />
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
			Blue<img src="images/u106_original.png" alt="Original Template Blue" /></label>
			</div>
			<div class="template_icon">
				<label><input name="{$sHtmlPrefix}template" id="{$sHtmlPrefix}template"  value="gray"  {if $sTemplate=='gray'}checked="checked"{/if}  type="radio"class="input_rdo" />Gray
				<img src="images/u108_original.png" alt="Original Template Gray" /></label>
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
</body>
</html>