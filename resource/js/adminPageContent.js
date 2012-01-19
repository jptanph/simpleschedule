$(document).ready(function(){
    $('.input_chk').shiftcheckbox();
    options = { 'years_between' : [2000,2030],'format' : 'yyyy/mm/dd' };
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
        
        var keyword = $("#keyword");
        window.location.href = usbuilder.getUrl('adminPageList') + '&keyword=' +keyword.val();
        
    },execSelectRow : function(){
        
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
        
    }
        
}