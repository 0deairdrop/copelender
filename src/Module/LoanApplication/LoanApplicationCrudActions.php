<?php 
namespace Src\Module\LoanApplication;

use Src\Crud\Crud;
use Src\Crud\ModuleCrudActions;
use Src\Crud\ModuleCommonFunctions;
use Src\Module\LoanApplication\LoanTransactionsFunctions;

class LoanApplicationCrudActions
{
    protected $table = DEF_TBL_LOAN_APPLICATION;
    protected $tableItems = DEF_TBL_LOAN_APPLICATION_ITEMS;
    protected $cdate;
    protected $cuserId;
    protected $record;
    protected $moduleId;
    protected $action;
    protected $objHistory;
    protected $productId;
    protected $arPostData = [];
    protected $data = [];
    public $dataJson = [];
    protected $decimalPlace = 2;
    protected $amount = 0;
    protected $repaymentType = '';
    protected $duration = 0;

    public function __construct($arParams=[])
    {
        $this->action = $arParams['action'];
        $this->arPostData = invokeGetValueFromRequest($arParams, 'postData', []);
        $this->record = invokeGetValueFromRequest($arParams, 'record');
        $this->moduleId = invokeGetValueFromRequest($this->arPostData, 'moduleId');
        $this->cdate = getCurrentDate();
        $this->cuserId = getLoggedInUserDetailsByKey(); 

        if (in_array($this->action, ['makePayment', 'sendEmailReminder']))
        {
            $this->table = $this->tableItems;
        }

        // validate transaction before proceding (check if record exists)
        ModuleCrudActions::invokeProcessValidateModuleTransaction([
             'table' => $this->table
            ,'record' => $this->record
            ,'action' => $this->action
            ,'moduleId' => $this->moduleId
            ,'userId' => $this->cuserId
        ]);
    }

    /**
     * customer applies
     * customer choose repayment type (monthly or weekly)
     * customer choses  duration
     * apply for 
     * @return void
     */
    public function doInvokeAction()
    {
        switch($this->action)
        {
            case 'save':
                $this->recordValidateData();
                if (strlen($this->record) == 36)
                {
                    $this->invokeRecordUpdate();
                }
                else
                {
                    $this->invokeRecordInsert();
                }
                break; 

            case 'delete':
                $this->invokeRecordDelete();
                break;

            case 'cancel':
                $this->doCancelLoan();
                break;

            case 'reject':
                $this->doRejectLoan();
                break;

            case 'approve':
                $this->doLoanApprovalProcess();
                break;

            case 'close':
                $this->invokeProcessCloseLoan();
                break;

            case 'calculateIntrest':
                $this->doLoanInstrestCalculation();
                break;   
                
            case 'makePayment':
                $this->doProcessLoanRepayment();
                break;  
                
            case 'payAmtDue':
                $this->doProcessFullLoanRepayment();
                break; 

            case 'sendEmailReminder':
                $this->doSendEmailReminder();
                break;

            default:
                ModuleCommonFunctions::invokeThrowException('Unknown Action');
                break;
        }
    }

  
    protected function recordValidateData()
    {
        $name = invokeGetValueFromRequest($this->arPostData, 'name');
        $this->amount = doTypeCastDouble(invokeGetValueFromRequest($this->arPostData, 'amount'));
        $this->repaymentType = invokeGetValueFromRequest($this->arPostData, 'repaymentType');
        $this->duration = doTypeCastInt(invokeGetValueFromRequest($this->arPostData, 'duration'));
        $purpose = invokeGetValueFromRequest($this->arPostData, 'purpose');
        $terms = doTypeCastInt(invokeGetValueFromRequest($this->arPostData, 'terms', 1)); // set back to 0

        $this->data = [
              'name' => $name
            , 'amount' => $this->amount
            , 'repayment_type' => $this->repaymentType
            , 'duration' => $this->duration
            , 'purpose' => $purpose
        ];

        ModuleCommonFunctions::doCommonModuleDataValidation([
             'data' => $this->data
           , 'moduleId' => $this->moduleId
           , 'record' => $this->record
           , 'table' => $this->table
           , 'field' => 'name'
           , 'checkDuplicate' => true
           , 'arWhere' => ['name' => $name, 'parent_id' => $this->cuserId]
        ]);
        // validation
        $this->doCommonLoanApplicationValidation();

        if ($terms != 1)
        {
            ModuleCommonFunctions::invokeThrowException('Please accept our terms and conditions');
        }  
    }


    protected function doLoanInstrestCalculation()
    {
        $amount = invokeGetValueFromRequest($this->arPostData, 'amount');
        $duration = doTypeCastInt(invokeGetValueFromRequest($this->arPostData, 'duration'));
        $repaymentType = invokeGetValueFromRequest($this->arPostData, 'repaymentType');
        $this->doCommonLoanApplicationValidation();
        $insterest = LoanApplicationFunctions::invokeInterestCalculation($amount, $duration, $repaymentType);
        $this->dataJson['total'] = doTypeCastDouble($insterest + $amount);
    }

    private function doCommonLoanApplicationValidation()
    {
        $amount = invokeGetValueFromRequest($this->arPostData, 'amount');
        $duration = doTypeCastInt(invokeGetValueFromRequest($this->arPostData, 'duration'));
        $repaymentType = invokeGetValueFromRequest($this->arPostData, 'repaymentType');

        if (doTypeCastDouble($amount) > 0)
        {
            $highestAmount = LoanApplicationFunctions::getLoanableHighestAmount();
            if ($amount > $highestAmount)
            {
                ModuleCommonFunctions::invokeThrowException('Amount Must be lesser than or equal to ' . $highestAmount);
            }
            elseif (!in_array($duration, [1,3,6,12]))
            {
                ModuleCommonFunctions::invokeThrowException('Invalid Duration');
            }
            elseif (!in_array($repaymentType, ['monthly', 'weekly']))
            {
                ModuleCommonFunctions::invokeThrowException('Invalid Repayment Type');
            }
        }
        else
        {
            ModuleCommonFunctions::invokeThrowException('Amount must be greater than 0');
        }
    }

    protected function invokeRecordInsert()
    {
        $this->invokeGetLoanDbFieldsValues();
        
        $data = $this->data;
        $id = generateNewId(); // generate 36 character id
        $data['parent_id'] = $this->cuserId;
        $data['cuser'] = $this->cuserId;
        $data['cdate'] = $this->cdate;
        $this->data['id'] = $data['id'] = $id;

        // insert data
        Crud::insert(
            $this->table, $data
        );

        $this->dataJson = 'Record Inserted';
    } 

    private function invokeGetLoanDbFieldsValues()
    {
        $interestAmt = LoanApplicationFunctions::invokeInterestCalculation(
            $this->amount, $this->duration, $this->repaymentType
        );

        $totalAmount = doTypeCastDouble($interestAmt + $this->amount);
        $recurringAmount = LoanApplicationFunctions::doCalculateRecurringAmount($totalAmount, $this->duration);
        $this->data['interest_amount'] = $interestAmt;
        $this->data['intrest_rate'] = LoanApplicationFunctions::$insterestRate;
        $this->data['total_amount'] = $totalAmount;
        $this->data['recurring_amount'] = round($recurringAmount, $this->decimalPlace);
    }

    protected function invokeRecordUpdate()
    {
        $this->invokeGetLoanDbFieldsValues();
        $data = $this->data;
        $data['muser'] = $this->cuserId;
        $data['mdate'] = $this->cdate;
         // insert data
        Crud::update(
            $this->table, $data, ['id' => $this->record]
        );

        $this->dataJson = 'Record Updated';
    }
    
    protected function invokeRecordDelete()
    {
        $rs = LoanApplicationFunctions::getLoanInfo($this->record, ['status','approved']);
        if ($rs)
        {
            if (doTypeCastInt($rs['approved']) == 1)
            {
                ModuleCommonFunctions::invokeThrowException('Loan Already Approved, Cannot be delete, Please cancel instead');
            }
            else
            {
                Crud::update(
                    $this->table,
                    ['deleted' => 1],
                    ['id' => $this->record]
                );

                $this->dataJson = 'Record Deleted';
            }
        }
        else
        {
            ModuleCommonFunctions::invokeThrowException('Record not found');
        }
    }

    /**
     * Summary of doLoanApprovalProcess
     * check if record is not previously approved
     * validate duration 
     * calculate all expected payments dates
     * push into itmes table wiht thier respective payment dates
     * update loans main table
     * @return void
     */
    private function doLoanApprovalProcess()
    {
        $rs = LoanApplicationFunctions::getLoanInfo(
            $this->record
            , ['id', 'recurring_amount', 'status', 'approved', 'duration', 'repayment_type', 'amount', 'parent_id']
        );

        if ($rs)
        {
            if (doTypeCastInt($rs['approved']) == 0 || $rs['status'] != 'approved')
            {
                $duration = doTypeCastInt($rs['duration']);
                $repaymentType = $rs['repayment_type'];
                $amount = doTypeCastDouble($rs['recurring_amount']);

                if (in_array($duration, [1,3,6,12]))
                {
                    $arLoanRepayment = LoanApplicationFunctions::getArLoanRepaymentDates($repaymentType, $duration);
                    $numEntries = count($arLoanRepayment);

                    for ($i=0; $i<$numEntries; $i++)
                    {
                        $data = [
                             'id' => generateNewId()
                            ,'parent_id' => $this->record
                            ,'amount' => $amount
                            ,'payment_due_date' => $arLoanRepayment[$i]
                            ,'cdate' => $this->cdate
                            ,'cuser' => $this->cuserId
                            ,'rank' => $i + 1
                        ];
             
                        Crud::insert(
                            $this->tableItems, $data
                        );
                    }

                    // update loan application table
                    $dataLoans = [
                          'status' => 'approved'
                        , 'approved' => 1
                        , 'approved_by' => $this->cuserId
                        , 'approved_date' => $this->cdate
                        , 'expected_closing_date' => $arLoanRepayment[$numEntries-1]
                        , 'mdate' => $this->cuserId
                        , 'muser' => $this->cdate
                    ];

                    Crud::update(
                        $this->table,
                        $dataLoans,
                        ['id' => $this->record]
                    );

                    // log into  transactions table
                    LoanTransactionsFunctions::$moduleId = $this->moduleId;
                    LoanTransactionsFunctions::$cdate = $this->cdate;
                    LoanTransactionsFunctions::$cuserId = $this->cuserId;
                    LoanTransactionsFunctions::invokeLogLoanDisbursement([
                         'amount' => $rs['amount']
                       , 'parent_id' => $rs['parent_id']
                       , 'id' => $rs['id']
                    ]);

                    LoanApplicationFunctions::invokeSendLoanActionEmail(
                        'approved', $this->record
                    );
                    $this->dataJson = 'Loan Approved Sucessfully';
                }
                else
                {
                    ModuleCommonFunctions::invokeThrowException('Unable to proceed: Invalid Duration');
                }
            }
            else
            {
                ModuleCommonFunctions::invokeThrowException('Unable to proceed: Loan Already approved');
            }
        }
        else
        {
            ModuleCommonFunctions::invokeThrowException('Record not found');
        }
    }
    /**
     * check if record is not approved
     * if not then reject i it
     * @return void
     */
    private function doRejectLoan()
    {
        $rs = LoanApplicationFunctions::getLoanInfo(
            $this->record, ['approved']
        );

        if ($rs)
        {
            if (doTypeCastInt($rs['approved']) != 1)
            {
                $dataLoans = [
                      'status' => 'rejected'
                    , 'approved' => 3
                    , 'reject_reason' => 'Rejected by admin'
                    , 'mdate' => $this->cuserId
                    , 'muser' => $this->cdate
                ];

                Crud::update(
                    $this->table,
                    $dataLoans,
                    ['id' => $this->record]
                );

                LoanApplicationFunctions::invokeSendLoanActionEmail(
                    'rejected', $this->record
                );

                $this->dataJson = 'Loan Rejected Sucesfully';
            }
            else
            {
                ModuleCommonFunctions::invokeThrowException('Unable to proceed: Loan Already approved');
            }
        }
        else
        {
            ModuleCommonFunctions::invokeThrowException('Record not found');
        }
    }

    /**
     * mark status as closed
     * check if user is admin (only admin can close loan)
     * check if loan has been fully paid
     * close loan
     * @return void
     */
    private function invokeProcessCloseLoan()
    {
        $isAdmin = doTypeCastInt(getLoggedInUserDetailsByKey('isadmin'));
        if (!$isAdmin)
        {
            ModuleCommonFunctions::invokeThrowException('Please visit the branch to cancel');
        }
        else
        {
            $rs = LoanApplicationFunctions::getLoanInfo(
                $this->record, ['status']
            );

            if ($rs['status'] == 'completed')
            {
                $dataLoans = [
                      'status' => 'closed'
                    , 'mdate' => $this->cuserId
                    , 'muser' => $this->cdate
                ];

                Crud::update(
                    $this->table,
                    $dataLoans,
                    ['id' => $this->record]
                );

                LoanApplicationFunctions::invokeSendLoanActionEmail(
                    'closed', $this->record
                );

                $this->dataJson = 'Loan Closed Sucesfully';
            }
            else
            {
                ModuleCommonFunctions::invokeThrowException('Unable to close Loan: Please pay all outstanding amount');
            }
        }
    }

    /**
     * pay all outstanding 
     * update items table
     * update loans table
     * @return void
     */
    private function doProcessFullLoanRepayment()
    {
        $rs = LoanApplicationFunctions::getLoanInfo(
            $this->record, ['status']
        );

        if ($rs['status'] != 'completed')
        {
            LoanTransactionsFunctions::$record = $this->record;
            LoanTransactionsFunctions::$moduleId = $this->moduleId;
            LoanTransactionsFunctions::$cuserId = $this->cuserId;
            LoanTransactionsFunctions::$cdate = $this->cdate;
            LoanTransactionsFunctions::invokeLogLoanFullLoanRepaymentTransactions();

            $dataLoans = [
                  'status' => 'completed'
                , 'mdate' => $this->cuserId
                , 'muser' => $this->cdate
            ];

            Crud::update(
                $this->table,
                $dataLoans,
                ['id' => $this->record]
            );

            LoanApplicationFunctions::invokeSendLoanActionEmail(
                'completed', $this->record
            );

            $this->dataJson = 'Loan Repayment Succesfully';
        }
        else
        {
            ModuleCommonFunctions::invokeThrowException('Outstanding Amount Already Paid');
        }
       
    }

    /**
     * cancel loan (customer)
     * check if loan is not approved
     * push approved as 4
     */
    private function doCancelLoan()
    {
        $rs = LoanApplicationFunctions::getLoanInfo(
            $this->record, ['approved']
        );

        if ($rs)
        {
            if (doTypeCastInt($rs['approved']) != 1)
            {
                $dataLoans = [
                      'status' => 'cancelled'
                    , 'approved' => 4
                    , 'mdate' => $this->cuserId
                    , 'muser' => $this->cdate
                ];

                Crud::update(
                    $this->table,
                    $dataLoans,
                    ['id' => $this->record]
                );

                LoanApplicationFunctions::invokeSendLoanActionEmail(
                    'cancelled', $this->record
                );

                $this->dataJson = 'Loan Cancelled Sucesfully';
            }
            else
            {
                ModuleCommonFunctions::invokeThrowException('Unable to proceed: Loan Already approved');
            }
        }
        else
        {
            ModuleCommonFunctions::invokeThrowException('Record not found');
        }
    } 

    /**
     * Pay single loan item
     * @return void
     */
    private function doProcessLoanRepayment()
    {
        LoanApplicationFunctions::invokeProcessProcessLoanRecurringPayment([
             'record' => $this->record
            , 'cdate' => $this->cdate
            , 'cuser' => $this->cuserId
        ]);
        
        $this->dataJson = 'Payment Sucessfull';
    }
    
    /**
     * send email reminder
     * @return void
     */
    private function doSendEmailReminder()
    {
        LoanApplicationFunctions::doSendSingleEmailReminder($this->record);
        $this->dataJson = 'Email Sent Sucessfully';
    }
}