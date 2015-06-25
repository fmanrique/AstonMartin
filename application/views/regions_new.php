
<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header">
				<h4><i class="icon-edit"></i> New Region</h4>
			</div>
			<div class="widget-content">
				<form class="form-horizontal row-border" method="post" id="form" action="<?php echo base_url() . "regions/save/"; ?>">
					<div class="form-group">
						
						<label class="col-md-2 control-label">Name <span class="required">*</span></label>
						<div class="col-md-10">
							<input type="text" name="description" class="form-control required">
						</div>
					
					</div>

					
					<div class="form-actions">
						<input type="button" onclick="javascript:location.href='<?php echo base_url() . "regions"; ?>'" value="Cancel" class="btn btn-primary pull-left">
						<input type="submit" value="Save" class="btn btn-primary pull-right">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
