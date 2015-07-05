
<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header">
				<h4><i class="icon-calendar"></i> Edit Activity</h4>
			</div>
			<div class="widget-content">
				<form class="form-horizontal row-border" method="post" id="form" action="<?php echo base_url() . "activities/update/" . $data['id']; ?>">
					<div class="form-group">
						<label class="col-md-2 control-label">Name: <span class="required">*</span></label>
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-12">
									<input type="text" name="name" class="form-control required" value="<?php echo $data['name']; ?>">
								</div>
							</div>
						</div>
						<label class="col-md-2 control-label">Status: <span class="required">*</span></label>
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-12">
									<label class="checkbox-inline" style="position: relative; top: -6px">
										<input type="radio" class="uniform" name="happened" <?php echo ($data['happened'] == 1 ? "checked" : "") ?> value="1"> <span style="position: relative; top: 4px">Completed</span>
									</label>
									<label class="checkbox-inline" style="position: relative; top: -6px">
										<input type="radio" class="uniform" name="happened" <?php echo ($data['happened'] == 0 ? "checked" : "") ?> value="0"> <span style="position: relative; top: 4px">Did Not Occur</span>
									</label>
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
													<option value="<?php echo $subcategory['id']; ?>" <?php echo ($subcategory['id'] == $data['category_id']) ? "selected" : "" ?>><?php echo $subcategory['description']; ?></option>
												<?php } ?>
											</optgroup>
										<?php else: ?>
											<option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $data['category_id']) ? "selected" : "" ?>><?php echo $category['description']; ?></option>
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
										<input type="checkbox" class="uniform" value="<?php echo $audience['id']; ?>" name="audience[]" <?php echo ($audience['checked'] == 1) ? "checked" : "" ?>><?php echo $audience['description']; ?>
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
										<input type="checkbox" class="uniform" value="<?php echo $item['id']; ?>" name="focus[]" <?php echo ($item['checked'] == 1) ? "checked" : "" ?>><?php echo $item['description']; ?>
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
										<input type="checkbox" class="uniform" value="<?php echo $model['id']; ?>" name="model[]" <?php echo ($model['checked'] == 1) ? "checked" : "" ?>><?php echo $model['description']; ?>
									</label>
									<?php } ?>
								</div>
							</div>
						</div>
						
					</div>
					<div class="form-group">
						
						<label class="col-md-2 control-label">Date: <span class="required">*</span></label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-12">
									<input type="text" name="start_date" class="form-control datepicker required" style="width:200px" readonly value="<?php echo date('m-d-Y', strtotime($data['start_date'])) ?>">
								</div>
							</div>
						</div>	
					</div>
					<div class="form-group">
						
						<label class="col-md-2 control-label">Total expense <span class="required">*</span></label>
						<div class="col-md-10">
							<input type="text" name="expense" class="form-control required" placeholder="$ 0.00" style="width: 200px"  value="<?php echo $data['expense'] ?>">
						</div>
					
					</div>
					<div class="form-group">
					
						<label class="col-md-2 control-label">Description <span class="required">*</span></label>
						<div class="col-md-10">
							<textarea rows="3" cols="5" name="description" class="form-control required limited" data-limit="1000" maxlength="1000"><?php echo $data['description'] ?></textarea>
							<span class="help-block" id="limit-text-description">Field limited to 1000 characters.</span>
						</div>
				
					</div>

					<div class="form-group">
						
						<input type="hidden" id="metrics" name="metrics">
						<label class="col-md-2 control-label">Add Metrics:</label>
						
						<div class="col-md-5">
							<div class="row">
								<div class="col-md-12">
									<span class="help-block">Metric</span>
									<select class="form-control" id="metrics_metric">
										<?php foreach($metrics as $key => $metric) {?>
											<option value="<?php echo $metric['id']; ?>"><?php echo $metric['description']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						

						<div class="col-md-3">
							<div class="row">
								<div class="col-md-12">
									<span class="help-block">Quantity</span>
									<input type="text" name="quantity" id="metrics_quantity" class="form-control" style="width: 100px">
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
												<th style="width: 60%">Metric</th>
												<th style="width: 20%">Quantity</th>
												<th style="width: 20%; in-width: 60px" class="align-center no-sort">Delete</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($activity_metrics as $key => $metric) {?>
											<tr>
												<td><?php echo $metric['metric']; ?></td>
												<td><?php echo $metric['quantity']; ?></td>
												<td class="align-center">
													<span class="btn-group"><a data-row="<?php echo $key; ?>" title="Delete" class="delete-activity"><i class="icon-remove"></i></a></span>
												</td>
											</tr>
											<?php } ?>
										</tbody>
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

<style>
	.eventStatus a li {

	}
</style>

<script language="javascript">
$(document).ready(function() {
	$("#form").submit(function() {
		var data_string = JSON.stringify(data_input);
		$('#metrics').val(data_string);
	    return true;
	});

	if ($(".modelfocus:contains('All')").find("input[type='checkbox']")[0].checked) {
		$("input[name='model[]']").each(function() {
			if ($(this).parent().context.labels[0].innerText != "All") {
				$(this).attr('disabled', true);
				$(this).parent().parent().addClass('disabled');
				$(this).prop('checked', false);
				$(this).parent().removeClass('checked');
			}
		});
	}


    $(".modelfocus:contains('All')").find("input[type='checkbox']").change(function() {  //on click 
        if(this.checked) {
			$("input[name='model[]']").each(function() {
				if ($(this).parent().context.labels[0].innerText != "All") {
					$(this).attr('disabled', true);
					$(this).parent().parent().addClass('disabled');
					$(this).prop('checked', false);
					$(this).parent().removeClass('checked');
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

    var data_input = JSON.parse('<?php echo $activity_metrics_json; ?>');
    var cols = ["0", "1", "2"];
    var row_id = 0;

    var t = $('#table_activity_metrics').DataTable();
    
    $('#addmetric').on( 'click', function () {
    	var quantity = 1;
    	var data = t.fnGetData();

    	if ($('#metrics_quantity').val() != "") quantity = $('#metrics_quantity').val();

    	key = search_array(cols[0], $('#metrics_metric option:selected').text(), data);


    	if (key >= 0) {
    		quantity = parseInt(data[key][cols[1]]) + parseInt(quantity);
    		t.fnUpdate(quantity, key, cols[1]);
    		
    		update_row_id = data_input[key][cols[0]];
    		data_input[key] = [update_row_id, $('#metrics_metric option:selected').val(), quantity];

    	} else {
    		t.fnAddData( [
	            $('#metrics_metric option:selected').text(),
	            quantity,
	            "<span class=\"btn-group\"><a title=\"Delete\" data-row=\"" + row_id + "\" class=\"delete-activity\"><i class=\"icon-remove\"></i></a></span>"
	        ]);

    		data_input.push([row_id, $('#metrics_metric option:selected').val(), quantity]);

    		row_id = row_id+1;

    	}
		$('#table_activity_metrics tr td:nth-child(3)').addClass('align-center');
        

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
    
    function search_multi_array(key, value, data) {
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
    		if (data[i][cols[0]] == id) return i;
    	}

    	return -1;
    }
});
</script>
