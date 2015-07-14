<?php $user = $this->session->userdata("user_data"); ?>
<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header">
				<h4><i class="icon-calendar"></i> New Activity</h4>
			</div>
			<div class="widget-content">
				<form class="form-horizontal row-border" method="post" id="form" action="<?php echo base_url() . "activities/save/"; ?>">
					<?php if ($user['dealership_id'] == 0): ?>
					<div class="form-group">
						<label class="col-md-2 control-label">Dealership: <span class="required">*</span></label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-6">
									<select class="form-control" id="dealership_id" name="dealership_id">
										<?php foreach($dealerships as $key => $dealership) {?>
										<option value="<?php echo $dealership['id']; ?>"><?php echo $dealership['name']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<div class="form-group">
						<label class="col-md-2 control-label">Name: <span class="required">*</span></label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-6">
									<input type="text" name="name" class="form-control required" maxlength="254">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						
						<label class="col-md-2 control-label">Activity Type <span class="required">*</span></label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-4">
									<select class="form-control" id="category_id" name="category_id" style="width: 200px">
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
								<div class="col-md-12 ">
									<?php foreach($models as $key => $model) { ?>
									<label class="checkbox-inline modelfocus">
										<input type="checkbox" class="uniform" id="model_<?php echo $model['id']; ?>" value="<?php echo $model['id']; ?>" name="model[]"><?php echo $model['description']; ?>
									</label>
									<?php } ?>
								</div>
							</div>
						</div>
						
					</div>
					<div class="form-group">
						
						<label class="col-md-2 control-label">Start Date: <span class="required">*</span></label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-12">
									<input type="text" name="start_date" class="form-control datepicker" style="width:200px" maxlength="10">
								</div>
							</div>
						</div>
					
						<label class="col-md-2 control-label">Repeated? <span class="required">*</span></label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-12">
									<label class="radio-inline">
										<input type="radio" name="repeated" value="1">
										Yes
									</label>
									<label class="radio-inline">
										<input type="radio" name="repeated" value="0" checked>
										No
									</label>
								</div>
							</div>
						</div>
					
						<div id="field-frequency" style="display: none">
							<div class="col-md-12" style="height: 12px"></div>
							<label class="col-md-2 control-label">Frequency</label>
							<div class="col-md-10">
								<div class="row">
									<div class="col-md-12">
										<?php foreach($frequencies as $key => $frequency) { ?>
										<label class="radio-inline">
											<input type="radio" value="<?php echo $frequency['id']; ?>" name="frequency_id"> <?php echo $frequency['description']; ?>
										</label>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="col-md-12" style="height: 12px"></div>
							<label class="col-md-2 control-label">Finish Date <span class="required">*</span></label>
							<div class="col-md-10">
								<div class="row">
									<div class="col-md-12">
										<input type="text" name="end_date" class="form-control datepicker required" style="width:200px" value="<?php echo $end_date ?>" maxlength="10">
									</div>
								</div>
							</div>
						</div>
						
					</div>
					<div class="form-group">
						
						<label class="col-md-2 control-label">Total expense <span class="required">*</span></label>
						<div class="col-md-10">
							<input type="text" name="expense" id="expense" class="form-control required" placeholder="$ 0.00" style="width: 200px" maxlength="8">
						</div>
					
					</div>
					<div class="form-group">
					
						<label class="col-md-2 control-label">Description <span class="required">*</span></label>
						<div class="col-md-10">
							<textarea rows="3" cols="5" name="description" class="form-control required limited" data-limit="1000" maxlength="1000"></textarea>
							<span class="help-block" id="limit-text-description">Field limited to 1000 characters.</span>
						</div>
				
					</div>

					<div class="form-group">
						
						<input type="hidden" id="metrics" name="metrics">
						<label class="col-md-2 control-label">Add Metrics:</label>
						
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-12">
									<span class="help-block">Metric</span>
									<select class="form-control" id="metrics_metric">
										<option value="0">- Select -</option>
										<?php foreach($metrics as $key => $metric) {?>
											<option value="<?php echo $metric['id']; ?>"><?php echo $metric['description']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						

						<div class="col-md-2">
							<div class="row">
								<div class="col-md-12">
									<span class="help-block">Objected</span>
									<input type="text" name="quantity" id="metrics_quantity" class="form-control" style="width: 100px" maxlength="5">
								</div>
							</div>
						</div>

						<div class="col-md-2">
							<div class="row">
								<div class="col-md-12">
									<span class="help-block">Results</span>
									<input type="text" name="results" id="metrics_results" class="form-control" style="width: 100px" maxlength="5">
								</div>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="row">
								<div class="col-md-12">
									<span class="help-block">&nbsp;</span>
									<input type="button" value="Add" id="addmetric" class="btn btn-primary pull-right">
								</div>
							</div>
						</div>
						<div class="col-md-12" style="height: 12px"></div>
						<label class="col-md-2 control-label">&nbsp;</label>
						<div class="col-md-10">
							<div class="widget box">
								<div class="widget-content no-padding">
									<input type="hidden" name="activity_metrics" id="activity_metrics">
									<table class="table" id="table_activity_metrics">
										<thead>
											<tr>
												<th style="width: 55%">Metric</th>
												<th style="width: 15%">Objected</th>
												<th style="width: 15%">Results</th>
												<th style="width: 15%; in-width: 60px" class="align-center no-sort">Delete</th>
											</tr>
										</thead>
										
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions">
						<input type="button" onclick="javascript:location.href='<?php echo base_url() . "activities"; ?>'" value="Cancel" class="btn btn-primary pull-left">
						<input type="submit" value="Save" class="btn btn-primary pull-right">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<script language="javascript">
$(document).ready(function() {
	

	$("#expense, #metrics_quantity").on('keydown', function(e){
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
	})

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
    	if ($('#metrics_metric option:selected').val() == "0") {
    		alert("Please, select Metric option");
    		return;
    	}
    	var quantity = 1;
    	var results = 1;
    	var data = t.fnGetData();

    	if ($('#metrics_quantity').val() != "") quantity = $('#metrics_quantity').val();
    	if ($('#metrics_results').val() != "") results = $('#metrics_results').val();

    	key = search_array(0, $('#metrics_metric option:selected').text(), data);


    	if (key >= 0) {
    		quantity = parseInt(data[key][1]) + parseInt(quantity);
    		results = parseInt(data[key][2]) + parseInt(results);
    		t.fnUpdate(quantity, key, 1);
    		t.fnUpdate(results, key, 2);
    		
    		update_row_id = data_input[key][0];
    		data_input[key] = [update_row_id, $('#metrics_metric option:selected').val(), quantity, results];

    	} else {
    		t.fnAddData( [
	            $('#metrics_metric option:selected').text(),
	            quantity,
	            results,
	            "<span class=\"btn-group\"><a title=\"Delete\" data-row=\"" + row_id + "\" class=\"delete-activity bs-tooltip\"><i class=\"icon-remove\"></i></a></span>"
	        ]);

    		data_input.push([row_id, $('#metrics_metric option:selected').val(), quantity, results]);

    		row_id = row_id+1;

    	}
		$('#table_activity_metrics tr td:nth-child(3)').addClass('align-center');
        

		$('#metrics_quantity').val("");
		$('#metrics_results').val("");
		$('#metrics_metric option:selected').val()
		$('#metrics_metric option:eq(0)').prop('selected', true);
    } );

	$(document).on('click','.delete-activity',function(){
    	var row = $(this).data('row');

    	key = search_id(row, data_input);
    	t.fnDeleteRow(key);
    	data_input.splice(key, 1);
	});
    
    function search_array(key, value, data) {
    	for (i = 0; i<data.length; i++) {
    		if (data[i][key] == value) {
    			return i;
    		}
    	}

    	return -1;
    }

    function search_milti_array(key, value, data) {
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


});
</script>
