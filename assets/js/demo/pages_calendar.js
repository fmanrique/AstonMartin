/*
 * pages_calendar.js
 *
 * Demo JavaScript used on dashboard and calendar-page.
 */

//"use strict";

$(document).ready(function(){

	create_calendar();

	$("#btnFilter").on("click", function(){
		$('#calendar').fullCalendar('destroy');
		create_calendar();
	});

});

function create_calendar() {
	//===== Calendar =====//
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = 2017; //date.getFullYear();
	var current_url = base_url + 'activities/calendar';
	var calendar_url = base_url + 'activities/calendar';

	var h = {};

	if ($('#calendar').width() <= 400) {
		h = {
			left: 'title',
			center: '',
			right: 'prev,next'
		};
	} else {
		h = {
			left: 'prev,next',
			center: 'title',
			right: ''
		};
	}

	function getMonth(){
		var date = $("#calendar").fullCalendar('getDate');
		var month_int = 1;
		if (typeof date.getMonth === 'function') {
			month_int = date.getMonth() + 1;
			
		} else  {
			date = new Date();
			month_int = date.getMonth() + 1;
		}

		return month_int;
	  
	  //you now have the visible month as an integer from 0-11
	}

	$('#calendar').fullCalendar({
		disableDragging: false,
		header: h,
		editable: false,
		aspectRatio: 2,
		eventLimit: true,
		year: user_period,
		events: function( start, end, callback ) {

            var year  = end.getFullYear();
            var month = end.getMonth();


            var happened = $("input[name='happened[]']:checked").map(function() {
			    return this.value;
			}).get(happened);

            var audience = $("input[name='audience[]']:checked").map(function() {
			    return this.value;
			}).get(audience);

			var focus = $("input[name='focus[]']:checked").map(function() {
			    return this.value;
			}).get(focus);

			var model = $("input[name='model[]']:checked").map(function() {
			    return this.value;
			}).get(model);

            new_url  = calendar_url + '/' + year + '/' + month;

            if( new_url != current_url ){
                $.ajax({
                    url: new_url,
                    dataType: 'json',
                    type: 'POST',
                    data: {"happened": happened, "from": $("#start_date").val(), "to": $("#end_date").val(), "category": $("#category option:selected").val(), "audience": audience, "focus": focus, "models": model},
                    success: function( response ) {
                        current_url = new_url;
                        user_events = response;

                        callback(response);
                    }
                })
           }else{
               callback(user_events);
           }
        },
		eventRender: function(event, element) {
			icon = event.happened == 0 ? "icon-check-empty" : "icon-check";
			element.find(".fc-event-inner").before($("<span class=\"fc-event-icons\"></span>").html("<a href=\"javascript:void(0);\"\ onclick=\"javascript:deleteCalendarEvent(this," + event.id + ");\" style=\"text-decoration: none; color: #cccccc;\"><i class=\"icon-remove\" style=\"float: right; position: relative; margin: 2px\"></i></a>"));
			element.find(".fc-event-inner").before($("<span class=\"fc-event-icons\"></span>").html("<a href=\"javascript:void(0);\"\ style=\"text-decoration: none;\"><i class=\"" + icon + "\" onclick=\"javascript:changeStatusCalendarEvent(this," + event.id + "," + event.happened + ");\" onmouseover=\"javascript:statusCheckOver(this, "+event.happened+")\" onmouseout=\"javascript:statusCheckOut(this,"+event.happened+")\" style=\"float: left; position: relative; margin: 2px; color: #FFFFFF;\"></i></a>"));
		}
	});	
}

var changeStatus = false;

function statusCheckOver(e, status) {
	e.className = (e.className == "icon-check" ? "icon-check-empty" : "icon-check");
	e.style.color = "#cccccc";
	changeStatus = false;
}

function statusCheckOut(e, status) {
	if (!changeStatus) {
		e.className = (e.className == "icon-check" ? "icon-check-empty" : "icon-check");
		e.style.color = "#ffffff";
	}
}

function changeStatusCalendarEvent(e, id) {
	$.ajax({
		url: base_url + "activities/happened/" + id,
		type: 'post',
		dataType: 'text',
		success: function( text ){
			if (text == "1") {
				e.className = "icon-check";
			} else {
				e.className = "icon-check-empty";
			}
			e.style.color = "#ffffff";
			changeStatus = true;
				
		}
	});
}

function deleteCalendarEvent(e, id) {
	c = confirm("Are you sure to delete this event?");

	if (c) {
		$.ajax({
			url: base_url + "activities/delete/" + id,
			type: 'post',
			dataType: 'text',
			success: function( text ){
				if (text = "OK")
					el.hide();
			}
		});
	}

}