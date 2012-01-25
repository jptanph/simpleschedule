jQuery(document).ready(function($){
    frontPageSimpleSchedule.init();
});
var frontPageSimpleSchedule = {
    init : function(){
       var options = {
           url :usbuilder.getUrl("apiFrontSimpleScheduleCalendar"),
           type:'post',
           dataType:'json',
           data : {
           },success : function(server_response){
               $("#areas").html(server_response.Data)
           }
       }
       $.ajax(options);
    }
}