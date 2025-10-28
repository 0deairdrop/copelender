<!doctype html>
<html lang="en" dir="ltr">

<?php 
$pageTitle = 'Eror 404';
require_once 'common/header.php'; 
?>

<body class="geex-dashboard">

<?php require_once 'common/menu.php'; ?>

<main class="geex-main-content">


<div class="geex-customizer">
</div>

		<div class="geex-content">
			<div class="geex-content__section geex-content__error">
				<div class="geex-content__error__wrapper">
					<div class="geex-content__error__content">
						<h2 class="geex-content__error__title">404</h2>
						<h3 class="geex-content__error__subtitle">Page Not Found</h3>     
						<p class="geex-content__error__desc">Sorry, the page you seems looking for, has been moved, redirected or removed permanently.</p>
						<a class="geex-btn" href="dashboard"> Back to Homepage</a>
					</div><!-- .page-content -->
				</div>
			</div>
		</div>
	</main>

	<!-- inject:js-->
	<script src="./assets/vendor/js/jquery/jquery-3.5.1.min.js"></script>
	<script src="./assets/vendor/js/jquery/jquery-ui.js"></script>
	<script src="./assets/vendor/js/bootstrap/bootstrap.min.js"></script>
	<script src="./assets/js/main.js"></script>
	<!-- endinject-->
</body>

</html>