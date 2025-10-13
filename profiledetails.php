<?php
$pageTitle = 'Profile Details';
require_once 'common/header.php'; 

use Src\Module\User\UserFunctions;

$moduleId = DEF_MODULE_ID_USER;
$userId = $_REQUEST['id'] ?? '';
if (strlen($userId) != 36)
{
	$userId = getLoggedInUserDetailsByKey();
}

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
	$userIsAdmin = doTypeCastInt($rs['isadmin']);

	$address = $address .' ,'. $city . ' ,'. $state . ' ,'. $postal . ' ,'. $country;
}
?>

<body class="geex-dashboard">
<main class="geex-main-content">
    <?php require_once 'common/menu.php'; ?>
    <div class="geex-content">
        <div class="geex-content__header">
            <div class="geex-content__header__content">
                <h2 class="geex-content__header__title"> User Profile</h2>
                <p class="geex-content__header__subtitle"><?= $firstname .' '. $lastname ?>'s personal information summary</p>
            </div>
            <div class="geex-content__header__action">
                <?php require_once 'common/userProfileSection.php'; ?>
            </div>
        </div>

        <div class="geex-content__section geex-content__form">
            <div class="geex-content__form__wrapper">

                <!-- Left Column -->
                <div class="geex-content__form__wrapper__item geex-content__form__left">
  <div class="geex-content__form__single">
    <h4 class="geex-content__form__single__label">Personal Information</h4>

				<div class="geex-content__form__single__box" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">

				<!-- First Name -->
				<div class="input-wrapper">
					<label class="input-label">First Name</label>
					<p class="form-control-plaintext"><?= htmlspecialchars($firstname) ?></p>
				</div>

				<!-- Last Name -->
				<div class="input-wrapper">
					<label class="input-label">Last Name</label>
					<p class="form-control-plaintext"><?= htmlspecialchars($lastname) ?></p>
				</div>

				<!-- Email -->
				<div class="input-wrapper">
					<label class="input-label">Email</label>
					<p class="form-control-plaintext"><?= htmlspecialchars($email) ?></p>
				</div>	
				<!-- Email -->
				<div class="input-wrapper">
					<label class="input-label">Date of Birth</label>
					<p class="form-control-plaintext"><?= htmlspecialchars($dob) ?></p>
				</div>

				<!-- Phone Number -->
				<div class="input-wrapper">
					<label class="input-label">Phone Number</label>
					<p class="form-control-plaintext"><?= htmlspecialchars($phoneNumber) ?></p>
				</div>

				<!-- Employment Status -->
				<div class="input-wrapper">
					<label class="input-label">Employment Status</label>
					<p class="form-control-plaintext">
					<?= ucfirst(str_replace('_',' ', htmlspecialchars($occupation))) ?>
					</p>
				</div>

				<!-- Monthly Income -->
				<div class="input-wrapper">
					<label class="input-label">Monthly Income (₦)</label>
					<p class="form-control-plaintext">
					<?php
						$ranges = [
						1 => 'Below ₦20,000',
						2 => '₦20,000 - ₦50,000',
						3 => '₦50,000 - ₦100,000',
						4 => '₦100,000 - ₦200,000',
						5 => 'Above ₦200,000'
						];
						echo $ranges[$montlyIncome] ?? 'Not specified';
					?>
					</p>
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
                                <label class="input-label">Bank Name</label>
                                <p class="form-control-plaintext"><?= htmlspecialchars($bankName) ?></p>
                            </div>
                            <div class="input-wrapper">
                                <label class="input-label">Account Holder Name</label>
                                <p class="form-control-plaintext"><?= htmlspecialchars($bankAccounHolderName) ?></p>
                            </div>
                            <div class="input-wrapper">
                                <label class="input-label">Account Number</label>
                                <p class="form-control-plaintext"><?= htmlspecialchars($accountNumber) ?></p>
                            </div>
                            <div class="input-wrapper">
                                <label class="input-label">ID Number</label>
                                <p class="form-control-plaintext"><?= htmlspecialchars($nationalId) ?></p>
                            </div>
                            <div class="input-wrapper">
                                <label class="input-label">Identification Type</label>
                                <p class="form-control-plaintext">
                                    <?= ucfirst(str_replace('_',' ', htmlspecialchars($identification))) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="geex-content__form__single">
                        <h4 class="geex-content__form__single__label">Address</h4>
                        <div class="geex-content__form__single__box">
                            <div class="input-wrapper">
                                <p class="form-control-plaintext"><?= htmlspecialchars($address) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
						
            <?php if (!$userIsAdmin) 
			{
				if ($isEligible)
				{ 
			?>
					<div class="text-end mt-4">
						<button id="disableInfoBtn" class="geex-btn geex-btn--danger">
							<i class="bi bi-check"></i> Disable Profile
						</button>
					</div>
			<?php
				}
				else
				{
				?>		
					<div class="text-end mt-4">
						<button id="approveInfoBtn" class="geex-btn geex-btn--success">
							<i class="bi bi-check"></i> Approve Information
						</button>
					</div>
			<?php } 	
				} 
			?>
        </div>
    </div>
<script>
$(document).ready(function() {
    $('#approveInfoBtn').click(function(e) {
        e.preventDefault(); // prevent default button action

        // Optionally, show a loading overlay
        $('body').append('<div id="block-overlay" class="geex-overlay">Processing...</div>');

        $.ajax({
            url: 'actions', // your backend endpoint
            type: 'POST',
            data: {
                action: 'activate', // action identifier for PHP
                id: '<?= $userId ?>', // send the user ID
                moduleId: '<?= $moduleId ?>' // send the user ID
            },
            dataType: 'json',
            success: function(res) {
                $('#block-overlay').remove();
                if(res.status === 'success') {
					 setTimeout(() => location.reload(), 1000);
                    throwSuccess(res.message || 'Profile approved!', 'toast-top-right');
                } else {
                    throwWarning(res.message || 'Approval failed', 'toast-top-right');
                }
            },
            error: function() {
                $('#block-overlay').remove();
                throwWarning('Request failed', 'toast-top-right');
            }
        });
    }); 
	
	$('#disableInfoBtn').click(function(e) {
        e.preventDefault(); // prevent default button action

        // Optionally, show a loading overlay
        $('body').append('<div id="block-overlay" class="geex-overlay">Processing...</div>');

        $.ajax({
            url: 'actions', // your backend endpoint
            type: 'POST',
            data: {
                action: 'deactivate', // action identifier for PHP
                id: '<?= $userId ?>', // send the user ID
                moduleId: '<?= $moduleId ?>' // send the user ID
            },
            dataType: 'json',
            success: function(res) {
                $('#block-overlay').remove();
                if(res.status === 'success') {
					setTimeout(() => location.reload(), 1000);
                    throwSuccess(res.message || 'Profile Deativated!', 'toast-top-right');
                } else {
                    throwWarning(res.message || 'Approval failed', 'toast-top-right');
                }
            },
            error: function() {
                $('#block-overlay').remove();
                throwWarning('Request failed', 'toast-top-right');
            }
        });
    });
});
</script>
</main>
<?php require_once 'common/footer.php'; ?>
</body>
</html>
