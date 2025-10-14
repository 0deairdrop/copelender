<!doctype html>
<html lang="en" dir="ltr">

<?php 
$pageTitle = 'Login';
$redirect = 'dashboard';
require_once 'common/header.php';
$module = DEF_MODULE_ID_AUTH;
?>

<body class="geex-dashboard authentication-page">
	<main class="geex-content">
		<div class="geex-content__authentication">
			<div class="geex-content__authentication__content">
				<div class="geex-content__authentication__content__wrapper">
					<div class="geex-content__authentication__content__logo">
						<a href="index.html">
							<img class="logo-lite" src="assets/img/cope2.png" alt="copelender"
				     style="display: block; margin: 0 auto; max-height: 100px; width: auto; max-width: 100%;" />
						</a>
					</div>
					<form id="signInForm" class="geex-content__authentication__form" method="post">
						<input type="hidden" name="action" value="login">
						<h2 class="geex-content__authentication__title">Sing In to Your Account 👋</h2>
						<div class="geex-content__authentication__form-group">
							<label for="usernameOrEmail">Email or Username</label>
							<input type="text" id="usernameOrEmail" name="usernameOrEmail" placeholder="Enter Your Email or Username" required>
							<i class="uil-envelope"></i>
						</div>
						<div class="geex-content__authentication__form-group">
							<div class="geex-content__authentication__label-wrapper">
								<label for="loginPassword">Your Password</label>
								<a href="forgotpassword">Forgot Password?</a>
							</div>
							<input type="password" id="password" name="password" placeholder="Password" required>
							<i class="uil-eye toggle-password-type"></i>
						</div>
						<div class="geex-content__authentication__form-group custom-checkbox">
							<input type="checkbox" class="geex-content__authentication__checkbox-input" id="rememberMe">
							<label class="geex-content__authentication__checkbox-label" for="rememberMe">Remember Me</label>
						</div>
						<button type="submit" class="geex-content__authentication__form-submit">Sign In</button>
						<div class="geex-content__authentication__form-footer">
							Doesn't have any account? <a href="register">Sign Up</a>
						</div>
					</form>
				</div>
			</div>	
			<div class="geex-content__authentication__img">
				<img src="./assets/img/authentication.svg" alt="">
			</div>
		</div>
	</main>

	<!-- inject:js-->
	<?php require_once 'common/footer.php'; ?>

</body>

</html>