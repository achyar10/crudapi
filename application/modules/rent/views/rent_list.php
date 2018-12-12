<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><?php echo $title ?> <a href="<?php echo site_url('manage/rent/add') ?>" class="btn btn-info btn-round btn-icon btn-sm"><i class="fa fa-plus"></i></a></h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead class="text-primary">
							<th>No</th>
							<th>Type Product</th>
							<th>Price</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php
							if (!empty($rent)) {
								$i = 1;
								foreach ($rent as $row):
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['rent_type']; ?></td>
										<td><?php echo 'Rp. '. number_format($row['rent_price']); ?></td>
										<td>
											<a href="<?php echo site_url('manage/rent/edit/' . $row['rent_id']) ?>" class="btn btn-success btn-round btn-icon btn-sm"><i class="fa fa-pencil"></i></a>
										</td>	
									</tr>
									<?php
									$i++;
								endforeach;
							} else {
								?>
								<tr id="row">
									<td colspan="4" align="center">Data Empty</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php echo $this->pagination->create_links(); ?>
		</div>
	</div>
</div>