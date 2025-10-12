<!doctype html>
<html lang="en" dir="ltr">

<?php 
$pageTitle = 'Transactions';
require_once 'common/header.php'; 
?>
<body class="geex-dashboard">
<main class="geex-main-content">
<?php 
require_once 'common/menu.php';
$isAdmin = doTypeCastInt(getLoggedInUserDetailsByKey('isadmin'));
use Src\Module\Dashboard\DashboardFunctions;
DashboardFunctions::getQueryCondition();
DashboardFunctions::$limit = 0;
if (!$isAdmin)
{
	DashboardFunctions::$userId = getLoggedInUserDetailsByKey();
}
$rs['arTransactions'] = DashboardFunctions::getAllUserTransactions();
?>
<div class="geex-customizer">	
</div>

		<div class="geex-content">
			<div class="geex-content__header">
				<div class="geex-content__header__content">
					<h2 class="geex-content__header__title">My Transactions</h2>
					<p class="geex-content__header__subtitle">All Transactions</p>
				</div>

				<?php require_once 'common/userProfileSection.php'; ?>
			</div>

			<div class="geex-content__section geex-content__transaction">
						<div class="geex-content__section__header">
							<div class="geex-content__section__header__title-part">
								<h4 class="geex-content__section__header__title">All Transactions</h4>
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
								<ul class="geex-transaction-filter filter-part">
									<li>
										<label for="filterDate" id="geex-content__filter__label">
											<i class="uil-calendar-alt"></i>
										</label>
										<input type="date" id="geex-content__filter__date" name="filterDate">
									</li>
									<li>
										<a href="#" class="geex-content__toggle__btn">
											<i class="uil-search"></i>
										</a>
										<div class="geex-content__toggle__content geex-content__header__searchform">
											<input type="text" placeholder="Search" class="geex-content__header__btn">
											<i class="uil uil-search"></i>
										</div>
									</li>
									<li>
										<a href="#" class="geex-content__toggle__btn">
											<i class="uil-filter"></i>
										</a>
										<div class="geex-content__toggle__content filter-popup">
											<a href="#">Name</a>
											<a href="#">Date</a>
											<a href="#">Amount</a>
											<button class="geex-btn geex-btn--sm">Apply Filters</button>
										</div>
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
						<div class="geex-content__section__header__btn">
							<a href="#" class="geex-btn load-more-btn">
								Load More <i class="uil uil-angle-down"></i>
							</a>
						</div>
						</div>
					</div>
		</div>
	</main>
		
	<!-- inject:js-->
	<?php require_once 'common/footer.php'; ?>
	<!-- endinject-->
</body>

</html>





















