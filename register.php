<!doctype html>
<html lang="en" dir="ltr">

<?php 
$pageTitle = 'Register';
$redirect = 'verification';
require_once 'common/header.php';

$module = DEF_MODULE_ID_AUTH;
?>

<body class="geex-dashboard authentication-page">
	<main class="geex-content">
		<div class="geex-content__authentication">
			<div class="geex-content__authentication__content">
				<div class="geex-content__authentication__content__wrapper">
					<div class="geex-content__authentication__content__logo">
						<a href="index">
							<img class="logo-lite" src="assets/img/cope2.png" alt="copelender"
				     style="display: block; margin: 0 auto; max-height: 100px; width: auto; max-width: 100%;" />
				   </a>
					</div>
					<form id="signInForm" class="geex-content__authentication__form" method="post">
						<input type="hidden" name="action" value="register" >
						<h2 class="geex-content__authentication__title">Sign Up Your Account 👋</h2>
						<div class="geex-content__authentication__form-group">
							<label for="username">First Name</label>
							<input type="firstname" id="firstname" name="firstname" placeholder="Enter Your First Name" required>
						</div>	<div class="geex-content__authentication__form-group">
							<label for="username">Last Name</label>
							<input type="username" id="lastname" name="lastname" placeholder="Enter Your Last Name" required>
						</div>
						<div class="geex-content__authentication__form-group">
							<label for="email">Your Email</label>
							<input type="email" id="email" name="email" placeholder="Enter Your Email" required>
							<i class="uil-envelope"></i>
						</div>	
						<div class="geex-content__authentication__form-group">
							<label for="username">Username</label>
							<input type="username" id="username" name="username" placeholder="Enter Your Username" required>
						</div>	
						<div class="geex-content__authentication__form-group">
							<div class="geex-content__authentication__label-wrapper">
								<label for="password">Password</label>
							</div>
							<input type="password" id="password" name="password" placeholder="Password" required>
							<i class="uil-eye toggle-password-type"></i>
						</div>
						<div class="geex-content__authentication__form-group">
							<div class="geex-content__authentication__label-wrapper">
								<label for="confirm_password">Confirm Password</label>
							</div>
							<input type="confirm_password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
							<i class="uil-eye toggle-password-type"></i>
						</div>
						<div class="geex-content__authentication__form-group custom-checkbox">
							<input type="checkbox" class="geex-content__authentication__checkbox-input" id="accept_terms "name="accept_terms">
							<label class="geex-content__authentication__checkbox-label" for="accept_terms">By creating a account you agree to Our <a href="#">terms & conditions Privacy Policy</a></label>
						</div>
						<button type="submit" class="geex-content__authentication__form-submit">Sign Up</button>				
						<div class="geex-content__authentication__form-footer">
							already have an account? <a href="login">Sign In</a>
						</div>
					</form>
				</div>
			</div>	
			<div class="geex-content__authentication__img">
				<img src="./assets/img/authentication.svg" alt="">
			</div>
		</div>
	</main>

	<?php require_once 'common/footer.php'; ?>

</body>

</html>