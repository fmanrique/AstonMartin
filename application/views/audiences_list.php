<div class="row">
	<div class="col-md-12 mb20">
		<a href="<?php echo base_url() . "audiences/add/"; ?>" class="btn btn-primary">New Audience</a>
	</div>
	<!--=== Static Table ===-->
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header">
				<h4><i class="icon-edit"></i> Audiences</h4>
			</div>
			<div class="widget-content no-padding">
				<table class="table datatable" id="audiences">
					<thead>
						<tr>
							<th class="no-sort">Description</th>
							<th class="align-center no-sort">Edit</th>
							<th class="align-center no-sort">Delete</th>
						</tr>
					</thead>
					<tbody>	
					<?php foreach($data as $key => $audience) {?>
						</tr>
							<td><?php echo $audience['description']; ?></td>
							<td class="align-center">
								<span class="btn-group">
									<a href="<?php echo base_url() . "audiences/edit/" . $audience['id']; ?>" title="Edit" class="bs-tooltip"><i class="icon-pencil"></i></a>
								</span>
							</td>
							<td class="align-center">
								<span class="btn-group">
									<a href="javascript:void()" onclick="javascript:delete_item('<?php echo base_url() . "audiences/delete/" . $audience['id']; ?>')" title="Delete" class="bs-tooltip"><i class="icon-remove-sign"></i></a>
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
