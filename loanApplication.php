<!doctype html>
<html lang="en" dir="ltr">

<?php

$pageTitle = 'Loan Application';
require_once 'common/header.php'; 

doCheckUserIsLoggedInAndRedirect('user', 'login');

$module = DEF_MODULE_ID_LOAN_APPLICATION;
$rs = Src\Module\LoanApplication\LoanApplicationFunctions::invokeGetUserLoans();


$rsxUser = Src\Module\User\UserFunctions::getUserInfo(
	getLoggedInUserDetailsByKey() , ['is_eligible']
);
if ($rsxUser)
{
	$allowToLoan = doTypeCastInt($rsxUser['is_eligible']);
}
$redirect = 'loanapplication';
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
		
			<div class="geex-content__invoice">
				<div class="geex-content__invoice__list">
					<div class="geex-content__todo__header">
						<div class="geex-content__todo__header__title">
						<?php if ($allowToLoan) { ?>
								<button class="geex-btn geex-btn--primary geex-btn__add-modal"><i class="uil-plus"></i> New Loan Application</button>
						<?php } 
						else
							{
						?>	
							<text class="geex-btn geex-btn--danger "></i>Loan Facility Unavailable, Account Verification In Progress</text>
						<?php } ?>
						</div>
					</div>
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
                            <th style="width: 10%;"></th>
                            <th style="width: 10%;"></th>
                            <th style="width: 10%;"></th>
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
							// Decide badge color
							// Decide badge color
							switch($status)
							{
								case 'approved':
									$badgeClass = 'geex-badge geex-badge--success-transparent';
									break;

								case 'pending':
									$badgeClass = 'geex-badge geex-badge--warning-transparent';
									break;
									
								case 'rejected':
								case 'closed':
									$badgeClass = 'geex-badge geex-badge--danger-transparent';
									break;

								case 'completed':
									$badgeClass = 'geex-badge geex-badge--info-transparent';
									break;
							}
					?>
						<tr data-id="<?= $id ?>">
							<td>
								<span class="name"><?= $i ?></span>
							</td>
							<td>
								<div class="author-area">
									<p>
										<a href="<?= DEF_ROOT_PATH ?>/loandetails?id=<?= $id ?>" style="color: #2c7be5; font-weight: 600; text-decoration: none;">
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

							<?php if ($approved == 0) {?>
								<td>
									<button type="button" class="geex-btn geex-btn--primary" onclick="editLoan(
									'<?= $id ?>', '<?= $name ?>', '<?= $amount ?>', '<?= $totalAmount ?>', '<?= $duration ?>', '<?= strtolower($repaymentType) ?>', '<?= $purpose ?>')">
										Edit
									</button>
								</td>
								<td>
									<button type="button" class="geex-btn geex-btn--danger" onclick="deleteLoan('<?= $id ?>')">
										Delete
									</button>
								</td>
							<?php 
							} 
							else if ($approved == 1 && $status != 'closed')
							{
							?>
								<td>
									<button type="button" class="geex-btn geex-btn--danger" onclick="cancelLoan('<?= $id ?>')">
										Close
									</button>
								</td>
							<?php } ?>
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

			<?php require_once 'common/loanform.php'; ?>
		</div>
	</main>
<script>

var module = '<?= $module; ?>';
function editLoan(id, name, amount, total, duration, type, purpose) {
    $("#loanForm input[name='id']").val(id);
    $("#loanForm input[name='name']").val(name);
    $("#loanForm textarea[name='purpose']").val(purpose);
    $("#loanForm input[name='amount']").val(amount);
    $("#loanForm select[name='repaymentType']").val(type).trigger("change");
    $("#loanForm select[name='duration']").val(duration);
    $("#totalAmount").text(total);
    $(".geex-btn__add-modal").trigger("click");
}

function cancelLoan(id) {
    Swal.fire({
        title: "Close Loan?",
        text: "Are you sure you want to Close this loan?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Close",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6"
    }).then((result) => {
        if (result.isConfirmed) {
			$("body").append(`
                <div id="block-overlay" 
                     style="position:fixed; top:0; left:0; width:100%; height:100%;
                            background:rgba(0,0,0,0.5); z-index:9999; display:flex;
                            align-items:center; justify-content:center; color:#fff;
                            font-size:20px; font-weight:bold;">
                    Processing...
                </div>
            `);

            $.ajax({
                type: "POST",
                url: "actions",
                data: { 
					action: "close"
					, id: id 
					, moduleId: module 
				},
                dataType: "json",
                success: function (res)
				{
					$("#block-overlay").remove();
                    if (res.status === "success") 
					{
                        throwSuccess(res.message, "toast-top-right");
                        setTimeout(() => location.reload(), 1000);
                    } 
					else 
					{
                        throwWarning(res.message, "toast-top-right");
                    }
                },
                error: function () 
				{
					$("#block-overlay").remove();
                   throwWarning('Failed to close, please try again', "toast-top-right");
                }
            });
        }
    });
}

function deleteLoan(id) {
    Swal.fire({
        title: "Delete Loan?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6"
    }).then((result) => {
        if (result.isConfirmed) {
			$("body").append(`
                <div id="block-overlay" 
                     style="position:fixed; top:0; left:0; width:100%; height:100%;
                            background:rgba(0,0,0,0.5); z-index:9999; display:flex;
                            align-items:center; justify-content:center; color:#fff;
                            font-size:20px; font-weight:bold;">
                    Processing...
                </div>
            `);

            $.ajax({
                type: "POST",
                url: "actions",
                data: { 
					action: "delete"
					, id: id 
					, moduleId: module 
				},
                dataType: "json",
                success: function (res) {
					$("#block-overlay").remove();
                    if (res.status === "success") 
					{
                      	throwSuccess(res.message, "toast-top-right");
                        setTimeout(() => location.reload(), 1000);
                    } 
					else 
					{
                        throwWarning(res.message, "toast-top-right");
                    }
                },
                error: function () 
				{
					$("#block-overlay").remove();
                    throwWarning('Failed to delete, please try again', "toast-top-right");
                }
            });
        }
    });
}

</script>
	<!-- inject:js-->
	<?php require_once 'common/footer.php'; ?>
</body>

</html>


