<?php 
require_once '../../includes/utils.php';
use Src\Crud\Crud;
use Src\Module\LoanApplication\LoanApplicationFunctions;

$execute = $_REQUEST['execute'] ?? 0;
if ($execute == 1)
{
    global $db;
    $db->beginTransaction();
    try
    {
        $tableLoans = DEF_TBL_LOAN_APPLICATION;
        $tableLoansItems = DEF_TBL_LOAN_APPLICATION_ITEMS;
        $tableUsers = DEF_TBL_USR_USERS;
        $rs = Crud::select(
            $tableLoansItems,
            [
                'columns' => ['id', 'parent_id', 'amount', 'payment_due_date', 'status'],
                'join' => [
                    [
                        'table' => $tableLoans,
                        'columns' => [
                            'id AS loan_id',
                            'parent_id  AS customer_id',
                            'status  AS loan_status',
                            'name  AS loan_title',
                        ],
                        'type' => 'LEFT JOIN',
                        'on' => $tableLoansItems . '.parent_id = ' . $tableLoans . '.id'
                    ],
                    [
                        'table' => $tableUsers,
                        'columns' => [
                              'id AS customer_id'
                            , 'email AS customer_email'
                            , 'username AS customer_username'
                        ],
                        'type' => 'LEFT JOIN',
                        'on' => $tableLoans . '.parent_id = ' . $tableUsers . '.id'
                    ]
                ],
                'lessThan' => [$tableLoansItems . '.payment_due_date' => date('Y-m-d', strtotime('+7 days'))], // only select records that are 7 days ahead
                'where' => [
                    $tableLoansItems . '.status' => 'pending',
                    $tableLoans . '.status' => 'approved',
                    $tableLoans . '.approved' => 1,
                    $tableLoansItems . '.deleted' => 0,
                    $tableLoans . '.deleted' => 0
                ]
            ]
        );

        $arSentEmails = [];
        if (count($rs) > 0)
        {
            foreach ($rs as $r)
            {
                $amount = doTypeCastDouble($r['amount']);
                $userName = $r['customer_username'];
                $email = $r['customer_email'];
                $tdate = $r['payment_due_date'];
                $userId = $r['customer_id'];
                $loanTitle = ucwords($r['loan_title']);

                LoanApplicationFunctions::doSendCommonLoanEmail([
                      'userId' => $userId
                    , 'loanTitle' => $loanTitle
                    , 'tdate' => $tdate 
                    , 'totalAmount' => $amount 
                    , 'type' => 'paymentreminder'
                    , 'action' => ''
                    , 'title' => 'Payment Reminder'
                    , 'rsx' => [
                        'username' => $userName
                        , 'email' => $email
                    ]
                ]);

                $arSentEmails[$userName][] = $loanTitle;
            }
        }

        echo('<pre>'); print_r(['Emails Reminder Sent Sucessfully', $arSentEmails]); //exit;
    }
    catch (Exception $e)
    {
        $db->rollBack();
        http_response_code(500);
        echo json_encode(["message" => "An error occurred: " . $e->getMessage()]);
    }
}
exit;