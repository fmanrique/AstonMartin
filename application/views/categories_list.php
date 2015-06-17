<div class="row">
	<div class="col-md-12 mb20">
		<a href="<?php echo base_url() . "categories/add/"; ?>" class="btn btn-primary">New Activity Type</a>
	</div>
	<!--=== Static Table ===-->
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header">
				<h4><i class="icon-edit"></i> Activity Types</h4>
			</div>
			<div class="widget-content no-padding">
				<table class="table datatable" id="categories">
					<thead>
						<tr>
							<th class="hidden">Id</th>
							<th class="no-sort">Description</th>
							<th class="align-center no-sort">Edit</th>
							<th class="align-center no-sort">Delete</th>
						</tr>
					</thead>
					<tbody>
						
					<?php foreach($data as $key => $category) {?>
						</tr>
							<td class="hidden"><?php echo ($key + 1); ?></td>
							<td><?php echo $category['description']; ?></td>
							<td class="align-center">
								<span class="btn-group">
									<a href="<?php echo base_url() . "categories/edit/" . $category['id']; ?>" title="Edit" class="bs-tooltip"><i class="icon-pencil"></i></a>
								</span>
							</td>
							<td class="align-center">
								<span class="btn-group">
									<a href="<?php echo base_url() . "categories/delete/" . $category['id']; ?>" title="Delete" class="bs-tooltip"><i class="icon-remove-sign"></i></a>
								</span>
							</td>
						</tr>
						<?php if (!empty($category['childs'])) : ?>
						
							<?php foreach($category['childs'] as $child => $subcategory) {?>
							<tr>
								<td class="hidden"><?php echo ($key + 1) . "." . ($child + 1); ?></td>
								<td style="padding-left: 30px">- <?php echo $subcategory['description']; ?></td>
								<td class="align-center">
									<span class="btn-group">
										<a href="<?php echo base_url() . "categories/edit/" . $subcategory['id']; ?>" title="Edit" class="bs-tooltip"><i class="icon-pencil"></i></a>
									</span>
								</td>
								<td class="align-center">
									<span class="btn-group">
										<a href="<?php echo base_url() . "categories/delete/" . $subcategory['id']; ?>" title="Delete" class="bs-tooltip"><i class="icon-remove-sign"></i></a>
									</span>
								</td>
							</tr>
							<?php } ?>
						
						<?php endif ?>
					<?php } ?>
						

					</tbody>
				</table>
			</div> <!-- /.widget-content -->
		</div> <!-- /.widget -->
	</div> <!-- /.col-md-6 -->
	<!-- /Static Table -->
</div> <!-- /.row -->
