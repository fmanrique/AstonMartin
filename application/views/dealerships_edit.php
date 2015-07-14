
<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header">
				<h4><i class="icon-edit"></i> Edit Dealership</h4>
			</div>
			<div class="widget-content">
				<form class="form-horizontal row-border" method="post" id="form" action="<?php echo base_url() . "dealerships/update/" . $data['id']; ?>">

					<div class="form-group">
						<label class="col-md-2 control-label">Name <span class="required">*</span></label>
						<div class="col-md-10">
							<input type="text" name="name" class="form-control required" value="<?php echo $data['name']; ?>">
						</div>			
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Description</label>
						<div class="col-md-10">
							<textarea name="description" class="form-control"><?php echo $data['description']; ?></textarea>
						</div>			
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Per unit new car sales revenue <span class="required">*</span></label>
						<div class="col-md-10">
							<input type="text" name="revenue" class="form-control required" placeholder="$ 0.00" value="<?php echo $data['revenue']; ?>">
						</div>			
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Currency <span class="required">*</span></label>
						<div class="col-md-10">
							<select class="form-control" id="currency_id" name="currency_id">
								<?php foreach($currencies as $key => $currency) {?>
								<option value="<?php echo $currency['id']; ?>"><?php echo $currency['description']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>

					<?php if($user_type_id == 1): ?>
					<div class="form-group">
						<label class="col-md-2 control-label">Region</label>
						<div class="col-md-10">
							<select class="form-control" id="region_id" name="region_id">
								<?php foreach($regions as $key => $region) {?>
								<option value="<?php echo $region['id']; ?>" <?php echo ($region['id'] == $data['region_id']) ? "selected" : "" ?>><?php echo $region['description']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>	
					<?php endif; ?>

					
					<div class="form-actions">
						<input type="button" onclick="javascript:location.href='<?php echo base_url() . "dealerships"; ?>'" value="Cancel" class="btn btn-primary pull-left">
						<input type="submit" value="Save" class="btn btn-primary pull-right">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
