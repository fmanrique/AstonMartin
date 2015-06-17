
<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header">
				<h4><i class="icon-edit"></i> Edit Activity Type</h4>
			</div>
			<div class="widget-content">
				<form class="form-horizontal row-border" method="post" id="form" action="<?php echo base_url() . "categories/update/" . $data['id']; ?>">
					<div class="form-group">
						
						<label class="col-md-2 control-label">Parent <span class="required">*</span></label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-4">
									<select class="form-control" id="parent_id" name="parent_id">
										<option value="0">None (This is a parent)</option>
										<?php foreach($categories as $key => $category) {?>
										<option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $data['parent_id']) ? "selected" : "" ?>><?php echo $category['description']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
					</div>


					
					<div class="form-group">
						
						<label class="col-md-2 control-label">Name <span class="required">*</span></label>
						<div class="col-md-10">
							<input type="text" name="description" class="form-control required" value="<?php echo $data['description']; ?>">
						</div>
					
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">Color:</label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-4">
									<input type="text" name="color" class="form-control bs-colorpicker" value="<?php echo $data['color']; ?>" data-color-format="hex">
								</div>
							</div>
						</div>
					</div>

					
					<div class="form-actions">
						<input type="button" onclick="javascript:location.href='<?php echo base_url() . "categories"; ?>'" value="Cancel" class="btn btn-primary pull-left">
						<input type="submit" value="Save" class="btn btn-primary pull-right">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
