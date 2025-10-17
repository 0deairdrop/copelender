<!doctype html>
<html lang="en" dir="ltr">

<?php

$pageTitle = 'Loan Application';
require_once 'common/header.php'; 
$module = DEF_MODULE_ID_LOAN_APPLICATION;
$rs = Src\Module\LoanApplication\LoanApplicationFunctions::invokeGetUserLoans();


$rsxUser = Src\Module\User\UserFunctions::getUserInfo(
	getLoggedInUserDetailsByKey() , ['is_eligible']
);
if ($rsxUser)
{
	$allowToLoan = doTypeCastInt($rsxUser['is_eligible']);
}
$redirect = 'loanApplication';
?>

<body class="geex-dashboard">
	<main class="geex-main-content">

		<?php require_once 'common/menu.php'; ?>	 

		<div class="geex-content">
			<div class="geex-content__header">
				<div class="geex-content__header__content">
					<h2 class="geex-content__header__title">Loan Applications</h2>
					<p class="geex-content__header__subtitle">My Loans</p>
				</div>
				
				<div class="geex-content__header__action">
					<?php require_once 'common/userProfileSection.php'; ?>
				</div>
			</div>
		
			<div class="geex-content__section geex-content__form table-responsive">
                <table class="table-reviews-geex-1">
                    <thead>
                        <tr style="width: 100%;">
                            <th style="width: 3%;">#</th>
                            <th style="width: 20%;">Loan Title</th>
                            <th style="width: 20%;">Repayment Type</th>
                            <th style="width: 20%;">Application Date</th>
                            <th style="width: 20%;">Amount</th>
                            <th style="width: 20%;">Total Amount</th>
                            <th style="width: 20%;">Status</th>
                        </tr>
                    </thead>
					<tbody>
					<?php 
					$i = 0;
					if (count($rs) > 0) 
					{ 
						foreach ($rs as $r) 
						{
							$id = $r['id'];
							$name = $r['name'];
							$amount = doTypeCastDouble($r['amount']);
							$totalAmount = doTypeCastDouble($r['total_amount']);
							$duration = doTypeCastInt($r['duration']);
							$approved  = doTypeCastInt($r['approved']);
							$repaymentType = strtoupper($r['repayment_type']);
							$status = $r['status'];
							$purpose = $r['purpose'];
							$cdate = $r['cdate'];
							$i++;
					?>
						<tr data-id="<?= $id ?>">
							<td>
								<span class="name"><?= $i ?></span>
							</td>
							<td>
								<div class="author-area">
									<p>
										<a href="<?= DEF_ROOT_PATH ?>/loanDetails?id=<?= $id ?>" style="color: #2c7be5; font-weight: 600; text-decoration: none;">
											<?= htmlspecialchars($name) ?>
										</a>
									</p>
								</div>
							</td>
							<td>
								<span class="designation"><?= $repaymentType ?></span>
							</td>
							<td>
								<span class="name"><?= $cdate ?></span>
							</td>
							<td><span><?= 'NGN ' . doNumberFormat($amount) ?></span></td>
							<td><span><?= 'NGN ' . doNumberFormat($totalAmount) ?></span></td>
							<td>
								<span class=" <?= $badgeClass ?>"><?= $status ?></span>
							</td>
						</tr>
					<?php 
					} 
						} 
					else 
					{ ?>
					<tr>
						<td colspan="9" style="text-align:center;">No records found</td>
					</tr>
					<?php } ?>
				</tbody>

                </table>
			</div>
		
		</div>
	</main>
	<!-- inject:js-->
	<?php require_once 'common/footer.php'; ?>
</body>

</html>


