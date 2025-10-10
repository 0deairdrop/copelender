<?php 
$pageTitle = 'Loan Profile';
require_once 'common/header.php'; 
$module = DEF_MODULE_ID_LOAN_APPLICATION;



// Logged in user id for AJAX submission
$userid = getLoggedInUserDetailsByKey('id');
$isAdmin = doTypeCastInt(getLoggedInUserDetailsByKey('isadmin'));

// Try to load existing applicant profile if available (placeholder - replace with real loader if you have one)
$profile = [];
// Example: if you have a loader function, uncomment and adapt:
// $profile = Src\Module\LoanApplication\LoanApplicationFunctions::getApplicantProfile($id);

?>

<body class="geex-dashboard">
	<main class="geex-main-content">

		<?php require_once 'common/menu.php'; ?>

		<div class="geex-content">
			<div class="geex-content__header">
				<div class="geex-content__header__content">
					<h2 class="geex-content__header__title"><?= strtoupper($pageTitle) ?> - Update Profile</h2>
					<p class="geex-content__header__subtitle">Update bank and address details for this loan application.</p>
				</div>

				<div class="geex-content__header__action">
					<?php require_once 'common/userProfileSection.php'; ?>
				</div>
			</div>

			<div class="geex-content__section geex-content__form">
				<div class="card">
					<div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
						<div>
							<h4 class="mb-1">Applicant Profile</h4>
							<p class="text-muted small mb-0">Fields marked <span class="text-danger">*</span> are required.</p>
						</div>
						<button id="previewBtn" class="btn btn-outline-primary btn-sm"><i class="uil uil-eye me-1"></i> Preview</button>
					</div>

					<div class="card-body">
						<form id="loanProfileForm" class="row g-3 needs-validation" novalidate>
							<input type="hidden" name="loanId" value="<?= htmlspecialchars($id) ?>">
							<input type="hidden" name="userid" value="<?= htmlspecialchars($userid) ?>">

							<div class="col-md-6">
								<label class="form-label">Full name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="fullName" value="<?= htmlspecialchars($profile['fullName'] ?? '') ?>" required>
							</div>

							<div class="col-md-6">
								<label class="form-label">Email <span class="text-danger">*</span></label>
								<input type="email" class="form-control" name="email" value="<?= htmlspecialchars($profile['email'] ?? '') ?>" required>
							</div>

							<div class="col-md-6">
								<label class="form-label">Phone number</label>
								<input type="tel" class="form-control" name="phone" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>">
							</div>

							<div class="col-md-6">
								<label class="form-label">Date of birth</label>
								<input type="date" class="form-control" name="dob" value="<?= htmlspecialchars($profile['dob'] ?? '') ?>">
							</div>

							<div class="col-md-6">
								<label class="form-label">Employment status</label>
								<select class="form-select" name="employment">
									<option value="">Select...</option>
									<option <?= (isset($profile['employment']) && $profile['employment'] == 'Employed') ? 'selected' : '' ?>>Employed</option>
									<option <?= (isset($profile['employment']) && $profile['employment'] == 'Self-employed') ? 'selected' : '' ?>>Self-employed</option>
									<option <?= (isset($profile['employment']) && $profile['employment'] == 'Unemployed') ? 'selected' : '' ?>>Unemployed</option>
									<option <?= (isset($profile['employment']) && $profile['employment'] == 'Student') ? 'selected' : '' ?>>Student</option>
									<option <?= (isset($profile['employment']) && $profile['employment'] == 'Retired') ? 'selected' : '' ?>>Retired</option>
								</select>
							</div>

							<div class="col-md-6">
								<label class="form-label">Annual income (optional)</label>
								<input type="number" class="form-control" name="income" value="<?= htmlspecialchars($profile['income'] ?? '') ?>">
							</div>

							<div class="col-12 mt-3"><hr></div>

							<h5 class="col-12">Bank information</h5>

							<div class="col-md-6">
								<label class="form-label">Bank name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="bankName" value="<?= htmlspecialchars($profile['bankName'] ?? '') ?>" required>
							</div>

							<div class="col-md-6">
								<label class="form-label">Account holder name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="accountHolder" value="<?= htmlspecialchars($profile['accountHolder'] ?? '') ?>" required>
							</div>

							<div class="col-md-6">
								<label class="form-label">Account number <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="accountNumber" value="<?= htmlspecialchars($profile['accountNumber'] ?? '') ?>" pattern="\d+" required>
							</div>

							<div class="col-md-6">
								<label class="form-label">Account type</label>
								<select class="form-select" name="accountType">
									<option value="">Select...</option>
									<option <?= (isset($profile['accountType']) && $profile['accountType'] == 'Checking') ? 'selected' : '' ?>>Checking</option>
									<option <?= (isset($profile['accountType']) && $profile['accountType'] == 'Savings') ? 'selected' : '' ?>>Savings</option>
									<option <?= (isset($profile['accountType']) && $profile['accountType'] == 'Business') ? 'selected' : '' ?>>Business</option>
								</select>
							</div>

							<div class="col-md-6">
								<label class="form-label">Routing / Sort code <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="routing" value="<?= htmlspecialchars($profile['routing'] ?? '') ?>" required>
							</div>

							<div class="col-md-6">
								<label class="form-label">IBAN (if applicable)</label>
								<input type="text" class="form-control" name="iban" value="<?= htmlspecialchars($profile['iban'] ?? '') ?>">
							</div>

							<div class="col-12 mt-3"><hr></div>

							<h5 class="col-12">Address</h5>

							<div class="col-12">
								<label class="form-label">Street Address <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="street" value="<?= htmlspecialchars($profile['street'] ?? '') ?>" placeholder="123 Main St, Apt 4B" required>
							</div>

							<div class="col-md-6">
								<label class="form-label">City <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="city" value="<?= htmlspecialchars($profile['city'] ?? '') ?>" required>
							</div>

							<div class="col-md-6">
								<label class="form-label">State / Province <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="state" value="<?= htmlspecialchars($profile['state'] ?? '') ?>" required>
							</div>

							<div class="col-md-6">
								<label class="form-label">Postal Code <span class="text-danger">*</span></label>
								<input type="text" class="form-control" name="postalCode" value="<?= htmlspecialchars($profile['postalCode'] ?? '') ?>" required>
							</div>

							<div class="col-md-6">
								<label class="form-label">Country</label>
								<input type="text" class="form-control" name="country" value="<?= htmlspecialchars($profile['country'] ?? '') ?>">
							</div>

							<div class="col-12 text-end mt-3">
								<button type="button" id="saveBtn" class="btn btn-outline-secondary me-2"><i class="uil uil-save"></i> Save draft</button>
								<button type="submit" class="btn btn-primary"><i class="uil uil-check-circle"></i> Save & update</button>
							</div>
						</form>

						<div id="formMessage" class="alert d-none mt-3"></div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script>
		const moduleId = '<?= $module ?>';
		const form = document.getElementById('loanProfileForm');
		const msg = document.getElementById('formMessage');

		function showOverlay() {
			$('body').append(`
				<div id="block-overlay" 
				     style="position:fixed; top:0; left:0; width:100%; height:100%;
				            background:rgba(0,0,0,0.5); z-index:9999; display:flex;
				            align-items:center; justify-content:center; color:#fff;
				            font-size:20px; font-weight:bold;">
				    Processing...
				</div>
			`);
		}

		function hideOverlay() {
			$('#block-overlay').remove();
		}

		form.addEventListener('submit', function(e) {
			e.preventDefault();
			if (!form.checkValidity()) {
				form.classList.add('was-validated');
				return;
			}

			const formData = new FormData(form);
			const payload = {};
			formData.forEach((v, k) => payload[k] = v);
			// Add required action/module/user identifiers
			payload.action = 'updateLoanProfile';
			payload.moduleId = moduleId;
			payload.userid = form.elements['userid'].value;

			showOverlay();
			$.ajax({
				type: 'POST',
				url: 'actions',
				data: payload,
				dataType: 'json',
				success: function(res) {
					hideOverlay();
					if (res.status === 'success') {
						throwSuccess(res.message || 'Profile updated successfully', 'toast-top-right');
						// If backend returns updated profile, refresh form values
						if (res.data) {
							Object.keys(res.data).forEach(k => {
								if (form.elements[k]) form.elements[k].value = res.data[k];
							});
						}
					} else {
						throwWarning(res.message || 'Update failed', 'toast-top-right');
					}
				},
				error: function() {
					hideOverlay();
					throwWarning('Request failed — please try again', 'toast-top-right');
				}
			});
		});

		document.getElementById('saveBtn').addEventListener('click', function() {
			const data = Object.fromEntries(new FormData(form).entries());
			localStorage.setItem('loanProfileDraft', JSON.stringify(data));
			throwSuccess('Draft saved locally', 'toast-top-right');
		});

		document.getElementById('previewBtn').addEventListener('click', function() {
			const data = Object.fromEntries(new FormData(form).entries());
			let preview = Object.entries(data).map(([k, v]) => `${k}: ${v || '-'} `).join('\n');
			Swal.fire({
				title: 'Preview',
				html: `<pre style="text-align:left">${preview}</pre>`,
				width: 600
			});
		});

		// try to restore draft
		window.addEventListener('load', function() {
			try {
				const draft = JSON.parse(localStorage.getItem('loanProfileDraft') || 'null');
				if (draft) {
					Object.entries(draft).forEach(([k, v]) => {
						if (form.elements[k]) form.elements[k].value = v;
					});
				}
			} catch (e) { }
		});
	</script>

	<!-- inject:js-->
	<?php require_once 'common/footer.php'; ?>
</body>

</html>