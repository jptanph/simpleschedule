jQuery(document).ready(function($){
    frontPageSimpleSchedule.initCalendar();
});
var frontPageSimpleSchedule = {
    initCalendar : function(month,year){
        //sdk_simpleschedule_Front.latestIdx = 0;       
        /** Declare default variables **/
        var pgPfxId = "#sdk_simpleschedule_";
        var pgPfxClass = ".sdk_simpleschedule_";
        var thisdate =''
        var startDay;
        var maxDay;
        var lastDay;
        var totalDays;
        var currentMonth;
        var currentYear;
        var filterMonth;
        var currentDate;
        var days = ['SUN','MON','TUE','WED','THU','FRI','SAT'];
        var calendar='';
        var monthName = '';
        var sServerUrl = $("#sServerUrl").val();

        $(".sdk_simpleschedule_overlaycontainer").empty();
        //$(".sdk_simpleschedule_output").empty();
        
        /** Declare PLUGIN.post data for sending request to the index.**/
        var pNode = $("#PLUGIN_Scheduleradv");
        var options = {
                url :usbuilder.getUrl("apiFrontSimpleScheduleCalendar"),
                type:'post',
                dataType:'json',
                data : {
                    iMonth :month,
                    iYear : year
                },success : function(requestContent){
                    
                    $.each(requestContent.Data,function(index,value){

                        startDay = parseInt(value.startDay);

                        maxDay = parseInt(value.maxDay);

                        lastDay = parseInt(value.lastDay);

                        totalDays = parseInt(startDay+maxDay+lastDay);

                        currentMonth = parseInt(value.thisMonth)

                        currentYear = parseInt(value.thisYear)

                        filterMonth = (currentMonth<10) ? "0"+currentMonth:currentMonth

                        currentDate = currentYear+"-"+filterMonth

                        cDay = value.currentDay

                        cMonth = value.currentMonth

                        cYear = value.currentYear

                        today = cYear+"-"+cMonth+"-"+cDay
                        

                        calendar ="<p class='sdk_simpleschedule_control'><a href='#' class='sdk_simpleschedule_prev' onclick='frontPageSimpleSchedule.initCalendar("+value.previousMonth+","+value.previousYear+") ; return false' ><img src='/_sdk/img/simpleschedule/blue/scheduler_prev.gif' alt='previous button'/></a><strong class='sdk_simpleschedule_date'>"+value.thisYear+"-"+filterMonth+"</strong><a href='#' class='sdk_simpleschedule_next'  onclick='frontPageSimpleSchedule.initCalendar("+value.nextMonth+","+value.nextYear+") ; return false'><img src='/_sdk/img/simpleschedule/blue/scheduler_next.gif' alt='next' /></a></p>"
                        calendar +="<table class='sdk_simpleschedule_days' cellspacing='0' name='day_link'>"                         
                            calendar +="<tr class='sdk_simpleschedule_dotw'>"

                            for(i=0;i<days.length;i++){
                                calendar+="<td class='sdk_simpleschedule_red'>"+days[i]+"</td>"
                            }
                           calendar+="</tr>";
                           
                           
                            for( i=0; i < totalDays ; i++ ) {
                                

                                if((i % 7) == 0 ){ 
                                    calendar += "<tr class='sdk_simpleschedule_week1'>";
                                }
                                
                                if(i < value.startDay){
                                    calendar += "<td>&nbsp;</td>";
                                }else{
                                
                                    var day = (i - value.startDay + 1);
                                    var totSchedule = ''
                                    var filterDay = ( day < 10 ) ? "0"+day : day
                                    
                                    if(today==currentDate+"-"+filterDay){
                                        isToday = "sdk_simpleschedule_current"
                                    }else{
                                        isToday = "sdk_simpleschedule_on"
                                    }


                                    if((i - value.startDay + 1)>maxDay){
                                        calendar += "<td>&nbsp;</td>\n";
                                    }else{
                                    
                                        var totSchedule= '';

                                        for(k = 0 ; k<value.sSchedInfo.length ; k++){
                                            if((value.sSchedInfo[k]['schedDate'])==(currentDate+"-"+filterDay)){
                                                totSchedule = "<div class='sdk_simpleschedule_taskcount'><p class='sdk_simpleschedule_count'>"+( (value.sSchedInfo[k]['totalSchedule']==0) ? '' : value.sSchedInfo[k]['totalSchedule'])+"</p></div>"
                                            }
                                        }
                                        calendar += "<td align='center' valign='middle' height='20px'><a href='#' class='"+isToday+"' onclick=\"sdk_simpleschedule_Front.viewSchedule('"+currentDate+"-"+filterDay+"') ; return false\">"+day+" "+totSchedule+"</a></td>\n";
                                    }
                                }   

                                if((i % 7) == 6 ){ 
                                    calendar +="</tr>\n";
                                }
                            }
                            
                        calendar+="</calendar>";
                        $(".sdk_simpleschedule_output").html(calendar);
                        $(".sdk_simpleschedule_overlay3").remove();
                    });
                }
        }
        $.ajax(options)
        
    }
}