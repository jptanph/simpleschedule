jQuery(document).ready(function($){
    frontPageSimpleSchedule.initCalendar();
});

var frontPageSimpleSchedule = {
    iSeq : 0,
    latestIdx : 0,
    isViewed : 0,
    listViewIdx:0,        
    initCalendar : function(month,year){
        frontPageSimpleSchedule.latestIdx = 0;       
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
        var seq = $("#simpleschedule_seq").val();
        this.iSeq = (!this.iSeq ) ? seq  : this.iSeq;
        $("#simpleschedule_seq").remove();
        $(".sdk_simpleschedule_overlaycontainer").empty();
        //$(".sdk_simpleschedule_output").empty();
        
        /** Declare PLUGIN.post data for sending request to the index.**/
        var options = {
                url :usbuilder.getUrl("apiFrontSimpleScheduleCalendar"),
                type:'post',
                dataType:'json',
                data : {
                    iMonth :month,
                    iYear : year,
                    seq : frontPageSimpleSchedule.iSeq
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
                                        calendar += "<td align='center' valign='middle' height='20px'><a href='#none' class='"+isToday+"' onclick=\"frontPageSimpleSchedule.viewSchedule('"+currentDate+"-"+filterDay+"'," + frontPageSimpleSchedule.iSeq + ") ; return false\">"+day+" "+totSchedule+"</a></td>\n";
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
        
    },viewSchedule : function(sDate,seq){
        this.latestIdx = 0;
        var sHtml = '';
        var options = {
            url :usbuilder.getUrl("apiFrontViewSchedule"),
            type:'post',
            dataType:'json',
            data : {
                sSchedDate:sDate,
                seq : seq
            },success : function(requestContent){
                sHtml += "<div class='sdk_simpleschedule_overlay1'>";
                sHtml += "<div class='sdk_simpleschedule_overlay2'>";
                sHtml += "<a href='#none' class='sdk_simpleschedule_closetask' onclick='frontPageSimpleSchedule.closeSchedule()'> close </a>";
                sHtml +="<div class='sdk_simpleschedule_task'>";
                
                if(requestContent.Data==''){
                    sHtml +="<strong class='sdk_simpleschedule_taskdate'>";
                    sHtml +="<label>You have no schedule for this day.</label>";
                    sHtml +="</strong>";
                }else{
                $.each(requestContent.Data,function(index,value){
                   
                    if(value.map_location=='' && value.memo==''){
                        sHtml +="<a style='text-decoration:none' id='sdk_simpleschedule_links"+value.idx+"' ><strong class='sdk_simpleschedule_taskdate'>";
                        sHtml +="<label>";
                        
                         if( value.start_time < 10){
                            sHtml += '0'+value.start_time+":00";
                         }else{
                            sHtml += value.start_time+":00";                             
                         }
                               
                        sHtml +="</label>";
                        sHtml +="</strong><span class='sdk_simpleschedule_tasktitle'><label>"+value.title+"</label></span></a>";    
                    
                    }else{
                        sHtml +="<a href='#none' style='text-decoration:none' id='sdk_simpleschedule_links"+value.idx+"' onmouseup='frontPageSimpleSchedule.viewList("+value.idx+"," + seq  + ")'><strong class='sdk_simpleschedule_taskdate'>";
                        if( value.end_time < 10){
                            sHtml += '0'+value.end_time+":00";
                         }else{
                            sHtml += value.end_time+":00";                             
                         }
                        sHtml += "</strong><span class='sdk_simpleschedule_tasktitle'>"+value.title+"</span></a>";
                        
                    }
                    sHtml += "<div id='sdk_simpleschedule_schedInfo"+value.idx+"' class='inf'></div>";
                       
                });
                }
                sHtml +="</div>";
                sHtml += "</div>";
                sHtml += "</div>";
                
                $(".sdk_simpleschedule_overlaycontainer").html(sHtml);
            }
        }
        $.ajax(options)
    },viewList : function(idx,seq){
        var sHtml = '';
        if(idx==this.latestIdx){                
            // $("#pg_scheduleradv_schedInfo"+this.latestIdx).show();
        }else{
            $("#sdk_simpleschedule_gmap").remove();
            $("#sdk_simpleschedule_schedInfo"+this.latestIdx).empty();

            var options = {
               url : usbuilder.getUrl('apiFrontViewInfo'),
               data : {
                  idx : idx,
                  seq : seq
               },
               dataType : 'json',
               type : 'post',
               success : function(requestContent){
                  $.each(requestContent.Data,function(index,value){
                      sHtml += "<p class='sdk_simpleschedule_taskcontent' id='sdk_simpleschedule_task"+value.idx+"'>";
                          if(value.memo){
                              sHtml += "<label>"+value.memo+"</label>";
                          }else{
                              sHtml += "";
                          }
                          
                          if(value.map_location){
                              sHtml += "<div style='text-align:center;'>";
                              sHtml += "<div id='sdk_scheduleradv_gmap' style='width:230px; height:210px;border:1px solid #CCCCCC;margin:0 auto;'></div>";
                              sHtml += " </div>";
                          }
                          
                      sHtml += "</p>";
                     
                      $(".sdk_simpleschedule_taskcontent").remove();
                      $("#sdk_simpleschedule_schedInfo"+idx).html(sHtml);
                      if(value.map_location){
                          googleMapApi.viewFrontMap(value.latitude,value.longitude);
                      }
                  });                  
               }
            }
            $.ajax(options);
        }
        this.latestIdx= idx;
    },closeSchedule: function(){
        this.latestIdx = 0;     
        $(".sdk_simpleschedule_overlay1").remove()
    },closeList : function(idx){
        this.latestIdx = 0;     
        $("#sdk_simpleschedule_schedInfo"+idx).hide();
    }
    
}