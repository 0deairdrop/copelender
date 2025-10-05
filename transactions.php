<!doctype html>
<html lang="en" dir="ltr">

<?php 
$pageTitle = 'Transactions';
require_once 'common/header.php'; 
?>

<body class="geex-dashboard">

<main class="geex-main-content">
		

<?php require_once 'common/menu.php'; ?>
 
		

<div class="geex-customizer">
	
</div>

		<div class="geex-content">
			<div class="geex-content__header">
				<div class="geex-content__header__content">
					<h2 class="geex-content__header__title">Table</h2>
					<p class="geex-content__header__subtitle">Table Elements is used to style and format the input field</p>
				</div>

				<?php require_once 'common/userProfileSection.php'; ?>
			</div>

			<div class="geex-content__section geex-content__transaction">
						<div class="geex-content__section__header">
							<div class="geex-content__section__header__title-part">
								<h4 class="geex-content__section__header__title">All Transaction</h4>
							</div>
							<div class="geex-content__section__header__content-part">
								<ul class="nav nav-tabs geex-transaction-tab" id="geex-transaction-tab" role="tablist">
									<li class="nav-item" role="presentation">
										<button class="nav-link active" id="transaction-history-tab" data-bs-toggle="tab" data-bs-target="#transaction-history-content" type="button" role="tab" aria-controls="transaction-history-content" aria-selected="true">History</button>
									</li>
									<li class="nav-item" role="presentation">
										<button class="nav-link" id="transaction-upcoming-tab" data-bs-toggle="tab" data-bs-target="#transaction-upcoming-content" type="button" role="tab" aria-controls="transaction-upcoming-content" aria-selected="false">Upcoming</button>
									</li>
									<li class="nav-item" role="presentation">
										<button class="nav-link" id="transaction-request-tab" data-bs-toggle="tab" data-bs-target="#transaction-request-content" type="button" role="tab" aria-controls="transaction-request-content" aria-selected="false">Request</button>
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
											<a href="#">Last Modified</a>
											<button class="geex-btn geex-btn--sm">Apply Filters</button>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="geex-content__section__content">
							<div class="tab-content geex-transaction-content" id="geex-transaction-content">
								<div class="tab-pane fade show active" id="transaction-history-content" role="tabpanel" aria-labelledby="transaction-history-tab">
									<div class="transaction-content">
										<div class="transaction-type">
										<div class="transaction-type__single decrement">
											<div class="transaction-type__single__icon">
											<i class="uil uil-arrow-down"></i>
											</div>
											<div class="transaction-type__single__content">
											<h4 class="transaction-type__single__content__title">Paypal Transfer</h4>
											<p class="transaction-type__single__content__subtitle">November 24th, 2020 at 2:45 AM</p>
											</div>
										</div>
										<div class="transaction-type__single decrement">
											<div class="transaction-type__single__icon">
											<i class="uil uil-arrow-down"></i>
											</div>
											<div class="transaction-type__single__content">
											<h4 class="transaction-type__single__content__title">Upgrade Storage Plan</h4>
											<p class="transaction-type__single__content__subtitle">November 24th, 2020 at 2:45 AM</p>
											</div>
										</div>
										<div class="transaction-type__single increment">
											<div class="transaction-type__single__icon">
											<i class="uil uil-arrow-up"></i>
											</div>
											<div class="transaction-type__single__content">
											<h4 class="transaction-type__single__content__title">Bank Transfer</h4>
											<p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
											</div>
										</div>
										<div class="transaction-type__single decrement">
											<div class="transaction-type__single__icon">
											<i class="uil uil-arrow-down"></i>
											</div>
											<div class="transaction-type__single__content">
											<h4 class="transaction-type__single__content__title">Youtube Monthly Subcrition</h4>
											<p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
											</div>
										</div>
										<div class="transaction-type__single increment">
											<div class="transaction-type__single__icon">
											<i class="uil uil-arrow-up"></i>
											</div>
											<div class="transaction-type__single__content">
											<h4 class="transaction-type__single__content__title">Bank Transfer</h4>
											<p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
											</div>
										</div>
										</div>
										<div class="transaction-type">
											<div class="transaction-type__single">
												<div class="transaction-type__single__icon">
													<img src="assets/img/avatar/t1.svg" alt="user" />
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Thomas Edison</h4>
													<p class="transaction-type__single__content__subtitle">@thomasedis</p>
												</div>
												<div class="transaction-type__single__rate">
													<span class="decrement">- $98.21</span>
												</div>
											</div>
											<div class="transaction-type__single">
												<div class="transaction-type__single__icon">
													<img src="assets/img/icon/dropbox.svg" alt="user" />
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Dropbox</h4>
													<p class="transaction-type__single__content__subtitle">November</p>
												</div>
												<div class="transaction-type__single__rate">
													<span class="increment">+ $200</span>
												</div>
											</div>
											<div class="transaction-type__single">
												<div class="transaction-type__single__icon">
													<img src="assets/img/avatar/t2.svg" alt="user" />
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Louis Khun</h4>
													<p class="transaction-type__single__content__subtitle">@thomasedis</p>
												</div>
												<div class="transaction-type__single__rate">
													<span class="increment">+ $500</span>
												</div>
											</div>
											<div class="transaction-type__single">
												<div class="transaction-type__single__icon">
													<img src="assets/img/icon/youtube.svg" alt="user" />
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Youtube</h4>
													<p class="transaction-type__single__content__subtitle">September</p>
												</div>
												<div class="transaction-type__single__rate">
													<span class="decrement">- $200</span>
												</div>
											</div>
											<div class="transaction-type__single">
												<div class="transaction-type__single__icon">
													<img src="assets/img/avatar/t3.svg" alt="user" />
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Isabella Sirait</h4>
													<p class="transaction-type__single__content__subtitle">@thomasedis</p>
												</div>
												<div class="transaction-type__single__rate">
													<span class="increment">+ $500</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="transaction-upcoming-content" role="tabpanel" aria-labelledby="transaction-upcoming-tab">
									<div class="transaction-content">
										<div class="transaction-type">
											<div class="transaction-type__single increment">
												<div class="transaction-type__single__icon">
													<i class="uil uil-arrow-up"></i>
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Bank Transfer</h4>
													<p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
												</div>
											</div>
											<div class="transaction-type__single decrement">
												<div class="transaction-type__single__icon">
													<i class="uil uil-arrow-down"></i>
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Youtube Monthly Subcrition</h4>
													<p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
												</div>
											</div>
											<div class="transaction-type__single increment">
												<div class="transaction-type__single__icon">
													<i class="uil uil-arrow-up"></i>
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Bank Transfer</h4>
													<p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
												</div>
											</div>
											<div class="transaction-type__single decrement">
												<div class="transaction-type__single__icon">
													<i class="uil uil-arrow-down"></i>
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Paypal Transfer</h4>
													<p class="transaction-type__single__content__subtitle">November 24th, 2020 at 2:45 AM</p>
												</div>
											</div>
											<div class="transaction-type__single decrement">
												<div class="transaction-type__single__icon">
													<i class="uil uil-arrow-down"></i>
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Upgrade Storage Plan</h4>
													<p class="transaction-type__single__content__subtitle">November 24th, 2020 at 2:45 AM</p>
												</div>
											</div>
										</div>
										<div class="transaction-type">
											<div class="transaction-type__single">
												<div class="transaction-type__single__icon">
													<img src="assets/img/avatar/t1.svg" alt="user" />
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Thomas Edison</h4>
													<p class="transaction-type__single__content__subtitle">@thomasedis</p>
												</div>
												<div class="transaction-type__single__rate">
													<span class="decrement">- $98.21</span>
												</div>
											</div>
											<div class="transaction-type__single">
												<div class="transaction-type__single__icon">
													<img src="assets/img/icon/dropbox.svg" alt="user" />
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Dropbox</h4>
													<p class="transaction-type__single__content__subtitle">November</p>
												</div>
												<div class="transaction-type__single__rate">
													<span class="increment">+ $200</span>
												</div>
											</div>
											<div class="transaction-type__single">
												<div class="transaction-type__single__icon">
													<img src="assets/img/avatar/t2.svg" alt="user" />
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Louis Khun</h4>
													<p class="transaction-type__single__content__subtitle">@thomasedis</p>
												</div>
												<div class="transaction-type__single__rate">
													<span class="increment">+ $500</span>
												</div>
											</div>
											<div class="transaction-type__single">
												<div class="transaction-type__single__icon">
													<img src="assets/img/icon/youtube.svg" alt="user" />
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Youtube</h4>
													<p class="transaction-type__single__content__subtitle">September</p>
												</div>
												<div class="transaction-type__single__rate">
													<span class="decrement">- $200</span>
												</div>
											</div>
											<div class="transaction-type__single">
												<div class="transaction-type__single__icon">
													<img src="assets/img/avatar/t3.svg" alt="user" />
												</div>
												<div class="transaction-type__single__content">
													<h4 class="transaction-type__single__content__title">Isabella Sirait</h4>
													<p class="transaction-type__single__content__subtitle">@thomasedis</p>
												</div>
												<div class="transaction-type__single__rate">
													<span class="increment">+ $500</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="transaction-request-content" role="tabpanel" aria-labelledby="transaction-request-tab">
								<div class="transaction-content">
									<div class="transaction-type">
										<div class="transaction-type__single increment">
											<div class="transaction-type__single__icon">
												<i class="uil uil-arrow-up"></i>
											</div>
											<div class="transaction-type__single__content">
												<h4 class="transaction-type__single__content__title">Bank Transfer</h4>
												<p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
											</div>
										</div>
										<div class="transaction-type__single decrement">
											<div class="transaction-type__single__icon">
												<i class="uil uil-arrow-down"></i>
											</div>
											<div class="transaction-type__single__content">
												<h4 class="transaction-type__single__content__title">Paypal Transfer</h4>
												<p class="transaction-type__single__content__subtitle">November 24th, 2020 at 2:45 AM</p>
											</div>
										</div>
										<div class="transaction-type__single increment">
											<div class="transaction-type__single__icon">
												<i class="uil uil-arrow-up"></i>
											</div>
											<div class="transaction-type__single__content">
												<h4 class="transaction-type__single__content__title">Bank Transfer</h4>
												<p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
											</div>
										</div>
										<div class="transaction-type__single decrement">
											<div class="transaction-type__single__icon">
												<i class="uil uil-arrow-down"></i>
											</div>
											<div class="transaction-type__single__content">
												<h4 class="transaction-type__single__content__title">Youtube Monthly Subcrition</h4>
												<p class="transaction-type__single__content__subtitle">September 5th, 2020 at 11:56 AM</p>
											</div>
										</div>
										<div class="transaction-type__single decrement">
											<div class="transaction-type__single__icon">
												<i class="uil uil-arrow-down"></i>
											</div>
											<div class="transaction-type__single__content">
												<h4 class="transaction-type__single__content__title">Upgrade Storage Plan</h4>
												<p class="transaction-type__single__content__subtitle">November 24th, 2020 at 2:45 AM</p>
											</div>
										</div>
									</div>
									<div class="transaction-type">
										<div class="transaction-type__single">
											<div class="transaction-type__single__icon">
												<img src="assets/img/avatar/t2.svg" alt="user" />
											</div>
											<div class="transaction-type__single__content">
												<h4 class="transaction-type__single__content__title">Louis Khun</h4>
												<p class="transaction-type__single__content__subtitle">@thomasedis</p>
											</div>
											<div class="transaction-type__single__rate">
												<span class="increment">+ $500</span>
											</div>
										</div>
										<div class="transaction-type__single">
											<div class="transaction-type__single__icon">
												<img src="assets/img/icon/youtube.svg" alt="user" />
											</div>
											<div class="transaction-type__single__content">
												<h4 class="transaction-type__single__content__title">Youtube</h4>
												<p class="transaction-type__single__content__subtitle">September</p>
											</div>
											<div class="transaction-type__single__rate">
												<span class="decrement">- $200</span>
											</div>
										</div>
										<div class="transaction-type__single">
											<div class="transaction-type__single__icon">
												<img src="assets/img/avatar/t3.svg" alt="user" />
											</div>
											<div class="transaction-type__single__content">
												<h4 class="transaction-type__single__content__title">Isabella Sirait</h4>
												<p class="transaction-type__single__content__subtitle">@thomasedis</p>
											</div>
											<div class="transaction-type__single__rate">
												<span class="increment">+ $500</span>
											</div>
										</div>
										<div class="transaction-type__single">
											<div class="transaction-type__single__icon">
												<img src="assets/img/avatar/t1.svg" alt="user" />
											</div>
											<div class="transaction-type__single__content">
												<h4 class="transaction-type__single__content__title">Thomas Edison</h4>
												<p class="transaction-type__single__content__subtitle">@thomasedis</p>
											</div>
											<div class="transaction-type__single__rate">
												<span class="decrement">- $98.21</span>
											</div>
										</div>
										<div class="transaction-type__single">
											<div class="transaction-type__single__icon">
												<img src="assets/img/icon/dropbox.svg" alt="user" />
											</div>
											<div class="transaction-type__single__content">
												<h4 class="transaction-type__single__content__title">Dropbox</h4>
												<p class="transaction-type__single__content__subtitle">November</p>
											</div>
											<div class="transaction-type__single__rate">
												<span class="increment">+ $200</span>
											</div>
										</div>
									</div>
								</div>
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





















