<?php

if (isset($rent)) {
	$id = $rent['rent_id'];
	$inputTypeValue = $rent['rent_type'];
	$inputPriceValue = $rent['rent_price'];

} else {
	$inputTypeValue = set_value('rent_type');
	$inputPriceValue = set_value('rent_price');
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
							<?php if (isset($rent)) { ?>
								<input type="hidden" name="rent_id" value="<?php echo $rent['rent_id']; ?>">
							<?php } ?>
							<div class="form-group">
								<label>Type Product <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
								<input name="rent_type" type="text" class="form-control" value="<?php echo $inputTypeValue ?>" placeholder="Type">
							</div> 

							<div class="form-group">
								<label>Price <small>*</small></label>
								<input name="rent_price" type="text" class="form-control numeric" value="<?php echo $inputPriceValue ?>" placeholder="Price">
							</div>

						</div>
						<div class="col-md-3">
							<div class="mt-4">
								<button type="submit" class="btn btn-success btn-block">Save</button>
								<a href="<?php echo site_url('manage/rent') ?>" class="btn btn-dark btn-block">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>