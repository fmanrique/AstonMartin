	<?php $user = $this->session->userdata("user_data"); ?>
<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header" onclick="javascript:show_filters();" style="cursor:pointer">
				<h4><i id="icon_activity_fiilters" class="icon-angle-right"></i><span style="position: absolute; left: 45px">Activity Filters</span></h4>
			</div>
			<div class="widget-content" id="activity_filters">
				<form class="form-horizontal row-border" method="post" id="form" action="<?php echo base_url() . "reports/export/"; ?>">
					<div class="form-group">
						<label class="col-md-2 control-label">Status:</label>	
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-12">
									<label class="checkbox-inline">
										<input type="checkbox" class="uniform" name="happened[]" value="1"> Happened
									</label>
									<label class="checkbox-inline">
										<input type="checkbox" class="uniform" name="happened[]" value="0"> Not happened
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-12" style="height: 12px"></div>
						<label class="col-md-2 control-label">From:</label>
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-12">
									<input type="text" id="start_date" name="start_date" class="form-control datepicker" style="width:200px">
								</div>
							</div>
						</div>

						<label class="col-md-2 control-label">To:</label>
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-12">
									<input type="text" id="end_date" name="end_date" class="form-control datepicker" style="width:200px">
								</div>
							</div>
						</div>

						<label class="col-md-2 control-label">Activity Type </label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-4">
									<select class="form-control" id="category" name="category" style="width: 200px">
										<option value="0">All</option>
										<?php foreach($categories as $key => $category) {?>
										<?php if (!empty($category['childs'])) : ?> 
											<optgroup label="<?php echo $category['description']; ?>">
												<?php foreach($category['childs'] as $key2 => $subcategory) {?>
													<option value="<?php echo $subcategory['id']; ?>"><?php echo $subcategory['description']; ?></option>
												<?php } ?>
											</optgroup>
										<?php else: ?>
											<option value="<?php echo $category['id']; ?>"><?php echo $category['description']; ?></option>
										<?php endif ?>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-12" style="height: 12px"></div>
						<label class="col-md-2 control-label">Audience</label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-12">
									<?php foreach($audiences as $key => $audience) { ?>
									<label class="checkbox-inline">
										<input type="checkbox" class="uniform" value="<?php echo $audience['id']; ?>" name="audience[]"><?php echo $audience['description']; ?>
									</label>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="col-md-12" style="height: 12px"></div>
						<label class="col-md-2 control-label">Activity Focus</label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-12">
									<?php foreach($focus as $key => $item) { ?>
									<label class="checkbox-inline">
										<input type="checkbox" class="uniform" value="<?php echo $item['id']; ?>" name="focus[]"><?php echo $item['description']; ?>
									</label>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="col-md-12" style="height: 12px"></div>
						<label class="col-md-2 control-label">Model Focus</label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-12">
									<?php foreach($models as $key => $model) { ?>
									<label class="checkbox-inline modelfocus">
										<input type="checkbox" class="uniform" value="<?php echo $model['id']; ?>" name="model[]"><?php echo $model['description']; ?>
									</label>
									<?php } ?>
								</div>
							</div>
						</div>
						
					</div>
					<div class="form-actions">
						<input type="button" value="Filter" class="btn btn-primary pull-right" id="btnFilter">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<script language="javascript">
$(document).ready(function() {
	$("#form").submit(function() {
		var data_string = JSON.stringify(data_input);
		$('#metrics').val(data_string);
	    return true;
	});

	$("input[name='repeated']").change(function() {  //on click 
        if($(this).val() == 1) { // check select status
            $('#field-frequency').show();
        }else{
            $('#field-frequency').hide();
        }
    });

    $(".modelfocus:contains('All')").find("input[type='checkbox']").change(function() {  //on click 
        if(this.checked) {
			$("input[name='model[]']").each(function() {
				if ($(this).parent().context.labels[0].innerText != "All") {
					$(this).attr('disabled', true);
					$(this).parent().parent().addClass('disabled');
				}
			});
		} else {
			$("input[name='model[]']").each(function() {
				if ($(this).parent().context.labels[0].innerText != "All") {
					$(this).attr('disabled', false);
					$(this).parent().parent().removeClass('disabled');
				}
				
			});
		}
    });

    $( ".datepicker" ).datepicker({
		defaultDate: +7,
		showOtherMonths:true,
		autoSize: true,
		appendText: '<span class="help-block">(mm/dd/yyyy)</span>',
		dateFormat: 'mm/dd/yy'
	});

    var data_input = Array();
    var row_id = 0;

    var t = $('#table_activity_metrics').DataTable();
    
    $('#addmetric').on( 'click', function () {
    	var quantity = 1;
    	var data = t.fnGetData();

    	if ($('#metrics_quantity').val() != "") quantity = $('#metrics_quantity').val();

    	key = search_array([0,1], [$('#metrics_type option:selected').text(), $('#metrics_metric option:selected').text()], data);


    	if (key >= 0) {
    		quantity = parseInt(data[key][2]) + parseInt(quantity);
    		t.fnUpdate(quantity, key, 2);
    		
    		update_row_id = data_input[key][0];
    		data_input[key] = [update_row_id, $('#metrics_type option:selected').val(), $('#metrics_metric option:selected').val(), quantity];

    	} else {
    		t.fnAddData( [
	            $('#metrics_type option:selected').text(),
	            $('#metrics_metric option:selected').text(),
	            quantity,
	            "<span class=\"btn-group\"><a title=\"Delete\" data-row=\"" + row_id + "\" class=\"delete-activity bs-tooltip\"><i class=\"icon-remove\"></i></a></span>"
	        ]);

    		data_input.push([row_id, $('#metrics_type option:selected').val(), $('#metrics_metric option:selected').val(), quantity]);

    		row_id = row_id+1;

    	}
		$('#table_activity_metrics tr td:nth-child(4)').addClass('align-center');
        

    } );

	$(document).on('click','.delete-activity',function(){
    	var row = $(this).data('row');

    	key = search_id(row, data_input);
    	t.fnDeleteRow(key);
    	data_input.splice(key, 1);
	});
    
    function search_array(key, value, data) {
    	found = true;
    	for (i = 0; i<data.length; i++) {
    		for (k = 0; k < key.length; k++) {
    			if (data[i][key[k]] != value[k]) {
    				found = false;
    				k = key.length + 1;
				}
    		}

    		if (found) return i;

    		found = true;
    	}

    	return -1;
    }

   

    function search_id(id, data) {
    	for (i = 0; i<data.length; i++) {
    		if (data[i][0] == id) return i;
    	}

    	return -1;
    }

    $("#activity_filters").hide();

});

function show_filters() {
	if ($("#activity_filters").css('display') == 'none') {
	//if ($("#activity_filters:hidden")) {
		$("#activity_filters").show();
		$("#icon_activity_fiilters").removeClass("icon-angle-right");
		$("#icon_activity_fiilters").addClass("icon-angle-down");
	} else {
		$("#activity_filters").hide();
		$("#icon_activity_fiilters").removeClass("icon-angle-down");
		$("#icon_activity_fiilters").addClass("icon-angle-right");
	}
	
}
</script>



<div class="row">
	
	<div class="col-md-12 mb20">
		<a href="<?php echo base_url() . "activities/add/"; ?>" class="btn btn-primary">New Activity</a>
	</div>
	
	<!--=== Static Table ===-->
	<div class="col-md-12">
		<div class="widget">
			<div class="widget-content">
				<div id="calendar"></div>
			</div>
		</div> <!-- /.widget -->
	</div> <!-- /.col-md-6 -->
	<!-- /Static Table -->
</div> <!-- /.row -->

<script>
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
</script>

