<div class="row">
	<div class="col-md-12 mb20">
		<a href="<?php echo base_url() . "users/add/"; ?>" class="btn btn-primary">New Dealer User</a>
	</div>
	<!--=== Static Table ===-->
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header">
				<h4><i class="icon-user"></i>Dealer Users</h4>
				
			</div>
			<div class="widget-content no-padding">
				<table class="table table-striped table-checkable table-hover datatable">
					<thead>
						<tr>
							<th class="hidden-xs">Name</th>
							<th>Email</th>
							<th>Dealership</th>
							<th class="hidden-xs">Region</th>
							<th class="hidden-xs">Security Level</th>
							<th class="align-center no-sort">Edit</th>
							<th class="align-center no-sort">Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($data as $key => $user) {?>
						<tr>
							<td class="hidden-xs"><?php echo $user['name']; ?></td>
							<td><?php echo $user['email']; ?></td>
							<td><?php echo $user['dealership_name']; ?></td>
							<td class="hidden-xs"><?php echo $user['region_name']; ?></td>
							<td class="hidden-xs"><?php echo $user['type']; ?></td>
							<td class="align-center">
								<span class="btn-group">
									<a href="<?php echo base_url() . "users/edit/" . $user['id']; ?>" title="Edit" class="bs-tooltip"><i class="icon-pencil"></i></a>
								</span>
							</td>
							<td class="align-center">
								<span class="btn-group">
									<a href="javascript:void()" onclick="javascript:delete_item('<?php echo base_url() . "users/delete/" . $user['id']; ?>')" title="Delete" class="bs-tooltip"><i class="icon-remove-sign"></i></a>
								</span>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div> <!-- /.widget-content -->
		</div> <!-- /.widget -->
	</div> <!-- /.col-md-6 -->
	<!-- /Static Table -->
</div> <!-- /.row -->