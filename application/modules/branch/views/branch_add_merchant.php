<?php

if (isset($branch)) {
	$id = $branch['branch_id'];
	$inputNameValue = $branch['branch_name'];
	$inputTlpValue = $branch['branch_tlp'];
	$inputAddValue = $branch['branch_name'];

} else {
	$inputNameValue = set_value('branch_name');
	$inputTlpValue = set_value('branch_tlp');
	$inputAddValue = set_value('branch_name');
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
							<?php if (isset($branch)) { ?>
								<input type="hidden" name="branch_id" value="<?php echo $branch['branch_id']; ?>">
							<?php } ?>

							<div class="form-group">
								<label>Branch Name <small>*</small></label>
								<input name="branch_name" type="text" class="form-control" value="<?php echo $inputNameValue ?>" placeholder="Name">
							</div>

							<div class="form-group">
								<label>Branch Telephone <small>*</small></label>
								<input name="branch_tlp" type="text" class="form-control" value="<?php echo $inputTlpValue ?>" placeholder="Telephone">
							</div>

							<div class="form-group">
								<label>Branch Address <small>*</small></label>
								<textarea class="form-control" name="branch_address" placeholder="Address"><?php echo $inputAddValue ?></textarea>
							</div>

						</div>
						<div class="col-md-3">
							<div class="mt-4">
								<button type="submit" class="btn btn-success btn-block">Save</button>
								<a href="<?php echo site_url('merchant/branch') ?>" class="btn btn-dark btn-block">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
	$('form').submit(function(event) {
		if ($(this).hasClass('submitted')) {
			event.preventDefault();
		} else {
			$(this).find(':submit')
			.html('<i class="fa fa-spinner fa-spin"></i> Saving...')
			.attr('disabled', 'disabled');
			$(this).addClass('submitted');
		}
	});
</script>