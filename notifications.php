<!doctype html>
<html lang="en" dir="ltr">

<?php
$pageTitle = 'Notifications';
require_once 'common/header.php';
?>

<body class="geex-dashboard" style="background: #f5f3f7;">
    <main class="geex-main-content">
        <?php require_once 'common/menu.php'; ?>

        <div class="geex-content">
            <div class="geex-content__header" style="background: linear-gradient(90deg, #8b46c1 0%, #b78de7 100%); padding: 1.5rem; border-radius: 12px; color: white; margin-bottom: 2rem; box-shadow: 0 4px 20px rgba(139, 70, 193, 0.3);">
                <div class="geex-content__header__content">
                    <h2 class="geex-content__header__title">🔔 Notifications</h2>
                    <p class="geex-content__header__subtitle" style="opacity: 0.9;">Stay updated with your latest alerts and automated messages</p>
                </div>
                <div class="geex-content__header__action">
                    <?php require_once 'common/userProfileSection.php'; ?>
                </div>
            </div>

            <style>
                .notification-section {
                    display: grid;
                    gap: 2rem;
                    animation: fadeIn 0.6s ease-in-out;
                }
                .notification-card {
                    background: #fff;
                    border-radius: 16px;
                    padding: 1.5rem;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                    border-left: 6px solid #9b59d1;
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }
                .notification-card:hover {
                    transform: translateY(-4px);
                    box-shadow: 0 8px 25px rgba(139, 70, 193, 0.25);
                }
                .notification-card h3 {
                    color: #5b2a86;
                    font-weight: 600;
                    margin-bottom: 1rem;
                }
                .notification-item {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    border-bottom: 1px solid #eee;
                    padding: 0.75rem 0;
                    animation: slideIn 0.5s ease-in-out;
                }
                .notification-item:last-child {
                    border-bottom: none;
                }
                .notification-dot {
                    width: 10px;
                    height: 10px;
                    border-radius: 50%;
                    background: #a053df;
                    margin-right: 10px;
                    flex-shrink: 0;
                    box-shadow: 0 0 10px rgba(160, 83, 223, 0.5);
                }
                .notification-text {
                    flex: 1;
                    color: #333;
                }
                .notification-time {
                    font-size: 0.85rem;
                    color: #777;
                }
                .rules-table {
                    width: 100%;
                    border-collapse: collapse;
                    background: #fff;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                }
                .rules-table th, .rules-table td {
                    padding: 1rem;
                    text-align: left;
                    border-bottom: 1px solid #eee;
                    color: #444;
                }
                .rules-table th {
                    background: #f9f5fc;
                    color: #5b2a86;
                    font-weight: 600;
                }
                .status-active {
                    background: #a053df;
                    color: #fff;
                    padding: 4px 12px;
                    border-radius: 20px;
                    font-size: 0.85rem;
                }
                .status-inactive {
                    background: #e4d2f5;
                    color: #5b2a86;
                    padding: 4px 12px;
                    border-radius: 20px;
                    font-size: 0.85rem;
                }
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                @keyframes slideIn {
                    from { opacity: 0; transform: translateX(-15px); }
                    to { opacity: 1; transform: translateX(0); }
                }
            </style>

            <div class="notification-section">
                <div class="notification-card">
                    <h3>Recent Notifications</h3>
                    <div class="notification-item">
                        <div class="notification-dot"></div>
                        <div class="notification-text">
                            <strong>Payment Reminder Sent</strong><br>
                            <small>To: John Doe – Payment due tomorrow (₦500)</small>
                        </div>
                        <div class="notification-time">2h ago</div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-dot"></div>
                        <div class="notification-text">
                            <strong>Loan Approved</strong><br>
                            <small>Sarah Davis – ₦1,500 loan approved</small>
                        </div>
                        <div class="notification-time">5h ago</div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-dot"></div>
                        <div class="notification-text">
                            <strong>Overdue Alert</strong><br>
                            <small>Robert Johnson – Payment 2 days overdue</small>
                        </div>
                        <div class="notification-time">1 day ago</div>
                    </div>
                </div>

                <div class="notification-card">
                    <h3>Automated Notification Rules</h3>
                    <table class="rules-table">
                        <thead>
                            <tr>
                                <th>Rule Name</th>
                                <th>Trigger</th>
                                <th>Method</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Payment Due Reminder</td>
                                <td>3 days before due date</td>
                                <td>Email + SMS</td>
                                <td><span class="status-active">Active</span></td>
                            </tr>
                            <tr>
                                <td>Overdue Notice</td>
                                <td>1 day after due date</td>
                                <td>Email + Push</td>
                                <td><span class="status-active">Active</span></td>
                            </tr>
                            <tr>
                                <td>Final Notice</td>
                                <td>7 days overdue</td>
                                <td>Registered Mail</td>
                                <td><span class="status-inactive">Inactive</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php require_once 'common/footer.php'; ?>
</body>
</html>
