$(document).ready(function(){
    options = { 'years_between' : [2000,2030],'format' : 'yyyy/mm/dd' };
    $("#simpleschedule_start_date, #simpleschedule_end_date").BuilderCalendar(options);
});

var adminPageAdd = {
     execSave : function(){
         var start_date = $("#simpleschedule_start_date");
         var end_date = $("#simpleschedule_end_date");
         var start_time = $("#simpleschedule_start_time");         
         var end_time = $("#simpleschedule_end_time");
         var error = 0;

         
         if(Date.parse(start_date.val()) > Date.parse(end_date.val())){
             start_date.css('border','solid 2px #DC4E22');
             end_date.css('border','solid 2px #DC4E22');    
             error += 1;
         }else{
             start_date.css('border','1px solid #CCC');
             end_date.css('border','1px solid #CCC');    
         }
         
         if(start_time.val() >= end_time.val()){
             
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
             document.simpleschedule_add_form.submit();
         }
     },execGMAP : function(){
         popup.load('simpleschedule_google_map').skin('admin').layer({
             'title' : 'Google Map',
             'width' : 420,
             'height':400,
             'classname': 'ly_set ly_editor'
         });
         googleMapApi.initialize('asd');

     }
}