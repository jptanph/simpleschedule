$(document).ready(function(){
    options = { 'years_between' : [2000,2030],'format' : 'yyyy/mm/dd' };
    $("#start_date, #end_date").BuilderCalendar(options);
});

var adminPageAdd = {
            
    execSave : function(){
             
      var start_date = $("#start_date");
      var end_date = $("#end_date");
      var start_time = $("#start_time");         
      var end_time = $("#end_time");
      var seq = $("#seq");
      var error = 0;
    
         popup.close("simpleschedule_google_map");
         if(Date.parse(start_date.val()) > Date.parse(end_date.val())){
             start_date.css('border','solid 2px #DC4E22');
             end_date.css('border','solid 2px #DC4E22');    
             error += 1;
         }else{
             start_date.css('border','1px solid #CCC');
             end_date.css('border','1px solid #CCC');    
         }
         
         if(parseInt(start_time.val()) >= parseInt(end_time.val())){
             
             if ($.browser.msie  && parseInt($.browser.version, 10) < 8) {
                 start_time.removeClass('select_ok');
                 end_time.removeClass('select_ok');
                 start_time.addClass('select_warning');
                 end_time.addClass('select_warning');
             }else{
                 start_time.css('border','solid 2px #DC4E22')
                 end_time.css('border','solid 2px #DC4E22')
             }          
             error += 1;
         }else{
             if ($.browser.msie  && parseInt($.browser.version, 10) < 8) {
                 start_time.removeClass('select_warning');
                 end_time.removeClass('select_warning');
                 start_time.addClass('select_ok');
                 end_time.addClass('select_ok');
             }else{
                 start_time.css('border','solid 1px #CCC')
                 end_time.css('border','solid 1px #CCC')
             }                      
             $("#simpleschedule_start_time").css('border','inset 1px #CCC');
             $("#simpleschedule_end_time").css('border','inset 1px  #CCC');    
         }
                 
         if(oValidator.formName.getMessage('simpleschedule_add_form') && error==0){
             $("#validation_message").hide();
             var options  = {
                 url :usbuilder.getUrl("apiAdminValidateSave"),
                 type:'post',
                 dataType:'json',
                 data : {
                     start_date : start_date.val(),
                     start_time : start_time.val(),
                     end_date : end_date.val(),
                     end_time : end_time.val(),
                     seq : seq.val()
                 },success : function(server_response){
                     if(server_response.Data==0){
                         document.simpleschedule_add_form.submit();
                     }else{
                         oValidator.generalPurpose.getMessage(false, "There is a conflict in the schedule.");
                     }
                 }
             }    
             $.ajax(options); 
         }
         
     },execGMAP : function(){
         
    	 $(".search_result").remove();
         popup.load('simpleschedule_google_map').skin('admin').layer({
             'title' : 'Google Map',
             'width' : 420,
             'classname': 'ly_set ly_editor'
         });
         googleMapApi.initialize('asd');
         $(".search_result").remove()
         
     }
}