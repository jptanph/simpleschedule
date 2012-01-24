$(document).ready(function(){
    options = { 'years_between' : [2000,2030],'format' : 'yyyy/mm/dd' };
    $("#start_date, #end_date").BuilderCalendar(options);
});

var adminPageView = {
		
	execUpdate : function(){
		
	},execGMAP : function(){
        $(".search_result_area").remove();
        popup.load('simpleschedule_google_map').skin('admin').layer({
            'title' : 'Google Map',
            'width' : 420,
            'classname': 'ly_set ly_editor'
        });

       googleMapApi.initialize('asd');
	}

}