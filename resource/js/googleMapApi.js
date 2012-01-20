

var googleMapApi = {
    initialLocation:'',
    map:null,
    marker:'',
    sServerUrl:'',
    browserSupportFlag :  new Boolean(),
    geocoder : new google.maps.Geocoder(),
    infoWindow : new google.maps.InfoWindow(),
    usa : new google.maps.LatLng(36.0580, 115.2065),
    korea : new google.maps.LatLng( 37.56654,  126.97797),

    initialize : function(url){
        var initLat;
        var initLng;
        this.sServerUrl = url

        var myOptions = {
            zoom: 14,
            panControl : true,
            zoomControl : true,
            zoomControlOptions : {
            style : google.maps.ZoomControlStyle.LARGE
            },mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        
        /** Instantiate map,marker object **/
        map = new google.maps.Map(document.getElementById("sdk_scheduleradv_gmap"), myOptions);
        marker = new google.maps.Marker({map:map})

        /** Listen to an event everytime the user click  the map to change the marker position **/
        google.maps.event.addListener(map,'click',function(event){
            googleMapApi.setMarkerLocation(event.latLng)
            googleMapApi.infoWindow.close();
            
        })

        /** Listen to an event everytime the user click  the new location on the map to change the marker position **/  
        google.maps.event.addListener(marker,'click',function(){
            googleMapApi.infoWindow.open(map,marker)
        })

        /** Location the current location of the user on the map **/
        this.getCurrentLocation();   


    },setMarkerLocation : function(location){
    	googleMapApi.animateMarker();
        marker.setPosition(location);
        map.setCenter(location)

        /** Send an ajax request to index to separate latitude and longitude **/
        $.ajax({
            type:'post',
            dataType : 'json',
            url : usbuilder.getUrl('apiGoogleMap'),
            data :{
                fLatLng : ""+location+""
            },success:function(serverResponse){
                googleMapApi.decodeLatitudeLongitude(serverResponse.Data.fLatitude,serverResponse.Data.fLongitude)
            }
        })
    
    },getCurrentLocation : function(){
        if($("#pg_scheduleradv_lat").val()!='' && $("#pg_scheduleradv_lng").val()!='' && $("#pg_scheduleradv_lat").val() != undefined &&  $("#pg_scheduleradv_lng").val() !=undefined){
                initLat = $("#pg_scheduleradv_lat").val()
                initLng = $("#pg_scheduleradv_lng").val()
                initialLocation = new google.maps.LatLng(initLat,initLng);
                googleMapApi.setMarkerLocation(initialLocation)
                
      }else{

          if(navigator.geolocation){
                this.browserSupportFlag = true;  

                navigator.geolocation.getCurrentPosition(function(position) {
                
                this.initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);

                googleMapApi.setMarkerLocation(this.initialLocation)
                
                }, function() {
                  googleMapApi.handleNoGeolocation(this.browserSupportFlag);

                });
          }else if (google.gears) {

                this.browserSupportFlag = true;
                var geo = google.gears.factory.create('beta.geolocation');
                geo.getCurrentPosition(function(position) {
                  initialLocation = new google.maps.LatLng(position.latitude,position.longitude);

                 googleMapApi.setMarkerLocation(initialLocation)
                          
                }, function() {
                  googleMapApi.handleNoGeoLocation(browserSupportFlag);
                });
            }else{
                this.browserSupportFlag = false;
                this.handleNoGeolocation(this.browserSupportFlag);
           }
         
        }   
    },handleNoGeolocation : function(errorFlag){
        if (errorFlag == true) {
          this.initialLocation = this.usa;
          currentLatLng = this.initialLocation
        } else {
          this.initialLocation = this.korea;
          currentLatLng = this.initialLocation
        }
        map.setCenter(this.initialLocation);
    
    },decodeLatitudeLongitude : function(fLat,fLng){

        var lat = parseFloat(fLat);
        var lng = parseFloat(fLng);
        var latlng = new google.maps.LatLng(lat, lng);
        this.geocoder.geocode({'latLng': latlng}, function(results, status) {

          if (status == google.maps.GeocoderStatus.OK) {
            if (results[2]) {
              var html = "<br /><p class='window_info'><b>Address :</b> "+results[0].formatted_address+"</p>";
              googleMapApi.infoWindow.setContent(html);
              googleMapApi.infoWindow.open(googleMapApi.map, googleMapApi.marker);
              $("#pg_scheduleradv_hlocation").val(results[0].formatted_address)
              $("#pg_scheduleradv_lat").val(fLat)
              $("#pg_scheduleradv_lng").val(fLng)
            }
          } else {
                //alert("Google Map is currently processing the location.");
                /** Do nothing here. Not or show the alert message box ?.**/
          }
        });     
    
    } ,searchGeoAddress : function(){
    
          var hasSelect = '';
          $("#pg_scheduleradv_lat").val('')
          $("#pg_scheduleradv_lng").val('')
          $("#pg_scheduleradv_search_result").remove()
          $("#pg_scheduleradv_search_result").remove()

          var searchResult = '';
          var address = $("#map_search_address").val();
          
          if($.trim(address)==''){
            $("#pg_scheduleradv_search_box").css('border','solid 2px #dc4e22');
          }else{
            $("#pg_scheduleradv_search_box").css('border','solid 1px #CCCCCC');
            this.geocoder.geocode( { 'address': address}, function(results, status) {
                
//                searchResult+="<div id='rec-result' style='overflow:auto;max-height:200px;border:solid 1px #CCCCCC;margin-top:3%;background-color:whitesmoke'>"
//                searchResult+="<div style='margin:3%'>";
//                searchResult +="<table cellpadding='3' cellspacing='3'>"        
//                    if(status=='ZERO_RESULTS'){
//                        searchResult +="<tr><td>No address found.</td></tr>"
//                        hasSelect = '';
//                        
//                    }else{

                
                    searchResult="";
                    
                    searchResult +="<div class='search_result'>\n";
                    searchResult +=" <span class='search_title'>Map Search Result</span>\n";
                    searchResult +="<ul class='search_location' style='"+((results.length<=5) ? '' : 'height:110px')+"'>\n";
                    
                    if(status=='ZERO_RESULTS'){
                        searchResult += "<li><center><b>No result.</b></center></li>\n";
                    }else{
	                    for(i = 0; i<results.length;i++){
	                    	ltLg = "'"+results[i].geometry.location+"'";
	                    	
	                    	var oldLtLg = ltLg.replace("'(",'');
	                    	var newLtLg = oldLtLg.replace(")'",'');
	                    	
	                    	strLtLg = new String(newLtLg)
	                    	arrLtLg = strLtLg.split(',');
	                    	//alert(arrLtLg[0])
	                       searchResult += "<li><span class='span_btn'><input type='radio' id='search_id"+i+"' name='search_result_val[]' value='"+results[i].formatted_address+"' class='radio_btn' /></span><label for='search_id"+i+"' onclick='googleMapApi.viewMapSearch("+arrLtLg[0]+","+arrLtLg[1]+")' class='search_address'>"+results[i].formatted_address+"</label></li>\n";
	                       //searchResult += "<li><span class='span_btn'><input type='radio' id='search_id"+i+"' name='search_result_val[]' value='"+results[i].formatted_address+"' class='radio_btn' /></span><label for='search_id"+i+"' onclick='googleMapApi.viewMapSearch("+arrLtLg[0]+","+arrLtLg[1]+")' class='search_address'>"+results[i].formatted_address+"</label></li>\n";
		                    
	                    }                       
                    }
                    searchResult +="</ul>\n";
                    searchResult +="</div>\n";   
                    $("#search_result_area").html(searchResult);                    
//                        hasSelect = "<span class='btn_u'><input type='button' class='btn_nor_01_c btn_width_st1_c' onclick='googleMapApi.selectResultLocation()' value='Select' id='' /></span>";
//                    }
//                searchResult +="</table>"
//                searchResult +="</div>"
//                searchResult +="</div>";
//                searchResult +="<div class='submit' align='center'><br />"
//                searchResult +="<span id='gmap-error' style='color:red'></span><br />"
//                searchResult +="<input  type='hidden' value='' id='map_address'/>"
//                searchResult +=hasSelect
//                searchResult +="&nbsp;&nbsp;<span class='btn_u'><input type='button' class='btn_nor_01_c btn_width_st1_c'  value='Close'  onClick=Plugin_Scheduleradv_Setup.closeBox('#pg_scheduleradv_search_result') /></span>"
//                searchResult +="</div>"
//                $("#pg_scheduleradv_search_result").html(searchResult);
//                $("#pg_scheduleradv_search_result").dialog({
//                    width:450
//                });
                
            }); 
        }
    
    },selectResultLocation : function(){
        var isSelected = $("input[name=pg_scheduleradv_searchradio]:checked").val()
        $("#gmap-error").empty()
        if(isSelected==undefined){
            // $("#gmap-error").append("<i>Please select on the list.</i>")
            return false;
        }else{
            $("#pg_scheduleradv_init_gmap").remove();
            $("#pg_scheduleradv_lat").val('')
            $("#pg_scheduleradv_lng").val('')
            this.geocoder.geocode( { 'address': isSelected}, function(results, status) {
                $("#pg_scheduleradv_lat").val(results[0].geometry.location.lat())
               $("#pg_scheduleradv_lng").val(results[0].geometry.location.lng())           
               Plugin_Scheduleradv_Setup.initGMap()
               $("#pg_scheduleradv_search_result").remove()
            })

        }   
    },animateMarker : function(){
        if(marker.getAnimation()!=null){
            marker.setAnimation(null)
        }else{
            marker.setAnimation(google.maps.Animation.DROP)
        }   
    },selectLocation : function(){
        $("#location").val('')
        $("#location").val($("#pg_scheduleradv_hlocation").val());
        $("#pg_scheduleradv_init_gmap").remove()
        popup.close("simpleschedule_google_map")
    
    }, viewFrontMap : function(url,initLat,initLng){
    
          var latLng = new google.maps.LatLng(initLat,initLng);
          var sServerUrl = url;
          var myOptions = {
                zoom: 14,
                zoomControl : true,
                center:latLng,
                zoomControlOptions : {
                    style : google.maps.ZoomControlStyle.SMALL
                },mapTypeId: google.maps.MapTypeId.ROADMAP
          }
         

          map = new google.maps.Map(document.getElementById("sdk_scheduleradv_gmap"), myOptions);
          marker = new google.maps.Marker({map:map})
          marker.setPosition(latLng);
          googleMapApi.decodeLatitudeLongitude(initLat,initLng)
         
          google.maps.event.addListener(map,'click',function(event){
                googleMapApi.animateMarker();
                marker.setPosition(event.latLng);
                map.setCenter(event.latLng)
                
                /**  Thi will work on the builder front. **/
                var pNode = $("#PLUGIN_Scheduleradv");
                var mData = { url : sServerUrl,
                    frontRequestType : 'getLatLng',
                    fLatLng : ""+event.latLng+""
                }       
                            
                PLUGIN.post(pNode, mData , 'custom' , 'json', function (serverResponse){
                    googleMapApi.decodeLatitudeLongitude(serverResponse.fLatitude,serverResponse.fLongitude)
                })          
                            
                
                googleMapApi.infoWindow.close()
          }) 
          
          google.maps.event.addListener(marker,'click',function(){
                googleMapApi.infoWindow.open(map,marker)
          })
  },viewMapSearch : function(lt,lg){
	  
	  this.decodeLatitudeLongitude(lt,lg)
	  // this.setMarkerLocation("('"+parseFloat(lt)+"','"+parseFloat(lg)+"')");
  }
    
}