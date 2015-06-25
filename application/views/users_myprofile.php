<form class="form-horizontal" action="<?php echo base_url() . "users/update_myprofile/" . $data['id']; ?>" method="post" id="validate-1">
	<div class="col-md-12  form-vertical no-margin">
		<div class="widget">
			<div class="widget-header">
				<h4>General Information</h4>
			</div>
			<div class="widget-content">
				<div class="row">
					<div class="col-md-4 col-lg-2">
						<label class="control-label">Name: <span class="required">*</span></label>
					</div>

					<div class="col-md-8 col-lg-10">
						<div class="form-group">
							<input type="text" name="name" class="form-control required" value="<?php echo $data['name']; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-lg-2">
						<label class="control-label">Email:</label>
					</div>

					<div class="col-md-8 col-lg-10">
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $data['email']; ?>" disabled="disabled">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-lg-2">
						<label class="control-label">Dealership:</label>
					</div>

					<div class="col-md-8 col-lg-10">
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $data['dealership_name']; ?>" disabled="disabled">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-lg-2">
						<label class="control-label">Region:</label>
					</div>

					<div class="col-md-8 col-lg-10">
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $data['region_name']; ?>" disabled="disabled">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-lg-2">
						<label class="control-label">Security Level:</label>
					</div>

					<div class="col-md-8 col-lg-10">
						<div class="form-group">
							<input type="text" class="form-control" value="<?php echo $data['type']; ?>" disabled="disabled">
						</div>
					</div>
				</div>
			</div> <!-- /.widget-content -->
		</div> <!-- /.widget -->
	</div> <!-- /.col-md-12 -->

	<div class="col-md-12 form-vertical no-margin">
		<div class="widget">
			<div class="widget-header">
				<h4>Settings</h4>
			</div>
			<div class="widget-content">
				
				<div class="row">
					<div class="col-md-4 col-lg-2">
						<label class="control-label" style="padding-top: 12px">Change password:</label>
					</div>
					<div class="col-md-8 col-lg-10">
						<div class="form-group">
							<label class="control-label">New password:</label>
							<input type="password" name="password" class="form-control" placeholder="Leave empty for no password-change" minlength="5">
						</div>

						<div class="form-group">
							<label class="control-label">Repeat new password:</label>
							<input type="password" name="password_repeat" class="form-control" placeholder="Leave empty for no password-change" minlength="5" equalTo="[name='password']">
						</div>
					</div>
				</div> <!-- /.row -->
			</div> <!-- /.widget-content -->
		</div> <!-- /.widget -->

		<div class="form-actions">
			<input type="submit" value="Update Account" class="btn btn-primary pull-right">
		</div>
	</div> <!-- /.col-md-12 -->
</form>
