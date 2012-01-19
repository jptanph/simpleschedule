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
             $("#simpleschedule_start_date").css('border','solid 2px #DC4E22');
             $("#simpleschedule_end_date").css('border','solid 2px #DC4E22');    
             error += 1;
         }else{
             $("#simpleschedule_start_date").css('border','1px solid #CCC');
             $("#simpleschedule_end_date").css('border','1px solid #CCC');    
         }
         
         if(start_time.val() >= end_time.val()){
             $("#simpleschedule_start_time").css('border','solid 2px #DC4E22');
             $("#simpleschedule_end_time").css('border','solid 2px #DC4E22');    
             error += 1;
         }else{
             $("#simpleschedule_start_time").css('border','1px solid #CCC');
             $("#simpleschedule_end_time").css('border','1px solid #CCC');    
         }
                 
         if(oValidator.formName.getMessage('simpleschedule_add_form') && error==0){
             document.simpleschedule_add_form.submit();
         }
     }
}