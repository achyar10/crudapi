<?php

if (isset($user_merchant)) {
	$id = $user_merchant['user_merchant_id'];
	$inputEmailValue = $user_merchant['user_merchant_email'];
	$inputNameValue = $user_merchant['user_merchant_full_name'];
	$inputStatusValue = $user_merchant['user_merchant_status'];

} else {
	$inputEmailValue = set_value('user_merchant_email');
	$inputNameValue = set_value('user_merchant_full_name');
	$inputStatusValue = set_value('user_merchant_status');
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

							<input type="hidden" name="user_merchant_id" value="<?php echo $user_merchant['user_merchant_id']; ?>">

							<div class="form-group">
								<label>Email <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
								<input name="user_merchant_email" type="text" class="form-control" value="<?php echo $inputEmailValue ?>" placeholder="email">
							</div> 
							<div class="form-group">
								<label>Full Name <small>*</small></label>
								<input name="user_merchant_full_name" type="text" class="form-control" value="<?php echo $inputNameValue ?>" placeholder="Full Name">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Status</label>
								<div class="radio">
									<input type="radio" name="user_merchant_status" value="1"> Active &nbsp;&nbsp;&nbsp;
									<input type="radio" name="user_merchant_status" value="0"> Not Active
								</div>
							</div>
							<div class="mt-3">
								<button type="submit" class="btn btn-success btn-block">Save</button>
								<a href="<?php echo site_url('manage/merchant/view/'.$user_merchant['merchant_merchant_id']) ?>" class="btn btn-dark btn-block">Cancel</a>
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