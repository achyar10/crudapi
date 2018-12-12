<?php

if (isset($employee)) {
	$id = $employee['employee_id'];
	$inputFullnameValue = $employee['employee_full_name'];
	$inputBranchValue = $employee['branch_branch_id'];
	$inputEmailValue = $employee['employee_email'];
	$inputNipValue = $employee['employee_nip'];
	$inputPobValue = $employee['employee_pob'];
	$inputDobValue = $employee['employee_dob'];
	$inputTlpValue = $employee['employee_tlp'];
	$inputAddValue = $employee['employee_address'];
	$inputCountryValue = $employee['employee_country'];
	$inputKtpValue = $employee['employee_ktp'];
	$inputNpwpValue = $employee['employee_npwp'];
	$inputStatusValue = $employee['employee_status'];

} else {
	$inputFullnameValue = set_value('employee_full_name');
	$inputBranchValue = set_value('branch_id');
	$inputEmailValue = set_value('employee_email');
	$inputNipValue = set_value('employee_nip');
	$inputPobValue = set_value('employee_pob');
	$inputDobValue = set_value('employee_dob');
	$inputTlpValue = set_value('employee_tlp');
	$inputAddValue = set_value('employee_address');
	$inputCountryValue = set_value('employee_country');
	$inputKtpValue = set_value('employee_ktp');
	$inputNpwpValue = set_value('employee_npwp');
	$inputStatusValue = set_value('employee_status');
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
						<?php echo form_open_multipart(current_url()); ?>
							<?php echo validation_errors(); ?>
							<?php if (isset($employee)) { ?>
								<input type="hidden" name="employee_id" value="<?php echo $employee['employee_id']; ?>">
							<?php } ?>
							<div class="form-group">
								<label>Email <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
								<input name="employee_email" type="text" class="form-control" <?php echo (isset($employee)) ? 'disabled' : ''; ?> value="<?php echo $inputEmailValue ?>" placeholder="Email">
							</div>

							<div class="form-group">
								<label>NIP <small>*</small></label>
								<input name="employee_nip" type="text" class="form-control" value="<?php echo $inputNipValue ?>" placeholder="Employee NIP">
							</div>
							<div class="form-group">
								<label>Full Name <small>*</small></label>
								<input name="employee_full_name" type="text" class="form-control" value="<?php echo $inputFullnameValue ?>" placeholder="Full Name">
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Place Of Birth <small>*</small></label>
										<input name="employee_pob" type="text" class="form-control" value="<?php echo $inputPobValue ?>" placeholder="Place Of Birth">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Tanggal </label>
										<div class="input-group date " data-date="" data-date-format="yyyy-mm-dd">
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
											<input class="form-control" type="text" name="employee_dob" readonly="readonly" placeholder="Tanggal Lahir" value="<?php echo $inputDobValue; ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Country</label>
								<select name="employee_country" class="form-control">
									<option value="WNI">Indonesia</option>
									<option value="WNA">Asing</option>
								</select>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>No. KTP</label>
										<input name="employee_ktp" type="text" class="form-control" value="<?php echo $inputKtpValue ?>" placeholder="No KTP" maxlength="16">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>NPWP </label>
										<input name="employee_npwp" type="text" class="form-control" value="<?php echo $inputNpwpValue ?>" placeholder="No NPWP">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Telephone </label>
								<input name="employee_tlp" type="text" class="form-control" value="<?php echo $inputTlpValue ?>" placeholder="Telephone">
							</div>

							<div class="form-group">
								<label>Branch <small>*</small></label>
								<select name="branch_id" class="form-control">
									<option value="">-Select Branch-</option>
									<?php foreach ($branch as $row): ?> 
										<option value="<?php echo $row['branch_id']; ?>" <?php echo ($inputBranchValue == $row['branch_id']) ? 'selected' : '' ?>><?php echo $row['branch_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label>Address</label>
								<textarea class="form-control" name="employee_address" placeholder="Address"><?php echo $inputAddValue ?></textarea>								
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label >Foto</label>
								<?php if (isset($employee['employee_photo']) != NULL) { ?>
									<img src="<?php echo upload_url('employee/' . $employee['employee_photo']) ?>" class="img-responsive">
								<?php } else { ?>
									<img src="<?php echo media_url('img/default.png') ?>" id="target" alt="Choose image to upload">
								<?php } ?>
								<input type='file' id="photo" name="employee_photo">
							</div>
							<div class="form-group">
								<label>Status</label>
								<div class="radio">
									<label>
										<input type="radio" name="employee_status" value="1" <?php echo ($inputStatusValue == 1) ? 'checked' : ''; ?>> Active
									</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<label>
										<input type="radio" name="employee_status" value="0" <?php echo ($inputStatusValue == 0) ? 'checked' : ''; ?>> Non Active
									</label>
								</div>
								
							</div>
							<button type="submit" class="btn btn-success btn-block">Save</button>
							<a href="<?php echo site_url('merchant/employee') ?>" class="btn btn-dark btn-block">Cancel</a>
						</div>
					<?php echo form_close(); ?>
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

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#target').attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#photo").change(function() {
		readURL(this);
	});
</script>