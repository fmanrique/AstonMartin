<div class="row">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header">
				<h4><i class="icon-user"></i> New Dealer User</h4>
			</div>
			<div class="widget-content">
				<form class="form-horizontal row-border" method="post" id="form-users" action="<?php echo base_url() . "users/save/"; ?>">
					<div class="form-group">
						<label class="col-md-3 control-label">Name <span class="required">*</span></label>
						<div class="col-md-9">
							<input type="text" name="name" class="form-control required">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Email <span class="required">*</span></label>
						<div class="col-md-9">
							<input type="text" id="email" name="email" class="form-control required email">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Security Level <span class="required">*</span></label>
						<div class="col-md-9">
							<select class="form-control" id="user_type_id" name="user_type_id">
								<?php foreach($user_types as $key => $user_type) {?>
								<option value="<?php echo $user_type['id']; ?>"><?php echo $user_type['type']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group" id="dealership_field">
						<label class="col-md-3 control-label">Dealership <span class="required">*</span></label>
						<div class="col-md-9">
							<select class="form-control" id="dealership_id" name="dealership_id">
								<?php foreach($dealerships as $key => $dealership) {?>
								<option value="<?php echo $dealership['id']; ?>"><?php echo $dealership['name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group" style="display: none" id="region_field">
						<label class="col-md-3 control-label">Region <span class="required">*</span></label>
						<div class="col-md-9">
							<select class="form-control" id="region_id" name="region_id">
								<?php foreach($regions as $key => $region) {?>
								<option value="<?php echo $region['id']; ?>"><?php echo $region['description']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
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
						<input type="button" onclick="javascript:location.href='<?php echo base_url() . "users"; ?>'" value="Cancel" class="btn btn-primary pull-left">
						<input type="submit" value="Save" class="btn btn-primary pull-right">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script language="javascript">
	$(document).ready(function() {

		$( "#form-users" ).validate({
			rules: {
				email: {
					required: true,
					email: true,
					remote: {
						url: "<?php echo base_url(); ?>users/validate/0",
						type: "post",
						data: {
							email: function() {
								return $( "#email" ).val();
							}
						}
					},
					messages: { 
						email: "custom remote message"
					}
				}
			}
		});

		$("#user_type_id").on('change', function(){
			if ($("#user_type_id").val() == 2) {
				$("#dealership_field").hide();
				$("#region_field").show();
			} else {
				$("#dealership_field").show();
				$("#region_field").hide();
			}
		})
	});
</script>