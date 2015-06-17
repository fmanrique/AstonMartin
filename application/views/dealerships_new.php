<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header">
				<h4><i class="icon-edit"></i> New Dealership</h4>
			</div>
			<div class="widget-content">
				<form class="form-horizontal row-border" method="post" id="form" action="<?php echo base_url() . "dealerships/save/"; ?>">
					<div class="form-group">
						<label class="col-md-2 control-label">Name <span class="required">*</span></label>
						<div class="col-md-10">
							<input type="text" name="name" class="form-control required">
						</div>			
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Description</label>
						<div class="col-md-10">
							<textarea name="description" class="form-control"></textarea>
						</div>			
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Zone</label>
						<div class="col-md-10">
							<select class="form-control" id="zone_id" name="zone_id">
								<?php foreach($zones as $key => $zone) {?>
								<option value="<?php echo $zone['id']; ?>"><?php echo $zone['description']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>	

					<div class="form-actions">
						<input type="button" onclick="javascript:location.href='<?php echo base_url() . "dealerships"; ?>'" value="Cancel" class="btn btn-primary pull-left">
						<input type="submit" value="Save" class="btn btn-primary pull-right">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
