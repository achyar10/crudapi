<?php

if (isset($bank)) {
	$id = $bank['bank_id'];
	$inputVendorValue = $bank['bank_vendor'];
	$inputAccValue = $bank['bank_account'];
	$inputNameValue = $bank['bank_name'];

} else {
	$inputVendorValue = set_value('bank_vendor');
	$inputAccValue = set_value('bank_account');
	$inputNameValue = set_value('bank_name');
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title "><?php echo isset($title) ? $title : NULL ?></h4>
			</div>
			<hr class="mt-0 mb-0">
			<div class="card-body mb-3">
				<div class="row">
					<div class="col-md-9">
						<form action="<?php echo current_url() ?>" method="post">
							<?php echo validation_errors(); ?>
							<?php if (isset($bank)) { ?>
								<input type="hidden" name="bank_id" value="<?php echo $bank['bank_id']; ?>">
							<?php } ?>
							<div class="form-group">
								<label>Bank Vendor <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
								<input name="bank_vendor" type="text" class="form-control" value="<?php echo $inputVendorValue ?>" placeholder="Vendor">
							</div> 

							<div class="form-group">
								<label>Number Account <small>*</small></label>
								<input name="bank_account" type="text" class="form-control" value="<?php echo $inputAccValue ?>" placeholder="Number Account">
							</div>

							<div class="form-group">
								<label>Name of Account</label>
								<input name="bank_name" type="text" class="form-control" value="<?php echo $inputNameValue ?>" placeholder="Name Account">
							</div>

						</div>
						<div class="col-md-3">
							<div class="mt-4">
								<button type="submit" class="btn btn-success btn-block">Save</button>
								<a href="<?php echo site_url('manage/bank') ?>" class="btn btn-dark btn-block">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>