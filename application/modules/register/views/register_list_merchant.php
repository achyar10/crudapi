<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><?php echo $title ?></h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead class="text-primary">
							<th>No</th>
							<th>Lisence Code</th>
							<th>Merchant Code</th>
							<th>Merchant Name</th>
							<th>Status</th>
						</thead>
						<tbody>
							<?php
							if (!empty($register)) {
								$i = 1;
								foreach ($register as $row):
									$arr = str_split($row['register_code'], "4");
									$code_new = implode("-", $arr);
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $code_new; ?></td>
										<td><?php echo $row['merchant_code']; ?></td>
										<td><?php echo $row['merchant_name']; ?></td>
										<td><?php echo ($row['register_status']==0) ? '<span class="badge badge-primary">Unused</span>' : (($row['register_status']==1) ? '<span class="badge badge-success">Used</span>' : '<span class="badge badge-danger">Inactive</span>'); ?></span></td>
									</tr>
									<?php
									$i++;
								endforeach;
							} else {
								?>
								<tr id="row">
									<td colspan="6" align="center">Data Empty</td>
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