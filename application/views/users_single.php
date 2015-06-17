<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header">
				<h4><i class="icon-user"></i> Edit profile User</h4>
			</div>
			<div class="widget-content">
				<form class="form-horizontal row-border" method="post" id="validate-1" action="<?php echo base_url() . "users/update/" . $data['id']; ?>">
					<div class="form-group">
						<label class="col-md-3 control-label">Name <span class="required">*</span></label>
						<div class="col-md-9">
							<input type="text" name="name" class="form-control required" value="<?php echo $data['name']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Last Name</label>
						<div class="col-md-9">
							<input type="text" name="last_name" class="form-control" value="<?php echo $data['last_name']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Email</label>
						<div class="col-md-9">
							<input type="text" name="email" class="form-control" value="<?php echo $data['email']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Username <span class="required">*</span></label>
						<div class="col-md-9">
							<input type="text" name="user_name" class="form-control required" value="<?php echo $data['user_name']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Security Level <span class="required">*</span></label>
						<div class="col-md-9">
							<select class="form-control" id="user_type_id" name="user_type_id">
								<?php foreach($user_types as $key => $user_type) {?>
								<option value="<?php echo $user_type['id']; ?>" <?php echo ($user_type['id'] == $data['user_type_id']) ? "selected" : "" ?>><?php echo $user_type['type']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Dealer <span class="required">*</span></label>
						<div class="col-md-9">
							<select class="form-control" id="dealer_id" name="dealer_id">
								<?php foreach($dealers as $key => $dealer) {?>
								<option value="<?php echo $dealer['id']; ?>" <?php echo ($dealer['id'] == $data['dealer_id']) ? "selected" : "" ?>><?php echo $dealer['name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-actions">
						<input type="submit" value="Save" class="btn btn-primary pull-right">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header">
				<h4><i class="icon-reorder"></i> Reset Password</h4>
			</div>
			<div class="widget-content">
				<form class="form-horizontal row-border" method="post" id="validate-2" action="<?php echo base_url() . "users/change_password/" . $data['id'];; ?>">
					<div class="form-group">
						<label class="col-md-3 control-label">Password <span class="required">*</span></label>
						<div class="col-md-9">
							<input type="password" name="password" class="form-control required" minlength="5">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Confirm Password <span class="required">*</span></label>
						<div class="col-md-9">
							<input type="password" name="cpassword" class="form-control required" minlength="5" equalTo="[name='password']">
						</div>
					</div>
					<div class="form-actions">
						<input type="submit" value="Change Password" class="btn btn-primary pull-right">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>