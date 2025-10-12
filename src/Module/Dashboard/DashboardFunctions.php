<?php 
namespace Src\Module\Dashboard;

use Src\Crud\Crud;
use Src\Module\LoanApplication\LoanApplicationFunctions;

class DashboardFunctions
{ 
    public static $userId;
    protected static $tableTransactions = DEF_TBL_TRANSACTIONS;
    protected static $tableLoans = DEF_TBL_LOAN_APPLICATION;
    protected static $tableLoansItems = DEF_TBL_LOAN_APPLICATION_ITEMS;
    protected static $arWhere = [];
    public static $limit = 10;
    public static function getUserDashboardData($isAdmin=false)
    {
        if (!$isAdmin)
        {
            self::$userId = getLoggedInUserDetailsByKey();
        }

        self::getQueryCondition();

        return [
              'arTransactions' => self::getAllUserTransactions()
            , 'arProgress' => self::getUserLoansProgress()
            , 'arDashboardCount' => self::getUserDashboardCount()
        ];
    }

    public static function getAllUserTransactions()
    {
        return [
             'arTransactions' => self::invokeGetTransaction()
           , 'arUpcomingTransactions' => self::invokeGetUpcomingTransactions()
           , 'arDebits' => self::invokeGetTransaction('debits')
           , 'arCredits' => self::invokeGetTransaction('credits')
        ];
    }

    protected static function invokeGetTransaction($type='all')
    {
        $arWhere = [
              'user_id' => self::$userId
            , 'deleted' => 0
        ];

        if ($type != 'all')
        {
            $debitCredit = 0;
            if ($type == 'credits')
            {
                $debitCredit = 1;
            }
            $arWhere['debit_credit'] = $debitCredit;
        }

        if (strlen(self::$userId) != 36)
        {
            unset($arWhere['user_id']);
        }

        $arFetchParams =   [
            'columns' => ['id', 'user_id', 'parent_id', 'reference', 'amount', 'tdate', 'debit_credit'],
            'where' => $arWhere,
            'order' =>'cdate DESC'
        ];

        if (self::$limit  > 0)
        {
            $arFetchParams['limit'] = self::$limit;
        }

        $rs = Crud::select(
            self::$tableTransactions,$arFetchParams 
        );

        $arLoans = $rows = [];
        if ($rs)
        {
            foreach ($rs as $r)
            {
                $id = $r['id'];
                $loanId = $r['parent_id'];

                if (!array_key_exists($loanId, $arLoans))
                {
                    $arLoans[$loanId] = LoanApplicationFunctions::getLoanName($loanId);
                }

                $rows[] = [
                      'id' => $id
                    , 'amount' => doNumberFormat($r['amount'])
                    , 'tdate' => doTextDateFormating($r['tdate'])
                    , 'reference' => $r['reference']
                    , 'name' => $arLoans[$loanId]
                    , 'debit_credit' => doTypeCastInt($r['debit_credit'])
                ];
            }
        }

        return $rows;
    }

    protected static function invokeGetUpcomingTransactions()
    {
         $arWhere = [
              'cuser' => self::$userId
            , 'status' => 'pending'
            , 'deleted' => 0
        ];

        if (strlen(self::$userId) != 36)
        {
            unset($arWhere['cuser']);
        }

        $rs = Crud::select(
        self::$tableLoansItems,
            [
                'columns' => ['id',  'parent_id', 'amount', 'payment_due_date'],
                'where' => $arWhere,
                'limit' => self::$limit,
                'order' => 'payment_due_date',
                'between' => ['payment_due_date' => [date('Y-m-d'), date('Y-m-d', strtotime('+90 days'))]]
            ]
        );
        $arLoans = $rows = [];
        if ($rs)
        {
            foreach ($rs as $r)
            {
                $id = $r['id'];
                $loanId = $r['parent_id'];

                if (!array_key_exists($loanId, $arLoans))
                {
                    $arLoans[$loanId] = LoanApplicationFunctions::getLoanName($loanId);
                }

                $rows[] = [
                      'id' => $id
                    , 'amount' => doTypeCastDouble($r['amount'])
                    , 'tdate' => doTextDateFormating($r['payment_due_date'])
                    , 'name' => $arLoans[$loanId]
                    , 'type' => 'upcoming'
                ];
            }
        }

        return $rows;
    }

    public static function getUserLoansProgress()
    {
        $arWhere = self::$arWhere;
        $arWhere['status'] = 'approved';
        $arWhere['approved'] = 1;

        $rs = Crud::select(
            self::$tableLoans,
            [
                'columns' => ['id', 'name', 'total_amount_paid', 'total_amount', 'interest_amount'],
                'where' => $arWhere,
                'limit' => self::$limit
            ]
        );

        $rows = [];
        if (count($rs) > 0)
        {
            foreach ($rs as $r)
            {
                $id = $r['id'];
                $totalAmountPaid = doTypeCastDouble($r['total_amount_paid']);
                $totalAmount = doTypeCastDouble($r['total_amount']);
                $percentageCompleted = (($totalAmount - $totalAmountPaid)/$totalAmount ) * 100;

                $row = [
                      'id' => $id
                    , 'paid' => doNumberFormat($totalAmountPaid)
                    , 'left' => doNumberFormat($totalAmount)
                    , 'name' => $r['name']
                    , 'percentagePaid' => 100 - round($percentageCompleted,2)
                ];

                $rows[] = $row;
            }
        }
        return $rows;
    }

    public static function getUserDashboardCount()
    {
        $rsLoans = self::getDashboardCount(
            self::$tableLoans, ['total_amount' => 'totalLoanAmount', 'total_amount_paid' => 'totalAmountPaid']
        );

        $totalLoanAmount = $totalAmountPaid = $totalAmountLeft = 0;

        if ($rsLoans > 0)
        {
            $totalLoanAmount = round(doTypeCastDouble($rsLoans['totalLoanAmount']), 2);
            $totalAmountPaid = round(doTypeCastDouble($rsLoans['totalAmountPaid']), 2);
            $totalAmountLeft = $totalLoanAmount - $totalAmountPaid;
        }

        return [
              'totalLoanAmount' => doNumberFormat($totalLoanAmount)
            , 'totalAmountPaid' => doNumberFormat($totalAmountPaid)
            , 'totalAmountLeft' => doNumberFormat($totalAmountLeft)
        ];
    }

    protected static function getDashboardCount($table, $arFields, $groupBy='')
    {
        $arFetchParams = [
             'sum' => $arFields,
             'where' => self::$arWhere
            ,'returnType' => 'row'
            ,'whereNotIn' => ['status' => ['rejected']]
        ];

        if (strlen($groupBy) > 0)
        {
            $arFetchParams['groupBy'] = $groupBy;
        }

        $rs = Crud::select(
            $table, $arFetchParams 
        );

        if ($rs)
        {
            return $rs;
        }

        return [];
    }

    public static function getQueryCondition()
    {
        $arWhere = [
               'parent_id' => self::$userId
            , 'deleted' => 0
        ];

        if (strlen(self::$userId) != 36)
        {
            unset($arWhere['parent_id']);
        }

        self::$arWhere = $arWhere;
    }
}