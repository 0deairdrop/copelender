<?php 
namespace Src\Module\Dashboard;

use Src\Crud\Crud;

class FinancialReportsFunctions
{
    protected static $arLoanStats =  [];
    protected static $totalLoans = 0;
    protected static $totalApproveLoans = 0;
    public static function invokeGetFinancialReportData()
    {
        return [
             'arDashBoardCount' => self::invokeGetFinancialReportDashboardCount()
            , 'arLoanApplications' => self::invokeGetFinancialReportLoansData()
            , 'arLoanStats' => self::invokeGetFinancialReportLoanStatictics()
            , 'arApprovalRate' => self::invokeGetLoanApprovalRateArray()
            , 'arLoanDistribution' => self::invokeGetLoanApprovalRateArray()
        ];
    }

    protected static function invokeGetFinancialReportDashboardCount()
    {
        $totalCustomer = $totalLoans = $loanPortFolio = $totalIntrest = 0;

        $rsCustomer = self::getFinancialReportDashbordCount([
             'table' => DEF_TBL_USR_USERS
            ,'arFields' => ['id' => 'totals']
            ,'arWhere' => ['isadmin' => 0, 'active' => 1]
        ]);
       
        if (count($rsCustomer) > 0)
        {
            $totalCustomer = doTypeCastInt($rsCustomer['totals']);
        }

        $rsLoans = self::getFinancialReportDashbordCount([
             'table' => DEF_TBL_LOAN_APPLICATION
            ,'arFields' => ['id' => 'totals']
            ,'arWhere' => ['approved' => 1, 'deleted' => 0]
            ,'arExtraParams' => ['whereNotIn' => ['status' => ['rejected']]]
        ]);

        if ($rsLoans)
        {
            $totalLoans = doTypeCastInt($rsLoans['totals']);
        }  
        
        $rsxLoans = self::getFinancialReportDashbordCount([
             'table' => DEF_TBL_LOAN_APPLICATION
            ,'arFields' => ['amount' => 'totalAmount', 'interest_amount' => 'totalInterest']
            ,'arWhere' => ['approved' => 1, 'deleted' => 0]
            ,'type' => 'sum'
            ,'arExtraParams' => ['whereNotIn' => ['status' => ['rejected']]]
        ]);

        if ($rsxLoans)
        {
            $loanPortFolio = doTypeCastDouble($rsxLoans['totalAmount']);
            $totalIntrest = doTypeCastDouble($rsxLoans['totalInterest']);
        }
        
        return [
             'totalCustomer' => $totalCustomer 
            , 'totalLoans' => $totalLoans 
            , 'loanPortFolio' => $loanPortFolio
            , 'totalIntrest' => $totalIntrest 
        ];
    } 
    
    protected static function invokeGetLoanApprovalRateArray()
    {
        $loanApprovalRate = $loanRepaymentRate = $totalRepayment = $totalProcessedRepayments = $pendingAccounts = 0;
        if (count(self::$arLoanStats) > 0)
        {
            if (self::$totalLoans > 0)
            {
                $loanApprovalRate = (self::$totalApproveLoans/self::$totalLoans) * 100;
            }

            $rsRepayment = self::getFinancialReportLoanDashbordCount([
                'table' => DEF_TBL_LOAN_APPLICATION_ITEMS
                ,'arFields' => ['id' => 'totals']
                ,'arWhere' => ['deleted' => 0]
                ,'groupBy' => 'status'
            ]);

            if (count($rsRepayment) > 0)
            {   
                $totalRepayment = doTypeCastInt($rsRepayment['paid']) + doTypeCastInt($rsRepayment['pending']);
                $totalProcessedRepayments = doTypeCastInt($rsRepayment['paid']);
                if ($totalRepayment > 0)
                {
                    $loanRepaymentRate = ($totalProcessedRepayments/$totalRepayment ) * 100;
                }
            }

            
            $rsCustomer = self::getFinancialReportDashbordCount([
                'table' => DEF_TBL_USR_USERS
                ,'arFields' => ['id' => 'totals']
                ,'arWhere' => ['isadmin' => 0,  'is_eligible' => 0]
            ]);
        
            if (count($rsCustomer) > 0)
            {
                $pendingAccounts = doTypeCastInt($rsCustomer['totals']);
            }
        }
        return [
              'loanApprovalRate' => $loanApprovalRate
            , 'loanRepaymentRate' => $loanRepaymentRate
            , 'totalLoans' => self::$totalLoans
            , 'totalApprovedLoans' => self::$totalApproveLoans
            , 'totalRepayment' => $totalRepayment
            , 'totalProcessedRepayments' => $totalProcessedRepayments
            , 'pendingAccounts' => $pendingAccounts
        ];
    }
    protected static function invokeGetFinancialReportLoanStatictics()
    {
        $rsLoans = self::getFinancialReportLoanDashbordCount([
             'table' => DEF_TBL_LOAN_APPLICATION
            ,'arFields' => ['id' => 'totals']
            ,'arWhere' => ['deleted' => 0]
            ,'groupBy' => 'status'
        ]);

        $totalApprovedLoans = $totalClosedLoans = $totalPendingLoans = $totalRejectedLoans = 0;
        if (count($rsLoans) > 0)
        {
            self::$totalApproveLoans = $totalApprovedLoans = $rsLoans['approved'] + $rsLoans['completed'] +  $rsLoans['closed'];
            $totalClosedLoans = $rsLoans['closed'];
            $totalPendingLoans = $rsLoans['pending'];
            $totalRejectedLoans = $rsLoans['rejected'];

            self::$totalLoans = self::$totalApproveLoans  +  $totalPendingLoans + $totalRejectedLoans;
        }

        return [
              'totalApprovedLoans' => $totalApprovedLoans
            , 'totalClosedLoans' => $totalClosedLoans
            , 'totalPendingLoans' => $totalPendingLoans
            , 'totalRejectedLoans' => $totalRejectedLoans
        ];
    }

    public static function invokeGetFinancialReportLoansData()
    {   
        $rs = Crud::select(
            DEF_TBL_LOAN_APPLICATION,
            [
                'columns' => ['id', 'parent_id','amount', 'total_amount'
                    , 'duration', 'repayment_type', 'status', 'cdate', 'approved', 'name'
                    , 'expected_closing_date', 'interest_amount', 'approved_date', 'approved_by'
                ],
                'where' => [
                     'approved' => 1
                     , 'deleted' => 0
                ]
            ]
        );
        return $rs;
  
    }

    public static function getFinancialReportDashbordCount($arParams=[])
    {
        $table = $arParams['table'];
        $arFields = $arParams['arFields'] ?? ['id' => 'totals'];
        $arWhere = $arParams['arWhere'] ?? ['deleted' => 0];
        $groupBy = $arParams['groupBy'] ?? '';
        $arExtraParams = $arParams['arExtraParams'] ?? [];
        $type = $arParams['type'] ?? 'count';
    
   
        if (strlen($table) > 0)
        {
            $arFetchParams = [
                $type => $arFields,
                'where' => $arWhere
                ,'returnType' => 'row'
            ];
            
            if (strlen($groupBy) > 0)
            {
                $arFetchParams['groupBy'] = $groupBy;
            }

            if (count($arExtraParams) > 0)
            {
                $arFetchParams = array_merge($arFetchParams, $arExtraParams);
            }

            $rs = Crud::select(
                $table, $arFetchParams 
            );

            if ($rs)
            {
                return $rs;
            }
        }
        return [];
    }
    
    public static function getFinancialReportLoanDashbordCount($arParams=[])
    {
        $ar = [];
        $table = $arParams['table'];
        $arFields = $arParams['arFields'] ?? ['id' => 'totals'];
        $arWhere = $arParams['arWhere'] ?? ['deleted' => 0];
        $groupBy = $arParams['groupBy'] ?? '';
        $arExtraParams = $arParams['arExtraParams'] ?? [];
        $type = $arParams['type'] ?? 'count';
    
   
        if (strlen($table) > 0)
        {
            $arFetchParams = [
                $type => $arFields,
                'columns' => ['status'],
                'where' => $arWhere
            ];
            
            if (strlen($groupBy) > 0)
            {
                $arFetchParams['groupBy'] = $groupBy;
            }

            if (count($arExtraParams) > 0)
            {
                $arFetchParams = array_merge($arFetchParams, $arExtraParams);
            }

            $rs = Crud::select(
                $table, $arFetchParams 
            );

            if (count($rs) > 0)
            {
                foreach ($rs as $r)
                {
                    $ar[$r['status']] = doTypeCastDouble($r['totals']);
                }
                self::$arLoanStats = $ar;
            }
        }
        return $ar;
    }
}