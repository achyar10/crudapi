<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><?php echo ($title != NULL) ? $title : '' ?></h4>
			</div>
			<div class="card-body mb-3">
				<?php echo form_open(current_url()); ?>
				<div class="row">
					<div class="col-md-9">
						<?php echo validation_errors(); ?>
						<div class="form-group">
							<label>New Password *</label>
							<input type="password" name="user_merchant_password" class="form-control" placeholder="New Password">
								<input type="hidden" name="user_merchant_id" value="<?php echo $user_merchant['user_merchant_id'] ?>" >
						</div>
						<div class="form-group">
							<label> New Password Confirmation *</label>
							<input type="password" name="passconf" class="form-control" placeholder="New Password Confirmation" >
						</div>
					</div>
					<div class="col-md-3">
						<div class="mt-4">
							<button type="submit" class="btn btn-block btn-success">Save</button>
							<a href="<?php echo site_url('merchant/branch/view/'.$user_merchant['branch_branch_id']); ?>" class="btn btn-block btn-secondary">Cancel</a>
						</div>
					</div>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>


