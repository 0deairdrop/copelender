<!doctype html>
<html lang="en" dir="ltr">

<?php 
$pageTitle = 'Loan Details';
require_once 'common/header.php'; 
doCheckUserIsLoggedInAndRedirect('user', 'login');

$module = DEF_MODULE_ID_LOAN_APPLICATION;
$id = $_REQUEST['id'] ?? '';
if (strlen($id) != 36)
{
   header("Location: loanApplication");
    exit;
}
$isAdmin = doTypeCastInt(getLoggedInUserDetailsByKey('isadmin'));
$rs = Src\Module\LoanApplication\LoanApplicationFunctions::invokeGetLoanItems($id);
$rsx = Src\Module\LoanApplication\LoanApplicationFunctions::getLoanInfo($id, ['name']);
$name = $rsx['name'];
$redirect = 'loanDetails';
?>

<body class="geex-dashboard">
	<main class="geex-main-content">

		<?php require_once 'common/menu.php'; ?>	 

		<div class="geex-content">
			<div class="geex-content__header">
				<div class="geex-content__header__content">
					<h2 class="geex-content__header__title"><?= strtoupper($name) ?> - Payment Scheduler</h2>
					<p class="geex-content__header__subtitle"></p>
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
                            <th style="width: 20%;">Payment Due Date</th>
                            <th style="width: 20%;">Amount </th>
                            <th style="width: 20%;">Status</th>
                            <th style="width: 20%;">Transaction Date</th>
                            <th style="width: 20%;"></th>
                            <th style="width: 20%;"></th>
                            <th style="width: 20%;"></th>
                        </tr>
                    </thead>
					<tbody>
					<?php if (count($rs) > 0) 
					{ 
						$i = 0;
						foreach ($rs as $r) 
						{
							$id = $r['id'];
							$tdate = $r['tdate'] ?? 'not paid';
							$amount = doTypeCastDouble($r['amount']);
							$status = $r['status'];
							$dueDate = formatDate($r['payment_due_date'], 'Y-m-d');
							$i++;
							// Decide badge color
							switch($status)
							{
								case 'paid':
									$badgeClass = 'geex-badge geex-badge--success-transparent';
									break;

								case 'pending':
									$badgeClass = 'geex-badge geex-badge--warning-transparent';
									break;
							}
					?>
						<tr data-id="<?= $id ?>">
							<td>
								<div class="author-area">
									<p><?= $i ?></p>
								</div>
							</td>
							<td>
								<span class="designation"><?= $dueDate ?></span>
							</td>
							<td><span><?= 'NGN ' . doNumberFormat($amount) ?></span></td>
							<td>
								<span class=" <?= $badgeClass ?>"><?= $status ?></span>
							</td>
							
							<td>
								<span class="designation"><?= $tdate ?></span>
							</td>
							<?php if ($status !== 'paid'): ?>
								<td>
									<?php if ($isAdmin): ?>
										<button 
											type="button" 
											class="geex-btn geex-btn--success" 
											onclick="doSendPaymentReminder('<?= $id ?>')"
										>
											Send Reminder
										</button>
									<?php else: ?>
										<button 
											type="button" 
											class="geex-btn geex-btn--success" 
											onclick="doMakePayment('<?= $id ?>')"
										>
											Pay
										</button>
									<?php endif; ?>
								</td>
							<?php endif; ?>

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
<script>

var module = '<?= $module; ?>';
function doMakePayment(id) {
    Swal.fire({
        title: "Pay Recurring Amount?",
        text: "Are you sure you want to Deposit this Payment?",
        icon: "success",
        showCancelButton: true,
        confirmButtonText: "Yes",
        confirmButtonColor: "rgba(37, 202, 87, 1)",
        cancelButtonColor: "#d33",
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
                    action: "makePayment",
                    id: id,
                    moduleId: module
                },
                dataType: "json",
                success: function (res) {
                    // Remove overlay after response
                    $("#block-overlay").remove();

                    if (res.status === "success") {
                        throwSuccess(res.message, "toast-top-right");
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        throwWarning(res.message, "toast-top-right");
                    }
                },
                error: function () {
                    // Remove overlay on error
                    $("#block-overlay").remove();
                    throwWarning("Payment Failed, please try again", "toast-top-right");
                }
            });
        }
    });
}

function doSendPaymentReminder(id) {
    Swal.fire({
        title: "Send Email Reminder?",
        text: "Are you sure you want send this reminder?",
        icon: "success",
        showCancelButton: true,
        confirmButtonText: "Yes",
        confirmButtonColor: "rgba(37, 202, 87, 1)",
        cancelButtonColor: "#d33",
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
                    action: "sendEmailReminder",
                    id: id,
                    moduleId: module
                },
                dataType: "json",
                success: function (res) {
                    // Remove overlay after response
                    $("#block-overlay").remove();

                    if (res.status === "success") {
                        throwSuccess(res.message, "toast-top-right");
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        throwWarning(res.message, "toast-top-right");
                    }
                },
                error: function () {
                    // Remove overlay on error
                    $("#block-overlay").remove();
                    throwWarning("Action failed, please try again", "toast-top-right");
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


