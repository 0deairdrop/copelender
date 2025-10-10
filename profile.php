<?php 
$pageTitle = 'Loan Profile';
require_once 'common/header.php'; 
$module = DEF_MODULE_ID_LOAN_APPLICATION;


$userid = getLoggedInUserDetailsByKey('id');
$isAdmin = doTypeCastInt(getLoggedInUserDetailsByKey('isadmin'));
$profile = [];
?>

<body class="geex-dashboard">
	<main class="geex-main-content">
		<?php require_once 'common/menu.php'; ?>
		<div class="geex-content">
			<div class="geex-content__header">
				<div class="geex-content__header__content">
					<h2 class="geex-content__header__title"><?= strtoupper($pageTitle) ?> - Update Profile</h2>
					<p class="geex-content__header__subtitle">Edit and save applicant details for this loan application.</p>
				</div>
				<div class="geex-content__header__action">
					<?php require_once 'common/userProfileSection.php'; ?>
				</div>
			</div>

			<div class="geex-content__section geex-content__form">
				<div class="geex-content__form__wrapper">
					<form id="loanProfileForm" class="needs-validation" novalidate enctype="multipart/form-data">
						<input type="hidden" name="loanId" value="<?= htmlspecialchars($id) ?>">
						<input type="hidden" name="userid" value="<?= htmlspecialchars($userid) ?>">

						<!-- Left Column -->
						<div class="geex-content__form__wrapper__item geex-content__form__left">
							<div class="geex-content__form__single">
								<h4 class="geex-content__form__single__label">Personal Information</h4>
								<div class="geex-content__form__single__box">
									<div class="input-wrapper">
										<label class="input-label">Full Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="fullName" placeholder="John Doe" value="<?= htmlspecialchars($profile['fullName'] ?? '') ?>" required>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Email <span class="text-danger">*</span></label>
										<input type="email" class="form-control" name="email" placeholder="you@domain.com" value="<?= htmlspecialchars($profile['email'] ?? '') ?>" required>
									</div>
									<div class="input-wrapper input-icon">
										<label class="input-label">Phone Number <span class="text-danger">*</span></label>
										<div class="input-group">
											<select class="form-select" name="countryCode" style="max-width:120px;">
												<option value="+234" selected>🇳🇬 +234</option>
												<option value="+1">🇺🇸 +1</option>
												<option value="+44">🇬🇧 +44</option>
												<option value="+91">🇮🇳 +91</option>
												<option value="+61">🇦🇺 +61</option>
											</select>
											<input type="tel" class="form-control" name="phone" placeholder="812 345 6789" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>" required>
										</div>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Date of Birth</label>
										<input type="date" class="form-control" name="dob" value="<?= htmlspecialchars($profile['dob'] ?? '') ?>">
									</div>
									<div class="input-wrapper">
										<label class="input-label">Employment Status</label>
										<select class="form-control" name="employment">
											<option value="">Select...</option>
											<option <?= ($profile['employment'] ?? '') == 'Employed' ? 'selected' : '' ?>>Employed</option>
											<option <?= ($profile['employment'] ?? '') == 'Self-employed' ? 'selected' : '' ?>>Self-employed</option>
											<option <?= ($profile['employment'] ?? '') == 'Unemployed' ? 'selected' : '' ?>>Unemployed</option>
											<option <?= ($profile['employment'] ?? '') == 'Student' ? 'selected' : '' ?>>Student</option>
											<option <?= ($profile['employment'] ?? '') == 'Retired' ? 'selected' : '' ?>>Retired</option>
										</select>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Annual Income (₦)</label>
										<select class="form-control" name="incomeRange">
											<option value="">Select income range</option>
											<option <?= ($profile['incomeRange'] ?? '') == 'Below ₦20,000' ? 'selected' : '' ?>>Below ₦20,000</option>
											<option <?= ($profile['incomeRange'] ?? '') == '₦20,000 - ₦50,000' ? 'selected' : '' ?>>₦20,000 - ₦50,000</option>
											<option <?= ($profile['incomeRange'] ?? '') == '₦50,000 - ₦100,000' ? 'selected' : '' ?>>₦50,000 - ₦100,000</option>
											<option <?= ($profile['incomeRange'] ?? '') == '₦100,000 - ₦200,000' ? 'selected' : '' ?>>₦100,000 - ₦200,000</option>
											<option <?= ($profile['incomeRange'] ?? '') == 'Above ₦200,000' ? 'selected' : '' ?>>Above ₦200,000</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<!-- Right Column -->
						<div class="geex-content__form__wrapper__item geex-content__form__right">
							<div class="geex-content__form__single">
								<h4 class="geex-content__form__single__label">Bank & Identification</h4>
								<div class="geex-content__form__single__box">
									<div class="input-wrapper">
										<label class="input-label">Bank Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="bankName" value="<?= htmlspecialchars($profile['bankName'] ?? '') ?>" required>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Account Holder Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="accountHolder" value="<?= htmlspecialchars($profile['accountHolder'] ?? '') ?>" required>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Account Number <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="accountNumber" value="<?= htmlspecialchars($profile['accountNumber'] ?? '') ?>" pattern="\d+" required>
									</div>

									<div class="input-wrapper">
										<label class="input-label">Upload Valid ID <span class="text-danger">*</span></label>
										<select class="form-control mb-2" name="idType" required>
											<option value="">Select ID Type</option>
											<option <?= ($profile['idType'] ?? '') == 'Passport' ? 'selected' : '' ?>>Passport</option>
											<option <?= ($profile['idType'] ?? '') == 'National Identity' ? 'selected' : '' ?>>National Identity</option>
											<option <?= ($profile['idType'] ?? '') == 'Driver’s License' ? 'selected' : '' ?>>Driver’s License</option>
										</select>
										<div class="input-group">
											<input type="file" class="form-control" name="idUpload" accept="image/*,application/pdf" required>
										</div>
										<small class="text-muted">Accepted formats: JPG, PNG, or PDF (max 5MB)</small>
									</div>
								</div>
							</div>

							<div class="geex-content__form__single">
								<h4 class="geex-content__form__single__label">Address</h4>
								<div class="geex-content__form__single__box">
									<div class="input-wrapper">
										<label class="input-label">Street Address <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="street" placeholder="123 Main St" value="<?= htmlspecialchars($profile['street'] ?? '') ?>" required>
									</div>
									<div class="input-wrapper">
										<label class="input-label">City <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="city" value="<?= htmlspecialchars($profile['city'] ?? '') ?>" required>
									</div>
									<div class="input-wrapper">
										<label class="input-label">State / Province <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="state" value="<?= htmlspecialchars($profile['state'] ?? '') ?>" required>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Postal Code <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="postalCode" value="<?= htmlspecialchars($profile['postalCode'] ?? '') ?>" required>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Country</label>
										<input type="text" class="form-control" name="country" value="<?= htmlspecialchars($profile['country'] ?? '') ?>">
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 text-end mt-4">
							<button type="button" id="saveBtn" class="geex-btn geex-btn--outline-secondary me-2"><i class="uil uil-save"></i> Save draft</button>
							<button type="submit" class="geex-btn geex-btn--primary"><i class="uil uil-check-circle"></i> Save & update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</main>

	<script>
	const moduleId = '<?= $module ?>';
	const form = document.getElementById('loanProfileForm');

	function showOverlay() {
		$('body').append(`<div id="block-overlay" class="geex-overlay">Processing...</div>`);
	}
	function hideOverlay() { $('#block-overlay').remove(); }

	form.addEventListener('submit', e => {
		e.preventDefault();
		if (!form.checkValidity()) { form.classList.add('was-validated'); return; }
		const formData = new FormData(form);
		formData.append('action', 'updateLoanProfile');
		formData.append('moduleId', moduleId);
		showOverlay();
		$.ajax({
			type: 'POST',
			url: 'actions',
			data: formData,
			processData: false,
			contentType: false,
			dataType: 'json',
			success: res => {
				hideOverlay();
				if (res.status === 'success') throwSuccess(res.message || 'Profile saved', 'toast-top-right');
				else throwWarning(res.message || 'Save failed', 'toast-top-right');
			},
			error: () => { hideOverlay(); throwWarning('Request failed', 'toast-top-right'); }
		});
	});

	$('#saveBtn').click(() => {
		const data = Object.fromEntries(new FormData(form).entries());
		localStorage.setItem('loanProfileDraft', JSON.stringify(data));
		throwSuccess('Draft saved locally', 'toast-top-right');
	});

	window.addEventListener('load', () => {
		const draft = localStorage.getItem('loanProfileDraft');
		if (draft) {
			try {
				Object.entries(JSON.parse(draft)).forEach(([k,v]) => { if(form.elements[k]) form.elements[k].value=v; });
			} catch(e){}
		}
	});
	</script>

	<?php require_once 'common/footer.php'; ?>
</body>
</html>