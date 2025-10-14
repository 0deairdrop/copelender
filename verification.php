<!doctype html>
<html lang="en" dir="ltr">

<?php 
$pageTitle = 'Verification';
$redirect = 'dashboard';
require_once 'common/header.php'; 

$arUser = $_SESSION['user'];
$email = $arUser['email'];
$module = DEF_MODULE_ID_AUTH;
?>

<body class="geex-dashboard authentication-page">

	<main class="geex-content">
		<div class="geex-content__authentication geex-content__authentication--forgot-password">
			<div class="geex-content__authentication__content">
				<div class="geex-content__authentication__content__wrapper">
					<div class="geex-content__authentication__content__logo">
						<a href="index.html">
							<img src="assets/img/cope2.png" alt="copelender" alt="">
						</a>
					</div>
					<form id="verification" class="geex-content__authentication__form" method="post">
						<input type="hidden" name="action" value="verify" >
						<input type="hidden" name="email" value="<?php echo $email;?>" >
						<input type="hidden" name="id" value="<?php echo $arUser['id'];?>" >
						<input type="hidden" name="verificationCode" value="">
						<h2 class="geex-content__authentication__title">Two Step Verification 👋</h2>
						<p class="geex-content__authentication__desc">We sent a verification code to your Email. Enter the code from the mobile in the field below. <span class="verification-number"><?= $email ?></span></p>
						<div class="geex-content__authentication__form-group">
							<label for="emailSignIn">Type your 6 digits security code</label>
							<div class="geex-content__authentication__form-group__code">
								<input type="text" id="verificationCode1" name="verificationCode1" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
								<input type="text" id="verificationCode2" name="verificationCode2"maxlength="1" pattern="[0-9]" inputmode="numeric" required>
								<input type="text" id="verificationCode3" name="verificationCode3"maxlength="1" pattern="[0-9]" inputmode="numeric" required>
								<input type="text" id="verificationCode4" name="verificationCode4"maxlength="1" pattern="[0-9]" inputmode="numeric" required>
								<input type="text" id="verificationCode5" name="verificationCode5"maxlength="1" pattern="[0-9]" inputmode="numeric" required>
								<input type="text" id="verificationCode6" name="verificationCode6"maxlength="1" pattern="[0-9]" inputmode="numeric" required>
							</div>
						</div>
						<button type="submit" class="geex-content__authentication__form-submit">Verify My Account</button>
						<div class="geex-content__authentication__form-footer">
							Didn’t get the code?<a href="#" id="resendCode">Resend</a>
						</div>
					</form>
				</div>
			</div>	
			<div class="geex-content__authentication__img">
				<img src="./assets/img/authentication.svg" alt="">
			</div>
		</div>
	</main>

	
<script>
var module = '<?= $module ?>';
$(document).ready(function () {
    // Allow only numbers and auto-focus next input
    $(".geex-content__authentication__form-group__code input").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, ''); // digits only
        if (this.value.length === 1) {
            $(this).next("input").focus(); // go to next
        }
    });

    // Backspace goes to previous
    $(".geex-content__authentication__form-group__code input").on("keydown", function (e) {
        if (e.key === "Backspace" && this.value === "") {
            $(this).prev("input").focus();
        }
    });

    // Resend link AJAX
    $("#resendCode").on("click", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "actions.php",
            data: { action: "regenerateOtp", email: $("input[name=email]").val(), moduleId: module },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    throwSuccess(response.message, "toast-top-right");
                } else {
                    throwWarning(response.message, "toast-top-right");
                }
            },
            error: function () {
                throwWarning("Failed to resend code. Try again later.", "toast-top-right");
            }
        });
    });
});
</script>

<?php require_once 'common/footer.php'; ?>
	<!-- endinject-->
</body>

</html>