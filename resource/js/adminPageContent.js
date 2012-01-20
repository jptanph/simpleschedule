$(document).ready(function(){
    $('.input_chk').shiftcheckbox();
    var options = { 'years_between' : [2000,2030],'format' : 'yyyy/mm/dd' };
    $("#simpleschedule_start_date, #simpleschedule_end_date").BuilderCalendar(options);
});
var adminPageContent = {
    arrayIdx : [],
    selectAll : function(id){
        
        var is_checked = $("#"+id).is(':checked');
        $("input[name='idx_val[]']").each(function(index,value){
            $(this).attr('checked',is_checked);
        });
        
    },deleteRow : function(){    
        var is_checked = $("input[name='idx_val[]']:checked").length;
        
        if(is_checked==0){
        
            oValidator.generalPurpose.getMessage(false, "Please select the record(s) you'd like to delete.");
        
        }else{
            
            adminPageContent.arrayIdx.splice(0,adminPageContent.arrayIdx.length);
            
            $("input[name='idx_val[]']").each(function(index,value){
                iIdx = $(this).attr("value");
                if($(this).is(":checked")==true){
                    if($.inArray(value.value,adminPageContent.arrayIdx)==-1){
                        adminPageContent.arrayIdx.push(iIdx);
                    }
                }
            });
            
            $("#validation_message").hide();
            popup.load('simplesample_delete_popup').skin('admin').layer({
                'title' : 'Delete',
                'width' : 260,
                'classname': 'ly_set ly_editor'
            });
        }
        
    },execSearch : function(){
        popup.close("simplesample_delete_popup");
        var keyword = $("#keyword");
        var start_date = $("#simpleschedule_start_date");
        var end_date = $("#simpleschedule_end_date");
        var date_range = $("#date_range");
        var field_search = $("#field_type_search");
        window.location.href = usbuilder.getUrl('adminPageList') + '&keyword=' +keyword.val()+'&start_date='+start_date.val()+'&end_date='+end_date.val()+'&date_range='+date_range.val()+'&field_search='+field_search.val();
        
    },execSelectRow : function(){
        popup.close("simplesample_delete_popup");
        var show_rows = $("#show_rows");
        window.location.href=usbuilder.getUrl('adminPageList') + '&row='+show_rows.val();
    },execDelete : function(){
        
        var options  = {
            url :usbuilder.getUrl("apiDeleteContent"),
            type:'post',
            dataType:'json',
            data : {
                 idx : adminPageContent.arrayIdx
            },success : function(server_response){
                
               oValidator.generalPurpose.getMessage(true, "Deleted successfully");
               window.location.href=usbuilder.getUrl('adminPagelist'); 
            }
        }
        
        $.ajax(options);
        popup.close("simplesample_delete_popup");
        
    },execDateRange : function(){
        popup.close("simplesample_delete_popup");
    	var date_range = ($("#date_range").val()==undefined) ? 'currentMonth' : $("#date_range").val();
    	
        var options  = {
            url :usbuilder.getUrl("apiDateRange"),
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
        popup.close("simplesample_delete_popup");
    	$("#keyword").val('');
    	$("select#date_range").val('currentMonth');
    	$("select#field_type_search").val('title')
    	this.execDateRange();
    }
        
}