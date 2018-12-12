<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><?php echo $title ?> <a href="<?php echo site_url('manage/register/add') ?>" class="btn btn-info btn-round btn-icon btn-sm"><i class="fa fa-plus"></i></a></h4>
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
							<th>Action</th>
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
										<td>
											<?php if ($row['register_status']==1) { ?>
												<a href="#RemoveModal" class="btn btn-danger btn-round btn-icon btn-sm" data-toggle="modal" title="Unused Lisence" onclick="removeLisenceStatus('<?php echo $row['register_id'] ?>', '<?php echo $code_new ?>')">
													<i class="nc-icon nc-simple-remove"></i>
												</a>
											<?php } ?>
										</td>	
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

<div id="RemoveModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myModalLabel">Unused Confirmation</h5>
			</div>
			<form action="<?php echo site_url('manage/register/unused') ?>" method="POST">
				<div class="modal-body">
					<p>Are you sure unused lisence?</p>
					<input type="hidden" name="register_id" id="getId">
					<strong><p id="getData"></p></strong>
				</div>
				<div class="modal-footer mr-3">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-danger">Unused</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	function removeLisenceStatus(id, data) {
		$('#getId').val(id)
		$('#getData').html(data)
	}
</script>