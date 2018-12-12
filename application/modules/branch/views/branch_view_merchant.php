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
									<td>Branch Name</td>
									<td>:</td>
									<td><?php echo $branch['branch_name'] ?></td>
								</tr>
								<tr>
									<td>Branch Telephone</td>
									<td>:</td>
									<td><?php echo $branch['branch_tlp'] ?></td>
								</tr>
								<tr>
									<td>Branch Address</td>
									<td>:</td>
									<td><?php echo $branch['branch_address'] ?></td>
								</tr>
								<tr>
									<td>Created Date</td>
									<td>:</td>
									<td><?php echo pretty_date($branch['branch_input_date'],'d F Y',false) ?></td>
								</tr>
							</table>
							<a href="<?php echo site_url('merchant/branch') ?>" class="btn btn-primary btn-sm">Back</a>
							<a href="<?php echo site_url('merchant/branch/edit/'.$branch['branch_id']) ?>" class="btn btn-success btn-sm">Edit</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">User Branch <button type="button" class="btn btn-success btn-round btn-icon btn-sm" data-toggle="modal" data-target="#addUser"><i class="fa fa-plus"></i></button></h5>
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
											<a href="<?php echo site_url('merchant/branch/edit_user/'.$row['branch_branch_id'].'/'.$row['user_merchant_id']) ?>" class="btn btn-primary btn-round btn-icon btn-sm"><i class="fa fa-pencil" data-toggle="tooltip" title="Edit User"></i></a>
											<a href="<?php echo site_url('merchant/branch/rpw/'.$row['branch_branch_id'].'/'.$row['user_merchant_id']) ?>" class="btn btn-warning btn-round btn-icon btn-sm"><i class="nc-icon nc-lock-circle-open" data-toggle="tooltip" title="Reset Password"></i></a>
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
					<h5 class="modal-title">Tambah User Branch</h5>
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


