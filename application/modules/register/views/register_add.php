<?php

if (isset($register)) {
	$inputMerchantValue = $register['merchant_merchant_id'];
} else {
	$inputMerchantValue = set_value('merchant_merchant_id');
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

							<div class="form-group">
								<label>Merchant <small>*</small></label>
								<select name="merchant_merchant_id" class="form-control">
									<option value="">-Select Merchant-</option>
									<?php foreach ($merchant as $row): ?> 
										<option value="<?php echo $row['merchant_id']; ?>" <?php echo ($inputMerchantValue == $row['merchant_id']) ? 'selected' : '' ?>><?php echo $row['merchant_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>

							<div class="form-group">
								<label>PIN <small>*</small></label>
								<input name="register_pin" type="password" class="form-control" placeholder="PIN">
							</div>            

							<div class="form-group">
								<label>PIN Confirmation <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
								<input name="pinconf" type="password" class="form-control" placeholder="PIN Confirmation">
							</div>       
						</div>
						<div class="col-md-3">
							<div class="mt-4">
								<button type="submit" class="btn btn-success btn-block">Save</button>
								<a href="<?php echo site_url('manage/register') ?>" class="btn btn-dark btn-block">Cancel</a>
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
            .html('Saving...')
            .attr('disabled', 'disabled');
            $(this).addClass('submitted');
        }
    });
</script>