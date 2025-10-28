<!doctype html>
<html lang="en" dir="ltr">

<?php
$pageTitle = 'Dashboard';
$redirect = '';
require_once 'common/header.php'; 

doCheckUserIsLoggedInAndRedirect('user', 'login');
/**
 * redirect user to verification page if user has not verified account upon login
 */
if (doTypeCastInt(getLoggedInUserDetailsByKey('active') == 0))
{
	header("Location: verification");
    exit;
}
$module = DEF_MODULE_ID_DASHBOARD;
$isAdmin = doTypeCastInt(getLoggedInUserDetailsByKey('isadmin'));
if ($isAdmin)
{
	header("Location: admindashboard");
    exit;
}
use Src\Module\Dashboard\DashboardFunctions;
$rs = DashboardFunctions::getUserDashboardData();
?>

<body class="geex-dashboard demo-banking">

<main class="geex-main-content">
 <!-- menu  -->	
<?php require_once 'common/menu.php'; ?>

		<div class="geex-content">
			<div class="geex-content__header">
				<div class="geex-content__header__content">
					<h2 class="geex-content__header__title"><?= APP_NAME ?></h2>
					<p class="geex-content__header__subtitle">Welcome to <?= APP_NAME ?> Dashboard</p>
				</div> 
				
			<?php require_once 'common/userProfileSection.php'; ?>
			</div> 

			<div class="geex-content__wrapper">
				<div class="geex-content__section-wrapper">
					<div class="geex-content__feature mb-40">
						<div class="geex-content__feature__card">
							<div class="geex-content__feature__card__text">
								<p class="geex-content__feature__card__subtitle">Total Loan Amount</p>
								<h4 class="geex-content__feature__card__title">NGN <?= $rs['arDashboardCount']['totalLoanAmount'] ?></h4>
							</div>
							<div class="geex-content__feature__card__img" 
								style="text-align: center; font-size: 48px; color: #ab54db;">
							<i class="bi bi-cash-stack"></i>
							</div>
						</div>
						<div class="geex-content__feature__card">
							<div class="geex-content__feature__card__text">
								<p class="geex-content__feature__card__subtitle">Total Amount Paid</p>
								<h4 class="geex-content__feature__card__title">NGN <?= $rs['arDashboardCount']['totalAmountPaid'] ?></h4>
							</div>
							<div class="geex-content__feature__card__img" 
								style="text-align: center; font-size: 48px; color: #ab54db;">
							<i class="bi bi-bank"></i>
							</div>
						</div>	
						<div class="geex-content__feature__card">
							<div class="geex-content__feature__card__text">
								<p class="geex-content__feature__card__subtitle">Total Amount Left</p>
								<h4 class="geex-content__feature__card__title">NGN <?= $rs['arDashboardCount']['totalAmountLeft'] ?></h4>
							</div>
							<div class="geex-content__feature__card__img" 
								style="text-align: center; font-size: 48px; color: #ab54db;">
							<i class="bi bi-credit-card"></i>
							</div>
						</div>
					</div>

					<div class="geex-content__section geex-content__transaction">
						<div class="geex-content__section__header">
							<div class="geex-content__section__header__title-part">
								<h4 class="geex-content__section__header__title">Recent Transactions</h4>
							</div>
							<div class="geex-content__section__header__content-part">
								<ul class="nav nav-tabs geex-transaction-tab" id="geex-transaction-tab" role="tablist">
									<li class="nav-item" role="presentation">
										<button class="nav-link active" id="transaction-history-tab" data-bs-toggle="tab" data-bs-target="#transaction-history-content" type="button" role="tab" aria-controls="transaction-history-content" aria-selected="true">Transaction History</button>
									</li>
									<li class="nav-item" role="presentation">
										<button class="nav-link" id="transaction-upcoming-tab" data-bs-toggle="tab" data-bs-target="#transaction-upcoming-content" type="button" role="tab" aria-controls="transaction-upcoming-content" aria-selected="false">Upcoming Debits</button>
									</li>
									<li class="nav-item" role="presentation">
										<button class="nav-link" id="transaction-request-tab" data-bs-toggle="tab" data-bs-target="#transaction-credits-content" type="button" role="tab" aria-controls="transaction-credits-content" aria-selected="false">All Credits</button>
									</li>
									<li class="nav-item" role="presentation">
										<button class="nav-link" id="transaction-request-tab" data-bs-toggle="tab" data-bs-target="#transaction-debits-content" type="button" role="tab" aria-controls="transaction-debits-content" aria-selected="false">All Debits</button>
									</li>
								</ul>
							</div>
						</div>
						<div class="geex-content__section__content">
							<div class="tab-content geex-transaction-content" id="geex-transaction-content">
								<?php 
									require_once 'common/transactions/alltransactions.php';
									require_once 'common/transactions/upcomingtransactions.php';
									require_once 'common/transactions/credits.php';
									require_once 'common/transactions/debits.php';
								?>
							</div>
						</div>
					</div>
				</div>

				<?php require_once 'common/transactions/ongoingloans.php'; ?>
			</div>
		</div>
  	</main>
	
	<!-- inject:js-->
	<?php require_once 'common/footer.php'; ?>
  	<!-- endinject-->
</body>
</html>