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
										<input type="checkbox" class="uniform" value="<?php echo $audience['id']; ?>" name="audience[]"> <?php echo $audience['description']; ?>
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
										<input type="checkbox" class="uniform" value="<?php echo $item['id']; ?>" name="focus[]"> <?php echo $item['description']; ?>
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
									<label class="checkbox-inline">
										<input type="checkbox" class="uniform" value="<?php echo $model['id']; ?>" name="model[]"> <?php echo $model['description']; ?>
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

