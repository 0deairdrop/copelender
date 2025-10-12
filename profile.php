<?php

$pageTitle = 'Profile';
require_once 'common/header.php'; 

use Src\Module\User\UserFunctions;

$module = DEF_MODULE_ID_USER;

$userId = getLoggedInUserDetailsByKey();
$isAdmin = doTypeCastInt(getLoggedInUserDetailsByKey('isadmin'));

$id = $username = $firstname = $lastname = $phoneNumber = $email = $active = '';
$nationalId = $address = $montlyIncome = $occupation = $bankName = $bankAccounHolderName = '';
$accountNumber = $identification = $isEligible = $city = $state = $postal = $country = $dob = '';
$rs = UserFunctions::getUserInfo($userId, [
	  'id'
	, 'username'
	, 'firstname'
	, 'lastname'
	, 'phone_number'
	, 'email'
	, 'active'
	, 'isadmin'
	, 'national_id'
	, 'address'
	, 'montly_income'
	, 'occupation'
	, 'bank_name'
	, 'bank_account_holder_name'
	, 'account_number'
	, 'identification'
	, 'is_eligible'
	, 'city'
	, 'state'
	, 'postal'
	, 'country'
	, 'dob'
]);
$readOnly = '';
if (count($rs) > 0)
{
	$id = $rs['id'];
	$username = $rs['username'];
	$firstname = $rs['firstname'];
	$lastname = $rs['lastname'];
	$phoneNumber = $rs['phone_number'];
	$email = $rs['email'];
	$active = $rs['active'];
	$nationalId = $rs['national_id'];
	$address = $rs['address'];
	$montlyIncome = $rs['montly_income'];
	$occupation = $rs['occupation'];
	$bankName = $rs['bank_name'];
	$bankAccounHolderName = $rs['bank_account_holder_name'];
	$accountNumber = $rs['account_number'];
	$identification = $rs['identification'];
	$isEligible = doTypeCastInt($rs['is_eligible']);
	$country = $rs['country'];
	$city = $rs['city'];
	$state = $rs['state'];
	$postal = $rs['postal'];
	$dob = $rs['dob'];
	$isEligible = doTypeCastInt($rs['is_eligible']);

	if ($isEligible > 0)
	{
		$readOnly = 'readonly';
	}
}
//echo('<pre>');print_R($rs); exit;
?>

<body class="geex-dashboard">
	<main class="geex-main-content">
		<?php require_once 'common/menu.php'; ?>
		<div class="geex-content">
			<div class="geex-content__header">
				<div class="geex-content__header__content">
					<h2 class="geex-content__header__title">Update Profile</h2>
					<p class="geex-content__header__subtitle"><?= $firstname .' '. $lastname ?></p>
				</div>
				<div class="geex-content__header__action">
					<?php require_once 'common/userProfileSection.php'; ?>
				</div>
			</div>

			<div class="geex-content__section geex-content__form">
				<div class="geex-content__form__wrapper">
					<form id="loanProfileForm" class="needs-validation" novalidate enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

						<!-- Left Column -->
						<div class="geex-content__form__wrapper__item geex-content__form__left">
							<div class="geex-content__form__single">
								<h4 class="geex-content__form__single__label">Personal Information</h4>
								<div class="geex-content__form__single__box">
									<div class="input-wrapper">
										<label class="input-label">Full Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="firstname" placeholder="First Name" value="<?= htmlspecialchars($firstname) ?>" required>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Full Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="lastname" placeholder="Last Name" value="<?= htmlspecialchars($lastname) ?>" required>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Email <span class="text-danger">*</span></label>
										<input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="<?= htmlspecialchars($email) ?>" required readonly>
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
											<input type="tel" class="form-control" name="phone_number" placeholder="phone number" value="<?= htmlspecialchars($phoneNumber) ?>" required>
										</div>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Date of Birth<span class="text-danger">*</span></label>
										<input type="date" class="form-control" name="dob" value="<?= htmlspecialchars($dob) ?>" required>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Employment Status <span class="text-danger">*</span></label>
										<select class="form-control" name="occupation" required>
											<option value="">Select...</option>
											<option value="employed"<?= ($occupation) == 'employed' ? 'selected' : '' ?>>Employed</option>
											<option value="self_employed"<?= ($occupation) == 'self_employed' ? 'selected' : '' ?>>Self-employed</option>
											<option value="unemployed"<?= ($occupation) == 'unemployed' ? 'selected' : '' ?>>Unemployed</option>
											<option value="student"<?= ($occupation) == 'student' ? 'selected' : '' ?>>Student</option>
											<option value="retired"<?= ($occupation) == 'retired' ? 'selected' : '' ?>>Retired</option>
										</select>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Montly Income (₦)<span class="text-danger">*</span></label>
										<select class="form-control" name="montly_income" required>
											<option value="">Select income range</option>
											<option value="1" <?= ($montlyIncome) == 1 ? 'selected' : '' ?>>Below ₦20,000</option>
											<option value="2" <?= ($montlyIncome) == 2 ? 'selected' : '' ?>>₦20,000 - ₦50,000</option>
											<option value="3" <?= ($montlyIncome) == 3 ? 'selected' : '' ?>>₦50,000 - ₦100,000</option>
											<option value="4" <?= ($montlyIncome) == 4 ? 'selected' : '' ?>>₦100,000 - ₦200,000</option>
											<option value="5" <?= ($montlyIncome) == 5 ? 'selected' : '' ?>>Above ₦200,000</option>
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
										<input type="text" class="form-control" name="bank_name" value="<?= htmlspecialchars($bankName) ?>" required <?= $readOnly ?>>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Account Holder Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="bank_account_holder_name" value="<?= htmlspecialchars($bankAccounHolderName) ?>" required <?= $readOnly ?>>
									</div>

									<div class="input-wrapper">
										<label class="input-label">Account Number <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="account_number" placeholder="Account Number" value="<?= htmlspecialchars($accountNumber) ?>" pattern="\d+" required <?= $readOnly ?>>
									</div>
									<div class="input-wrapper">
										<label class="input-label">ID Number <span class="text-danger">*</span></label>
										<input type="text" class="form-control"  placeholder="National Id" name="national_id" value="<?= htmlspecialchars($nationalId ?? '') ?>" required <?= $readOnly ?>>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Identification<span class="text-danger">*</span></label>
										<select class="form-control mb-2" name="identification" required <?= $readOnly ?>>
											<option value="">Select ID Type</option>
											<option value="passport" <?= ($identification) == 'passport' ? 'selected' : '' ?>>Passport</option>
											<option value="national_id" <?= ($identification) == 'national_id' ? 'selected' : '' ?>>National Identity</option>
											<option value="drivers_license" <?= ($identification) == 'drivers_license' ? 'selected' : '' ?>>Driver’s License</option>
										</select>
									</div>

									
								</div>
							</div>

							<div class="geex-content__form__single">
								<h4 class="geex-content__form__single__label">Address</h4>
								<div class="geex-content__form__single__box">
									<div class="input-wrapper">
										<label class="input-label">Street Address <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="street" placeholder="123 Main St" value="<?= htmlspecialchars($address) ?>" required>
									</div>
									<div class="input-wrapper">
										<label class="input-label">City <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="city" value="<?= htmlspecialchars($city) ?>" required>
									</div>
									<div class="input-wrapper">
										<label class="input-label">State / Province <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="state" value="<?= htmlspecialchars(($state)) ?>" required>
									</div>
									<div class="input-wrapper">
										<label class="input-label">Postal Code</span></label>
										<input type="text" class="form-control" name="postal" value="<?= htmlspecialchars($postal) ?>">
									</div>
									<div class="input-wrapper">
										<label class="input-label">Country</label>
										<input type="text" class="form-control" name="country" value="<?= htmlspecialchars($country) ?>">
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
		formData.append('action', 'save');
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
				if (res.status === 'success') 
				{
					setTimeout(() => location.reload(), 1000);
					throwSuccess(res.message || 'Profile saved', 'toast-top-right');
				}
				else 
				{
					throwWarning(res.message || 'Save failed', 'toast-top-right');
				}
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
            Object.entries(JSON.parse(draft)).forEach(([k, v]) => {
                if (form.elements[k] && !form.elements[k].value) { // Only fill empty fields
                    if (typeof v === 'object' && v !== null) {
                        form.elements[k].value = v.id || v.value || '';
                    } else {
                        form.elements[k].value = v;
                    }
                }
            });
        } catch(e) {
            console.error('Draft load error:', e);
        }
    }
});


	</script>

	<?php require_once 'common/footer.php'; ?>
</body>
</html>