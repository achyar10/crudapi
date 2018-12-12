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
							<tr>
								<th>No</th>
								<th>Merchant Name</th>
								<th>Payment Total</th>
								<th>Bank</th>
								<th>Created Date</th>
								<th>Valid Date</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (!empty($payment)) {
								$i = 1;
								foreach ($payment as $row):
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['merchant_name']; ?></td>
										<td><?php echo 'Rp. '. number_format($row['payment_total']); ?></td>
										<td><?php echo $row['bank_vendor']; ?></td>
										<td><?php echo pretty_date($row['payment_create_date'],'d F Y',false); ?></td>
										<td><?php echo pretty_date($row['due_date'],'d F Y',false); ?></td>
										<td>
											<?php if($row['payment_status']==0){ ?>
												<span class="badge red">Not Confirmed</span>
											<?php } elseif($row['payment_status']==1) { ?>
												<span class="badge yellow">Pending</span>
											<?php } elseif($row['payment_status']==2) { ?>
												<span class="badge green">Done</span>
											<?php } else { ?>
												<span class="badge">Rejected</span>
											<?php } ?>
										</td>
										<td>
											<a href="<?php echo site_url('payment/detail/'.$row['payment_id']) ?>" class="btn btn-info btn-icon btn-round btn-sm">Detail</a>
										</td>
									</tr>
									<?php
									$i++;
								endforeach;
							} else {
								?>
								<tr id="row">
									<td colspan="8" align="center">Data Empty</td>
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