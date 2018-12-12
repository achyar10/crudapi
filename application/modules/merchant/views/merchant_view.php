<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title"><?php echo ($title != NULL) ? $title : '' ?></h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover">
								<tr>
									<td>Merchant Code</td>
									<td>:</td>
									<td><?php echo $merchant['merchant_code'] ?></td>
								</tr>
								<tr>
									<td>Merchant Name</td>
									<td>:</td>
									<td><?php echo $merchant['merchant_name'] ?></td>
								</tr>
								<tr>
									<td>Created Date</td>
									<td>:</td>
									<td><?php echo pretty_date($merchant['merchant_input_date'],'d F Y',false) ?></td>
								</tr>
							</table>
							<a href="<?php echo site_url('manage/merchant') ?>" class="btn btn-primary btn-sm">Back</a>
							<a href="<?php echo site_url('manage/merchant/edit/'.$merchant['merchant_id']) ?>" class="btn btn-success btn-sm">Edit</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-5">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Branch <button type="button" class="btn btn-success btn-round btn-icon btn-sm" data-toggle="modal" data-target="#addBranch"><i class="fa fa-plus"></i></button></h5>
			</div>
			<div class="card-body" style="margin-top: -20px">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead class=" text-primary">
							<th>No</th>
							<th>Branch Name</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php
							if (!empty($branch)) {
								$i = 1;
								foreach ($branch as $row):
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['branch_name']; ?></td>
										<td>
											<a href="<?php echo site_url('manage/merchant/edit_branch/'.$row['merchant_merchant_id'].'/'.$row['branch_id']) ?>" class="btn btn-primary btn-round btn-icon btn-sm"><i class="fa fa-pencil" data-toggle="tooltip" title="Edit Branch"></i></a>
										</td>	
									</tr>
									<?php
									$i++;
								endforeach;
							} else {
								?>
								<tr id="row">
									<td colspan="3" align="center">Data Empty</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">User Merchant <button type="button" class="btn btn-success btn-round btn-icon btn-sm" data-toggle="modal" data-target="#addUser"><i class="fa fa-plus"></i></button></h5>
			</div>
			<div class="card-body" style="margin-top: -20px">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead class=" text-primary">
							<th>No</th>
							<th>Email</th>
							<th>Full Name</th>
							<th>Action</th>
						</thead>
						<tbody>
							<?php
							if (!empty($user_merchant)) {
								$i = 1;
								foreach ($user_merchant as $row):
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['user_merchant_email']; ?></td>
										<td><?php echo $row['user_merchant_full_name']; ?></td>
										<td>
											<a href="<?php echo site_url('manage/merchant/edit_user/'.$row['merchant_merchant_id'].'/'.$row['user_merchant_id']) ?>" class="btn btn-primary btn-round btn-icon btn-sm"><i class="fa fa-pencil" data-toggle="tooltip" title="Edit User"></i></a>
											<a href="<?php echo site_url('manage/merchant/rpw/'.$row['merchant_merchant_id'].'/'.$row['user_merchant_id']) ?>" class="btn btn-warning btn-round btn-icon btn-sm"><i class="nc-icon nc-lock-circle-open" data-toggle="tooltip" title="Reset Password"></i></a>
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
		</div>
	</div>
</div>

<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-hidden="true">
	<form action="<?php echo current_url() ?>" method="post">
		<input type="hidden" name="userAdd" value="user">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title">Tambah User Merchant</h5>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Email <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
						<input name="user_merchant_email" type="text" class="form-control" placeholder="Email" required>
					</div> 
					<div class="form-group">
						<label>Full Name <small>*</small></label>
						<input name="user_merchant_full_name" type="text" class="form-control" placeholder="Full Name" required>
					</div>
					<div class="form-group">
						<label>Password <small>*</small></label>
						<input name="user_merchant_password" type="password" class="form-control" placeholder="Password" required>
					</div>            

					<div class="form-group">
						<label>Password Confirmation <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
						<input name="passconf" type="password" class="form-control" placeholder="Password Confirmation" required>
					</div>
					<div class="form-group">
						<label>Branch <small>*</small></label>
						<select name="branch_branch_id" class="form-control">
							<option value="">All Branch</option>
							<?php foreach ($branch as $row): ?> 
								<option value="<?php echo $row['branch_id']; ?>"><?php echo $row['branch_name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>       
					<div class="form-group">
						<label>Status</label>
						<div class="radio">
							<input type="radio" name="user_merchant_status" value="1"> Active &nbsp;&nbsp;&nbsp;
							<input type="radio" name="user_merchant_status" value="0"> Not Active
						</div>
					</div>
				</div>
				<div class="modal-footer mr-3">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success">Simpan</button>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="modal fade" id="addBranch" tabindex="-1" role="dialog" aria-hidden="true">
	<form action="<?php echo current_url() ?>" method="post">
		<input type="hidden" name="branchAdd" value="branch">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title">Tambah Branch</h5>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Branch Name <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
						<input name="branch_name" type="text" class="form-control" placeholder="Branch Name" required="">
					</div> 
					<div class="form-group">
						<label>Branch Telephone <small>*</small></label>
						<input name="branch_tlp" type="text" class="form-control" placeholder="Branch Telephone">
					</div>
					<div class="form-group">
						<label>Branch Address</label>
						<textarea class="form-control" name="branch_address" placeholder="Branch Address"></textarea>
					</div>
				</div>
				<div class="modal-footer mr-3">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success">Simpan</button>
				</div>
			</div>
		</div>
	</form>
</div>


