var adminPageContent = {
        
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
    }
        
}