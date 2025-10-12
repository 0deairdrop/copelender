<?php 
namespace Src\Module\LoanApplication;

use Src\Crud\Crud;

class LoanTransactionsFunctions
{    
    public static $record;
    public static $moduleId = DEF_MODULE_ID_LOAN;
    public static $cuserId;
    public static $cdate;
    public static $reference;
    public static $status  = 'paid';
    protected static $table = DEF_TBL_TRANSACTIONS;
    protected static $tableLoanItems = DEF_TBL_LOAN_APPLICATION_ITEMS;

    public static function invokeLogLoanFullLoanRepaymentTransactions()
    {
        $rs = Crud::select(
            self::$tableLoanItems,
            [
                'columns' => ['id', 'amount'],
                'where' => [
                    'parent_id' => self::$record
                ]
            ]
        );

        if (count($rs) > 0)
        {
            foreach($rs as $r)
            {
                $id = $r['id'];
                $amount = doTypeCastDouble($r['amount']);
              
                $data = [
                      'id' => generateNewId()
                    , 'parent_id' => self::$record
                    , 'record_item_id' => $id
                    , 'amount' => $amount
                    , 'module_id' => self::$moduleId
                    , 'status' => self::$status
                    , 'tdate' => self::$cdate
                    , 'cdate' => self::$cdate
                    , 'cuser' => self::$cuserId
                    , 'user_id' => self::$cuserId
                    , 'reference' => generatePaymentReference()
                ];
               
                Crud::insert(
                    self::$table, $data
                );

                $dataItems = [
                      'status' => self::$status
                    , 'tdate' => self::$cdate
                    , 'mdate' => self::$cdate
                    , 'muser' => self::$cuserId
                ];
  
                Crud::update(
                    self::$tableLoanItems, $dataItems, ['id' => $id]
                );

                // update total amount paid
                LoanApplicationFunctions::invokeUpdateTotalLoanAmountPaid(
                    self::$record
                );
            }
        }
    }

    public static function invokeLogLoanRepayment($rs=[])
    {
        if (count($rs) > 0)
        {
            $id = $rs['id'];
            $amount = doTypeCastDouble($rs['amount']);
            self::$reference = generatePaymentReference();
            $data = [
                    'id' => generateNewId()
                , 'parent_id' => self::$record
                , 'record_item_id' => $id
                , 'amount' => $amount
                , 'module_id' => self::$moduleId
                , 'status' => self::$status
                , 'tdate' => self::$cdate
                , 'cdate' => self::$cdate
                , 'cuser' => self::$cuserId
                , 'user_id' => self::$cuserId
                , 'reference' => self::$reference
            ];

            Crud::insert(
                self::$table, $data
            );

            $dataItems = [
                    'status' => self::$status
                , 'tdate' => self::$cdate
                , 'mdate' => self::$cdate
                , 'muser' => self::$cuserId
            ];

            Crud::update(
                self::$tableLoanItems, $dataItems, ['id' => $id]
            );

            // update total amount paid
            LoanApplicationFunctions::invokeUpdateTotalLoanAmountPaid(
                self::$record
            );
        }
    }    
    
    public static function invokeLogLoanDisbursement($rs=[])
    {
        if (count($rs) > 0)
        {
            $amount = doTypeCastDouble($rs['amount']);
            $data = [
                    'id' => generateNewId()
                , 'parent_id' => $rs['id'] // loan id
                , 'record_item_id' => null
                , 'amount' => $amount // amount
                , 'module_id' => self::$moduleId // module id
                , 'status' => 'paid'
                , 'tdate' => self::$cdate
                , 'cdate' => self::$cdate
                , 'cuser' => self::$cuserId
                , 'user_id' => $rs['parent_id']
                , 'debit_credit' => 1
                , 'reference' =>  generatePaymentReference()
            ];

            Crud::insert(
                self::$table, $data
            );
        }
    }
}