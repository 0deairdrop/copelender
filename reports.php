<!doctype html>
<html lang="en" dir="ltr">
<?php
$pageTitle = 'Loan Report';

require_once 'common/header.php';
doCheckUserIsLoggedInAndRedirect('user', 'login');
use Src\Module\User\UserFunctions;
use Src\Module\Dashboard\FinancialReportsFunctions;
$rs = FinancialReportsFunctions::invokeGetFinancialReportData();
$arLoanApplications = $rs['arLoanApplications'];
$arDashBoardCount = $rs['arDashBoardCount'];
$arApprovalRate = $rs['arApprovalRate'];
$arLoanDistribution = $rs['arLoanDistribution'];
$arLoanStats = $rs['arLoanStats'];
//echo('<pre>'); print_r($rs); exit;
?>

<body class="geex-dashboard">
    <main class="geex-main-content">

        <?php require_once 'common/menu.php'; ?>	 

        <div class="geex-content">
            <div class="geex-content__header">
                <div class="geex-content__header__content">
                    <h2 class="geex-content__header__title">
                        <span>📊</span> Financial Reports
                    </h2>
                </div>

                <div class="geex-content__header__action">
                    <?php require_once 'common/userProfileSection.php'; ?>
                </div>
            </div>

            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                body {
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                    background-color: #f8f9fa;
                    color: #212529;
                }
                .stats-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                    gap: 20px;
                    margin-bottom: 32px;
                }
                .stat-card {
                    background: #fff;
                    border: 1px solid #e9ecef;
                    border-radius: 8px;
                    padding: 20px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    transition: all 0.2s;
                }
                .stat-card:hover {
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                }
                .stat-content h3 {
                    font-size: 14px;
                    font-weight: 500;
                    color: #6c757d;
                    margin-bottom: 8px;
                }
                .stat-content .stat-value {
                    font-size: 28px;
                    font-weight: 700;
                    color: #212529;
                }
                .stat-subtext {
                    font-size: 12px;
                    color: #6c757d;
                }
                .stat-icon {
                    width: 48px;
                    height: 48px;
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 24px;
                }
                .stat-icon.blue { background: #e7f3ff; color: #0d6efd; }
                .stat-icon.purple { background: #f3e8ff; color: #7c3aed; }
                .stat-icon.green { background: #d1fae5; color: #059669; }
                .stat-icon.yellow { background: #fef3c7; color: #f59e0b; }
                .metrics-row {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                    gap: 20px;
                    margin-bottom: 32px;
                }
                .metric-card {
                    background: #fff;
                    border: 1px solid #e9ecef;
                    border-radius: 8px;
                    padding: 24px;
                }
                .metric-card h4 {
                    font-size: 16px;
                    font-weight: 600;
                    margin-bottom: 16px;
                }
                .metric-value {
                    font-size: 36px;
                    font-weight: 700;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    margin-bottom: 8px;
                }
                .metric-value.green { color: #059669; }
                .metric-value.yellow { color: #f59e0b; }
                .status-distribution {
                    background: #fff;
                    border: 1px solid #e9ecef;
                    border-radius: 8px;
                    padding: 24px;
                    margin-bottom: 32px;
                }
                .status-distribution h3 {
                    font-size: 18px;
                    font-weight: 600;
                    margin-bottom: 24px;
                }
                .status-items {
                    display: flex;
                    justify-content: space-around;
                    align-items: center;
                }
                .status-item { text-align: center; }
                .status-count {
                    font-size: 42px;
                    font-weight: 700;
                    margin-bottom: 8px;
                }
                .status-count.green { color: #059669; }
                .status-count.yellow { color: #f59e0b; }
                .status-count.red { color: #dc2626; }
                .status-badge {
                    display: inline-block;
                    padding: 6px 16px;
                    border-radius: 20px;
                    font-size: 13px;
                    font-weight: 500;
                }
                .status-badge.approved { background: #d1fae5; color: #059669; }
                .status-badge.pending { background: #fef3c7; color: #f59e0b; }
                .status-badge.rejected { background: #fee2e2; color: #dc2626; }
                .table-section {
                    background: #fff;
                    border: 1px solid #e9ecef;
                    border-radius: 8px;
                    padding: 24px;
                }
                .table-section h3 {
                    font-size: 18px;
                    font-weight: 600;
                    margin-bottom: 20px;
                }
                .table-reviews-geex-1 {
                    width: 100%;
                    border-collapse: collapse;
                }
                .table-reviews-geex-1 thead th {
                    text-align: left;
                    padding: 12px;
                    font-size: 13px;
                    font-weight: 600;
                    color: #6c757d;
                    border-bottom: 2px solid #e9ecef;
                    background: #f8f9fa;
                }
                .table-reviews-geex-1 tbody td {
                    padding: 16px 12px;
                    border-bottom: 1px solid #e9ecef;
                    font-size: 14px;
                }
                .table-reviews-geex-1 tbody tr:hover {
                    background-color: #f8f9fa;
                }
            </style>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-content">
                        <h3>Total Debtors</h3>
                        <div class="stat-value"><?= doTypeCastInt($arDashBoardCount['totalCustomer'])?></div>
                    </div>
                    <div class="stat-icon blue">👥</div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <h3>Total Loans</h3>
                        <div class="stat-value"><?= doTypeCastInt($arDashBoardCount['totalLoans'])?></div>
                    </div>
                    <div class="stat-icon purple">💳</div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <h3>Total Amount Disbursed</h3>
                        <div class="stat-value">NGN <?= doNumberFormat($arDashBoardCount['loanPortFolio'])?></div>
                    </div>
                    <div class="stat-icon green">💰</div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <h3>Total Interest Generated</h3>
                        <div class="stat-value">NGN <?= doNumberFormat($arDashBoardCount['totalIntrest'])?></div>
                    </div>
                    <div class="stat-icon yellow">📈</div>
                </div>
            </div>

            <div class="metrics-row">
                <div class="metric-card">
                    <h4>Loan Approval Rate</h4>
                    <div class="metric-value green">
                        <?= doTypeCastInt($arApprovalRate['loanApprovalRate'])?> % <span class="metric-trend">↗</span>
                    </div>
                    <p class="metric-description"> <?= doTypeCastInt($arApprovalRate['totalApprovedLoans'])?> out of  <?= doTypeCastInt($arApprovalRate['totalLoans'])?> applications approved</p>
                </div>

                <div class="metric-card">
                    <h4>Repayment Rate</h4>
                    <div class="metric-value green">
                        <?= doTypeCastInt($arApprovalRate['loanRepaymentRate'])?> % <span class="metric-trend">↗</span>
                    </div>
                    <p class="metric-description"><?= doTypeCastInt($arApprovalRate['totalProcessedRepayments'])?> out of <?= doTypeCastInt($arApprovalRate['totalRepayment'])?> repayments completed</p>
                </div>

                <div class="metric-card">
                    <h4>Overdue Accounts</h4>
                    <div class="metric-value yellow">
                        <?= doTypeCastInt($arApprovalRate['pendingAccounts'])?><span style="color: #f59e0b;">⚠</span>
                    </div>
                    <p class="metric-description">Accounts requiring attention</p>
                </div>
            </div>

            <div class="status-distribution">
                <h3>Loan Status Distribution</h3>
                <div class="status-items">
                    <div class="status-item">
                        <div class="status-count green"><?= doTypeCastInt($arLoanStats['totalApprovedLoans'])?></div>
                        <span class="status-badge approved">Approved</span>
                    </div>
                    <div class="status-item">
                        <div class="status-count yellow"><?= doTypeCastInt($arLoanStats['totalPendingLoans'])?></div>
                        <span class="status-badge pending">Pending</span>
                    </div>
                    <div class="status-item">
                        <div class="status-count red"><?= doTypeCastInt($arLoanStats['totalRejectedLoans'])?></div>
                        <span class="status-badge rejected">Rejected</span>
                    </div>
                </div>
            </div>

            <div class="table-section">
                <h3>Recent Loans</h3>
                <table class="table-reviews-geex-1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Loan Title</th>
                            <th>Application Date</th>
                            <th>Repayment Type</th>
                            <th>Amount</th>
                            <th>Total Amount</th>
                            <th>Intrest Amount</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Approved By</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                       <tbody>
					<?php 
					$i = 0;
                    $arUsers = [];
					if (count($arLoanApplications) > 0) 
					{ 
						foreach ($arLoanApplications as $r) 
						{
							$id = $r['id'];
							$name = $r['name'];
							$amount = doTypeCastDouble($r['amount']);
							$totalAmount = doTypeCastDouble($r['total_amount']);
							$duration = doTypeCastInt($r['duration']);
							$approved  = doTypeCastInt($r['approved']);
							$repaymentType = strtoupper($r['repayment_type']);
							$status = $r['status'];
							$cdate = $r['cdate'];
							$approvedUserId = $r['approved_by'];

                            if(!array_key_exists($approvedUserId, $arUsers))
                            {
                                $arUsers[$approvedUserId] =  UserFunctions::getUserFullName($approvedUserId);
                            }
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
								<div class="author-area">
									<p>
										<a href="<?= DEF_ROOT_PATH ?>/loanDetails?id=<?= $id ?>" style="color: #2c7be5; font-weight: 600; text-decoration: none;">
											<?= htmlspecialchars($name) ?>
										</a>
									</p>
								</div>
							</td>
                            <td>
								<span class="name"><?= $cdate ?></span>
							</td>
							<td>
								<span class="designation"><?= $repaymentType ?></span>
							</td>
							<td><span><?= 'NGN ' . doNumberFormat($amount) ?></span></td>
							<td><span><?= 'NGN ' . doNumberFormat($totalAmount) ?></span></td>
                             <td>
								<span><?= 'NGN ' . doNumberFormat($r['interest_amount']) ?></span></td>
							</td>
                            <td>
								<span class="designation"><?= formatDate($r['approved_date'],'Y-m-d') ?></span>
							</td>
                            <td>
								<span class="designation"><?= formatDate($r['expected_closing_date'],'Y-m-d') ?></span>
							</td>
                              <td>
								<span class="name"><?= $arUsers[$approvedUserId] ?></span>
							</td>
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
    <?php require_once 'common/footer.php'; ?>
</body>
</html>
