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
                'columns' => ['id', 'amount', 'status', 'tdate', 'parent_id', 'cuser'],
                'join' => [
                    [
                        'table' => $tableLoans,
                        'columns' => [
                            'id AS loan_id',
                            'name  AS loan_title',
                        ],
                        'type' => 'LEFT JOIN',
                        'on' => $tableLoansItems . '.parent_id = ' . $tableLoans . '.id'
                    ]
                ],
                'lessThanOrEqual' => [$tableLoansItems . '.payment_due_date' => date('Y-m-d')], // only select records that less than or equal to today's date
                'where' => [
                    $tableLoansItems . '.status' => 'pending',
                    $tableLoans . '.status' => 'approved',
                    $tableLoans . '.approved' => 1,
                    $tableLoansItems . '.deleted' => 0,
                    $tableLoans . '.deleted' => 0
                ]
            ]
        );
        
        $totalAmount = 0;
        $arPaymentsMade = [];
        if (count($rs) > 0)
        {
            $cdate = getCurrentDate();
            foreach ($rs as $r)
            {
                LoanApplicationFunctions::invokeProcessProcessLoanRecurringPayment([
                     'record' => $r['id']
                    , 'cdate' => $cdate
                    , 'cuser' => $r['cuser']
                    , 'rs' => [
                         'id' => $r['id']
                        , 'amount' => $r['amount']
                        , 'status' => $r['status']
                        , 'tdate' => $r['tdate']
                        , 'parent_id' => $r['parent_id']
                    ]
                ]);
                
                $totalAmount += doTypeCastDouble($r['amount']);
                $arPaymentsMade[$r['loan_title']] = $r['amount'];
            }
        }

        // Commit the transaction
        $db->commit();
        echo('<pre>'); print_r([
                'totalAmountPaid' => doNumberFormat($totalAmount)
            , 'paymentsMade' => $arPaymentsMade
        ]); //exit;
    }
    catch (Exception $e)
    {
        $db->rollBack();
        http_response_code(500);
        echo json_encode(["message" => "An error occurred: " . $e->getMessage()]);
    }
}
exit;