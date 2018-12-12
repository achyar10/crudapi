<?php

if (isset($merchant)) {
	$id = $merchant['merchant_id'];
	$inputCodeValue = $merchant['merchant_code'];
	$inputNameValue = $merchant['merchant_name'];

} else {
	$inputCodeValue = set_value('merchant_code');
	$inputNameValue = set_value('merchant_name');
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
							<?php if (isset($merchant)) { ?>
								<input type="hidden" name="merchant_id" value="<?php echo $merchant['merchant_id']; ?>">
							<?php } ?>
							<div class="form-group">
								<label>Merchant Code <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
								<input name="merchant_code" type="text" class="form-control" <?php echo (isset($merchant)) ? 'disabled' : ''; ?> value="<?php echo $inputCodeValue ?>" placeholder="Code">
							</div> 

							<div class="form-group">
								<label>Merchant Name <small>*</small></label>
								<input name="merchant_name" type="text" class="form-control" value="<?php echo $inputNameValue ?>" placeholder="Name">
							</div>

						</div>
						<div class="col-md-3">
							<div class="mt-4">
								<button type="submit" class="btn btn-success btn-block">Save</button>
								<a href="<?php echo site_url('manage/merchant') ?>" class="btn btn-dark btn-block">Cancel</a>
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