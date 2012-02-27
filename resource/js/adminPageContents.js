$(document).ready(function(){
    $('.input_chk').shiftcheckbox();
    var options = { 'years_between' : [2000,2030],'format' : 'yyyy/mm/dd' };
    $("#simpleschedule_start_date, #simpleschedule_end_date").BuilderCalendar(options);
});
var adminPageContents = {
    arrayIdx : [],
    selectAll : function(id){
        
        var is_checked = $("#"+id).is(':checked');
        $("input[name='idx_val[]']").each(function(index,value){
            $(this).attr('checked',is_checked);
        });
        if($("input[name='idx_val[]']:checked").length==0){
            sdk_popup.close("simplesample_delete_popup");
        }else{
            sdk_message.hide();
        }
    },deleteRow : function(){    
        var is_checked = $("input[name='idx_val[]']:checked").length;
        var total_schedule = $('#total_schedule');
        
        if(parseInt(total_schedule.val())==0){
            
            //oValidator.generalPurpose.getMessage(false, "No record(s) to delete.");
            sdk_message.show('No record(s) to delete.', 'warning');


        }else{
            if(is_checked==0){
            
                //oValidator.generalPurpose.getMessage(false, "Please select the record(s) you'd like to delete.");
                sdk_message.show("Please select the record(s) you'd like to delete.", 'warning');             
            
            }else{
                
                adminPageContents.arrayIdx.splice(0,adminPageContents.arrayIdx.length);
                
                $("input[name='idx_val[]']").each(function(index,value){
                    iIdx = $(this).attr("value");
                    if($(this).is(":checked")==true){
                        if($.inArray(value.value,adminPageContents.arrayIdx)==-1){
                            adminPageContents.arrayIdx.push(iIdx);
                        }
                    }
                });
                
                $("#validation_message").hide();
                sdk_popup.load('simplesample_delete_popup').skin('admin').layer({
                    'title' : 'Delete',
                    'width' : 260,
                    'classname': 'ly_set ly_editor'
                });
            }
        }
        
    },execSearch : function(sQryStr){
        popup.close("simplesample_delete_popup");
        var keyword = $("#keyword");
        var start_date = $("#simpleschedule_start_date");
        var end_date = $("#simpleschedule_end_date");
        var date_range = $("#date_range");
        var field_search = $("#field_type_search");
        var search_flag= $("#search");
        var seq = $("#simpleschedule_seq");
        
        var error = 0;
        if($.trim(start_date.val())==''){
        	start_date.css('border','solid 2px #DC4E22');
        	error += 1;
        }else{
        	start_date.css('border','solid 1px #CCC');
        }
        
        if($.trim(end_date.val())==''){
        	end_date.css('border','solid 2px #DC4E22');
        	error += 1;
        }else{
        	end_date.css('border','solid 1px #CCC');
        }
        
        if(Date.parse(start_date.val()) > Date.parse(end_date.val()) ){
        	start_date.css('border','solid 2px #DC4E22');
        	end_date.css('border','solid 2px #DC4E22');
        	error += 1;
        }

       if(error==0){
    	   var s = usbuilder.getUrl('adminPageContents') + '&keyword=' +keyword.val()+'&start_date='+start_date.val()+'&end_date='+end_date.val()+'&date_range='+date_range.val()+'&field_search='+field_search.val()+sQryStr+"&search="+search_flag.val()+'&seq=' + seq.val();
           window.location.href = usbuilder.getUrl('adminPageContents') + '&seq=' + seq.val() + '&keyword=' +keyword.val()+'&start_date='+start_date.val()+'&end_date='+end_date.val()+'&date_range='+date_range.val()+'&field_search='+field_search.val()+sQryStr+"&search="+search_flag.val();
       }
       
    },execSelectRow : function($sQryStr){
        
        sdk_popup.close("simplesample_delete_popup");
        var show_rows = $("#show_rows");
        var seq = $("#simpleschedule_seq")
        window.location.href=usbuilder.getUrl('adminPageContents') + "&seq=" + seq.val() + '&row='+show_rows.val()+$sQryStr;
        
    },execDelete : function(){
        var seq = $("#simpleschedule_seq");
        var options  = {
            url :usbuilder.getUrl("apiAdminDeleteContent"),
            type:'post',
            dataType:'json',
            data : {
                 idx : adminPageContents.arrayIdx,
                 seq : seq.val()
            },success : function(server_response){
              
               sdk_message.show("Deleted successfully", 'success');  
               window.location.href=usbuilder.getUrl('adminPageContents') + "&seq="+seq.val(); 
            }
        }
        
        $.ajax(options);
        popup.close("simplesample_delete_popup");
        
    },execDateRange : function(){
       
        sdk_popup.close("simplesample_delete_popup");
    	var date_range = ($("#date_range").val()==undefined) ? 'currentMonth' : $("#date_range").val();
    	
        var options  = {
            url :usbuilder.getUrl("apiAdminDateRange"),
            type:'post',
            dataType:'json',
            data : {
            	requestDate : date_range
            },success : function(server_response){
            	$("#simpleschedule_start_date").val(server_response.Data.sDate)
            	$("#simpleschedule_end_date").val(server_response.Data.eDate)
            }
        }
        $.ajax(options);
        
    },execReset : function(){
        
        sdk_popup.close("simplesample_delete_popup");
    	$("#keyword").val('');
    	$("select#date_range").val('currentMonth');
    	$("select#field_type_search").val('title')
    	this.execDateRange();
    	
    },customSearch : function(){
        
        sdk_popup.close("simplesample_delete_popup");
    	$("select#date_range").val('customSearch');
   
    },checkThis : function(){
      
       if($("input[name='idx_val[]']:checked").length==0){
           sdk_popup.close("simplesample_delete_popup");
       }
       
       sdk_popup.close("simplesample_delete_popup");
       
    },mostAction : function(){
        
        var seq = $("#simpleschedule_seq");        
        window.location.href = usbuilder.getUrl('adminPageAdd') + '&seq=' + seq.val();
        
    },execReset : function(){
        
        sdk_popup.close('easycomment_delete_multiple_comment');
        
    }
}