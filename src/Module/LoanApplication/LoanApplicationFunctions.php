<?php 
namespace Src\Module\LoanApplication;

use DateTime;
use Src\Crud\Crud;
use Src\Module\SendMail\Mailer;
use Src\Module\User\UserFunctions;
use Src\Crud\ModuleCommonFunctions;
use Src\EmailTemplates\EmailTemplatesFunctions;
use Src\Module\LoanApplication\LoanTransactionsFunctions;

class LoanApplicationFunctions
{
    protected static $table = DEF_TBL_LOAN_APPLICATION;
    protected static $tableItems = DEF_TBL_LOAN_APPLICATION_ITEMS;
    protected static $tableTransactions = DEF_TBL_TRANSACTIONS;
    public static $insterestRate = 2.5;
    public static $cdate;
    public static $cuserId;

    public static function invokeInterestCalculation($amount, $duration, $type)
    {
        self::$insterestRate = self::getLoanIntrest($duration, $type);

        return doTypeCastDouble($amount * self::$insterestRate/100);
    }

    public static function getLoanIntrest($duration, $type)
    {
        $instrestRate = 2.5;
        switch ($type)
        {
            case 'monthly':
                switch ($duration)
                {
                    case 1;
                        $instrestRate = 2;
                        break;      
                    case 3;
                        $instrestRate = 2.5;
                        break;  
                    case 6;
                        $instrestRate = 3;
                        break; 
                    case 12;
                        $instrestRate = 3.5;
                        break; 
                }
                break;

            case 'weekly':
                switch ($duration)
                {
                    case 1;
                        $instrestRate = 1.5;
                        break;      
                    case 3;
                        $instrestRate = 2;
                        break;  
                    case 6;
                        $instrestRate = 2.5;
                        break; 
                    case 12;
                        $instrestRate = 3;
                        break; 
                }
                break;
        }

        return $instrestRate;
    }

    public static function getLoanableHighestAmount()
    {
        return 5000000;
    }

    public static function doCalculateRecurringAmount($amount, $duration)
    {
        return $amount/$duration;
    }

    public static function invokeGetUserLoans()
    {
        $userId = getLoggedInUserDetailsByKey();
   
        if (strlen($userId) == 36)
        {
            $rs = Crud::select(
                self::$table,
                [
                    'columns' => ['id', 'name', 'amount', 'total_amount', 'duration', 'repayment_type', 'status', 'cdate', 'approved', 'purpose'],
                    'where' => [
                          'parent_id' => $userId 
                        , 'deleted' => 0
                    ]
                ]
            );
            return $rs;
        }
        return [];
    }
    public static function invokeGetAllLoans()
    {   
       
        $rs = Crud::select(
            self::$table,
            [
                'columns' => ['id', 'parent_id','amount', 'total_amount', 'duration', 'repayment_type', 'status', 'cdate', 'approved', 'name'],
                'where' => [
                     'deleted' => 0
                ]
            ]
        );
        return $rs;
  
    }

    public static function getLoanInfo($record, $arFields=['*'])
    {
        if (strlen($record) == 36)
        {
            $rs = Crud::select(
                self::$table,
                [
                    'columns' => $arFields,
                    'where' => [
                        'id' => $record
                    ]
                    ,'returnType' => 'row'
                ]
            );
            
            if ($rs)
            {
                return $rs;
            }
        }
        return [];
    }

    public static function getArLoanRepaymentDates($type, $duration)
    {
        $ar = [];

        $startDate = new DateTime(getCurrentDate());
        $interval = ($type === 'monthly') ? '1 month' : '7 days';

        // First payment (starting date)
        $ar[] = $startDate->format('Y-m-d');
        // Generate subsequent repayment dates
        for ($i = 1; $i < $duration; $i++) 
        {
            $startDate = (clone $startDate)->modify($interval);
            $ar[] = $startDate->format('Y-m-d');
        }

        return $ar;
    }

    /**
     * send confirmation email
     * @param mixed $action
     * @param mixed $record
     * @return void
     */
    public static function invokeSendLoanActionEmail($action='approve', $record)
    {
        if (strlen($record) == 36)
        {
            $rs = self::getLoanInfo(
                $record, ['parent_id', 'name', 'total_amount']
            );

            switch ($action)
            {
                case 'approve':
                    $action = 'approved';
                    break;
            }

            $loanTitle = $rs['name'];
            $totalAmount = doTypeCastDouble($rs['total_amount']);

            if (count($rs) > 0)
            {

                self::doSendCommonLoanEmail([
                      'userId' => $rs['parent_id']
                    , 'loanTitle' => $loanTitle
                    , 'totalAmount' => $totalAmount
                    , 'action' => $action
                ]);
            }
        }
    }

    public static function invokeUpdateTotalLoanAmountPaid($record)
    {
        if (strlen($record) == 36)
        {
            $rs = Crud::select(
            self::$tableTransactions,
                [
                    'sum' => ['amount' => 'totalAmount'],
                    'where' => [
                        'parent_id' => $record
                        , 'deleted' => 0
                    ]
                    ,'returnType' => 'row'
                ]
            );

            if ($rs)
            {
                $totalAmount = doTypeCastDouble($rs['totalAmount']);

                Crud::update(
                    self::$table
                    , ['total_amount_paid' => $totalAmount]
                    , ['id' => $record]
                );   
            }
        }
    }

    public static function invokeGetLoanItems($record)
    {
        $rs = Crud::select(
        self::$tableItems,
            [
                'columns' => ['*'],
                'where' => [
                    'parent_id' => $record
                    , 'deleted' => 0
                ]
                ,'order' => 'rank',
            ]
        );

        return $rs;
    }

    public static function invokeProcessProcessLoanRecurringPayment($arParams= [])
    {
        $record = invokeGetValueFromRequest($arParams, 'record');
        $type = invokeGetValueFromRequest($arParams, 'type', 'normal');
        self::$cdate = invokeGetValueFromRequest($arParams, 'cdate',  getCurrentDate());
        self::$cuserId = invokeGetValueFromRequest($arParams, 'cuser',  getLoggedInUserDetailsByKey());
     
        $rs = Crud::select(
            self::$tableItems,
            [
                'columns' => ['id', 'amount', 'status', 'tdate', 'parent_id'],
                'where' => [
                    'id' => $record
                ]
                ,'returnType' => 'row'
            ]
        );

        if ($rs)
        {
            if ($rs['status'] != 'paid' && empty($rs['tdate']))
            {
                LoanTransactionsFunctions::$record = $rs['parent_id'];
                LoanTransactionsFunctions::$cdate = self::$cdate;
                LoanTransactionsFunctions::$cuserId = self::$cuserId;
                LoanTransactionsFunctions::invokeLogLoanRepayment($rs);
                $reference = LoanTransactionsFunctions::$reference;

                /**
                 * send payment email
                 * check if it's the last payment and close loan
                 */
                
                self::invokeLoanRecurringPaymentTransactionCallBack([
                      'loanId' => $rs['parent_id']
                    , 'paymentReference' => $reference
                    , 'tdate' => self::$cdate
                    , 'amount' => doTypeCastInt($rs['amount'])
                ]);
            }
            else
            {
                if ($type == 'normal')
                {
                    ModuleCommonFunctions::invokeThrowException('Record not found');
                }
            }
        }
    }

    /**
     * Summary of invokeLoanRecurringPaymentTransactionCallBack
     * @param mixed $arParams
     * @return void
     */
    public static function invokeLoanRecurringPaymentTransactionCallBack($arParams=[])
    {
        $record = invokeGetValueFromRequest($arParams, 'loanId');
        $paymentReference = invokeGetValueFromRequest($arParams, 'paymentReference');
        $tdate = invokeGetValueFromRequest($arParams, 'tdate',  getCurrentDate());
        $amount = invokeGetValueFromRequest($arParams, 'amount', 0);

        if (strlen($record) == 36)
        {
            $rs = self::getLoanInfo(
                $record, ['status', 'total_amount', 'total_amount_paid', 'parent_id', 'name', 'id']
            );

            if (count($rs) > 0)
            {
                self::invokeValidateLoanFullPaymentAndClosed($rs);

                self::doSendCommonLoanEmail([
                      'userId' => $rs['parent_id']
                    , 'loanTitle' => $rs['name']
                    , 'tdate' => $tdate
                    , 'totalAmount' => $amount
                    , 'reference' => $paymentReference
                    , 'type' => 'payment'
                    , 'action' => 'Sucessfull'
                    , 'title' => 'Loan Payment'
                ]);
            }
        }
    }

    /**
     * check if loan has been fully paid after last item payment
     * @param mixed $rs
     * @return void
     */
    public static function invokeValidateLoanFullPaymentAndClosed($rs)
    {
        if (count($rs) > 0)
        {
            $totalAmount = doTypeCastDouble($rs['total_amount']);
            $totalAmountPaid = doTypeCastDouble($rs['total_amount_paid']);

            if (round($totalAmountPaid, 2) >= round($totalAmount, 2))
            {
                $dataLoans = [
                      'status' => 'closed'
                    , 'mdate' => self::$cuserId
                    , 'muser' => self::$cdate
                ];

                Crud::update(
                    self::$table,
                    $dataLoans,
                    ['id' => $rs['id']]
                );

                /**
                 * send closing email
                 */
                self::invokeSendLoanActionEmail(
                    'close', $rs['id']
                );
            }
        }
    }

    /**
     * send Loan email
     * @param mixed $arParams
     * @return void
     */
    public static function doSendCommonLoanEmail($arParams=[])
    {
        $userId = invokeGetValueFromRequest($arParams, 'userId');
        $totalAmount = invokeGetValueFromRequest($arParams, 'totalAmount');
        $loanTitle = invokeGetValueFromRequest($arParams, 'loanTitle');
        $action = invokeGetValueFromRequest($arParams, 'action');
        $type = invokeGetValueFromRequest($arParams, 'type', 'loan');
        $tdate = invokeGetValueFromRequest($arParams, 'tdate');
        $reference = invokeGetValueFromRequest($arParams, 'reference');
        $title = invokeGetValueFromRequest($arParams, 'title', 'Loan has been');

        if (strlen($userId) == 36)
        {
            $rsx = UserFunctions::getUserInfo(
                $userId, ['username', 'email']
            );

            if ($rsx)
            {
                $email = $rsx['email'];
                $name = $rsx['username'];
                if (strlen($email) > 0)
                {
                    $body = EmailTemplatesFunctions::getModuleEmailTemplate([
                           'name' => $name
                        , 'amount' => $totalAmount 
                        , 'status' => $action
                        , 'type' => $type
                        , 'reference' => $reference
                        , 'date' => $tdate
                        , 'loanTitle' => $loanTitle
                    ]);

                    $arEmail = [
                         'recipientEmail' => trim($email)
                        , 'recipientName' => $email
                        , 'subject' => APP_NAME. '- ['.  $loanTitle .'] '.  $title . ' '.strtoupper($action)
                        , 'body' => $body
                    ]; 

                    // send email 
                    $mailer = new Mailer();
                    $mailer->invokeProcessSendMail($arEmail);
                }  
            }
        }
    }

    public static function doSendSingleEmailReminder($record)
    {
        if (strlen($record) == 36)
        {
            $rs = self::getLoanItemInfo(
                $record, ['parent_id', 'amount', 'payment_due_date']
            );

            if (count($rs) > 0)
            {
                $rsx = self::getLoanInfo($rs['parent_id'], ['name', 'parent_id']);

                if ($rsx)
                {
                    self::doSendCommonLoanEmail([
                          'userId' => $rsx['parent_id']
                        , 'loanTitle' => $rsx['name']
                        , 'tdate' => $rs['payment_due_date']
                        , 'totalAmount' => doTypeCastDouble($rs['amount'])
                        , 'type' => 'paymentreminder'
                        , 'action' => ''
                        , 'title' => 'Payment Reminder'
                    ]);
                }
            }
        }
    }

    public static function getLoanItemInfo($record, $arFields = ['*'])
    {
        $rs = Crud::select(
            self::$tableItems,
                [
                    'columns' => $arFields,
                    'where' => [
                        'id' => $record
                        , 'deleted' => 0
                    ]
                    ,'returnType' => 'row'
                ]
        );

        if ($rs)
        {
            return $rs;
        }

        return [];
    }
    
    public static function invokeSendRecurringPaymentReminder($ar=[])
    {

    }
}