<!doctype html>
<html lang="en" dir="ltr">

<?php 
$pageTitle = 'Loan Approval';
require_once 'common/header.php'; 
$module = DEF_MODULE_ID_LOAN_APPLICATION;
$rs = Src\Module\LoanApplication\LoanApplicationFunctions::invokeGetAllLoans();
$redirect = 'loan';
$arUserNames = [];
?>

<body class="geex-dashboard">
	<main class="geex-main-content">

		<?php require_once 'common/menu.php'; ?>	 

		<div class="geex-content">
			<div class="geex-content__header">
				<div class="geex-content__header__content">
					<h2 class="geex-content__header__title">Loan Approval</h2>
					<p class="geex-content__header__subtitle">All Loans</p>
				</div>
	
				<div class="geex-content__header__action">
					<?php require_once 'common/userProfileSection.php'; ?>
				</div>
			</div>

			<div class="geex-content__section geex-content__form table-responsive">
                <table class="table-reviews-geex-1">
                    <thead>
                        <tr style="width: 100%;">
                            <th style="width: 5%;">#</th>
                            <th style="width: 20%;">Customer Name</th>
                            <th style="width: 20%;">Loan Title</th>
                            <th style="width: 15%;">Frequency</th>
                            <th style="width: 20%;">Date</th>
                            <th style="width: 20%;">Amount</th>
                            <!-- <th style="width: 20%;">T.Amount</th> -->
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
							$parentId = $r['parent_id'];
							$amount = doTypeCastDouble($r['amount']);
							$totalAmount = doTypeCastDouble($r['total_amount']);
							$duration = doTypeCastInt($r['duration']);
							$approved  = doTypeCastInt($r['approved']);
							$repaymentType = strtoupper($r['repayment_type']);
							$status = $r['status'];
							$cdate = $r['cdate'];
							$title = $r['name'];

							$name = '';
							if (!array_key_exists($parentId, $arUserNames))
							{
								$rsx= Src\Module\User\UserFunctions::getUserInfo($parentId, ['firstname', 'lastname']);
								if (count($rsx) > 0)
								{
									$arUserNames[$parentId] = $rsx['firstname'] .' '.$rsx['lastname'];
 								}
							}
							$name = $arUserNames[$parentId];
							$i++;
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
								<span class="author-area"><?= $name ?></span>
							</td>
							<td>
								<div class="author-area">
									<p>
										<a href="<?= DEF_ROOT_PATH ?>/loanDetails?id=<?= $id ?>" style="color: #2c7be5; font-weight: 600; text-decoration: none;">
											<?= htmlspecialchars($title) ?>
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
							<td>
								<span class=" <?= $badgeClass ?>"><?= $status ?></span>
							</td>

							<?php if ($approved == 0){?>
								<td>
									<button type="button" class="geex-btn geex-btn--success" onclick="doLoanApprove('<?= $id ?>')">
										Approve
									</button>
								</td>
								<td>
									<button type="button" class="geex-btn geex-btn--danger" onclick="doLoanReject('<?= $id ?>')">
										Reject
									</button>
								</td>
							<?php 
							} 
							else if ($approved == 1)
							{
							?>
								<?php if (!in_array($status, ['completed', 'closed'])) {?>
								<td>
									<button type="button" class="geex-btn geex-btn--success" onclick="doProcessAmountDue('<?= $id ?>')">
										Pay
									</button>
								</td>
								<?php }
								 if ($status != 'closed') {
								?>
								<td>
									<button type="button" class="geex-btn geex-btn--danger" onclick="doCloseLoan('<?= $id ?>')">
										Close
									</button>
								</td>
							<?php 
									 }
								} 
							?>
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

function doLoanReject(id) 
{
    Swal.fire({
        title: "Reject Loan?",
        text: "Are you sure you want to reject this loan application?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Reject",
		confirmButtonColor: "rgba(40, 109, 38, 1)",
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
					action: "reject"
					, id: id 
					, moduleId: module 
				},
                dataType: "json",
                success: function (res)
				{
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
                   throwWarning('Unknow Error Occured', "toast-top-right");
                }
            });
        }
    });
}

function doCloseLoan(id) 
{
    Swal.fire({
        title: "Close  Loan?",
        text: "Are you sure you want to close this loan?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Close",
		confirmButtonColor: "rgba(40, 109, 38, 1)",
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
                   throwWarning('Unknow Error Occured', "toast-top-right");
                }
            });
        }
    });
}

function doLoanApprove(id) 
{
    Swal.fire({
         title: "Approve  Loan?",
        text: "Are you sure you want to Approve this loan?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Approve",
		confirmButtonColor: "rgba(40, 109, 38, 1)",
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
					action: "approve"
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
                    throwWarning('Unknow Error Occured', "toast-top-right");
                }
            });
        }
    });
}
function doProcessAmountDue(id) 
{
    Swal.fire({
         title: "Process Full Loan  Repayment?",
        text: "Please verify if total Amount Due has been recieved?",
        icon: "success",
        showCancelButton: true,
        confirmButtonText: "Submit",
		confirmButtonColor: "rgba(40, 109, 38, 1)",
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
					 action: "payAmtDue"
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
                    throwWarning('Unknow Error Occured', "toast-top-right");
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


