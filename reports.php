<!doctype html>
<html lang="en" dir="ltr">
<?php
$pageTitle = 'Loan Report';
require_once 'common/header.php';
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
                        <h3>Total Customers</h3>
                        <div class="stat-value">1</div>
                    </div>
                    <div class="stat-icon blue">👥</div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <h3>Total Loans</h3>
                        <div class="stat-value">0</div>
                        <div class="stat-subtext">0 approved, 0 pending</div>
                    </div>
                    <div class="stat-icon purple">💳</div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <h3>Loan Portfolio</h3>
                        <div class="stat-value">$0</div>
                    </div>
                    <div class="stat-icon green">💰</div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <h3>Collections</h3>
                        <div class="stat-value">$0</div>
                    </div>
                    <div class="stat-icon yellow">📈</div>
                </div>
            </div>

            <div class="metrics-row">
                <div class="metric-card">
                    <h4>Loan Approval Rate</h4>
                    <div class="metric-value green">
                        0% <span class="metric-trend">↗</span>
                    </div>
                    <p class="metric-description">0 out of 0 applications approved</p>
                </div>

                <div class="metric-card">
                    <h4>Repayment Rate</h4>
                    <div class="metric-value green">
                        0% <span class="metric-trend">↗</span>
                    </div>
                    <p class="metric-description">0 out of 0 repayments completed</p>
                </div>

                <div class="metric-card">
                    <h4>Overdue Accounts</h4>
                    <div class="metric-value yellow">
                        0 <span style="color: #f59e0b;">⚠</span>
                    </div>
                    <p class="metric-description">Accounts requiring attention</p>
                </div>
            </div>

            <div class="status-distribution">
                <h3>Loan Status Distribution</h3>
                <div class="status-items">
                    <div class="status-item">
                        <div class="status-count green">0</div>
                        <span class="status-badge approved">Approved</span>
                    </div>
                    <div class="status-item">
                        <div class="status-count yellow">0</div>
                        <span class="status-badge pending">Pending</span>
                    </div>
                    <div class="status-item">
                        <div class="status-count red">0</div>
                        <span class="status-badge rejected">Rejected</span>
                    </div>
                </div>
            </div>

            <div class="table-section">
                <h3>Recent Loan Applications</h3>
                <table class="table-reviews-geex-1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Loan Title</th>
                            <th>Repayment Type</th>
                            <th>Application Date</th>
                            <th>Amount</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" style="text-align:center; padding:40px; color:#6c757d;">
                                No loan applications found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <?php require_once 'common/footer.php'; ?>
</body>
</html>
