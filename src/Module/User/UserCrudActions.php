<?php 
namespace Src\Module\User;

use Src\Crud\Crud;
use Src\Crud\ModuleCrudActions;
use Src\Crud\ModuleCommonFunctions;


class UserCrudActions
{
    protected $table = DEF_TBL_USR_USERS;
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

    public function __construct($arParams=[])
    {
        $this->action = $arParams['action'];
        $this->arPostData = invokeGetValueFromRequest($arParams, 'postData', []);
        $this->record = invokeGetValueFromRequest($arParams, 'record');
        $this->moduleId = invokeGetValueFromRequest($this->arPostData, 'moduleId');
        $this->cdate = getCurrentDate();
        $this->cuserId = getLoggedInUserDetailsByKey(); 

        // validate transaction before proceding (check if record exists)
        ModuleCrudActions::invokeProcessValidateModuleTransaction([
             'table' => $this->table
            ,'record' => $this->record
            ,'action' => $this->action
            ,'moduleId' => $this->moduleId
            ,'userId' => $this->cuserId
        ]);
    }

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
                
            case 'activate':
                $this->invokeActivateUserAccount();
                break;  

            case 'deactivate':
                $this->invokeDeActivateUserAccount();
                break;  

            case 'makeadmin':
                $this->invokeUpgradeToAdmin();
                break;


            default:
                ModuleCommonFunctions::invokeThrowException('Unknown Action');
                break;
        }
    }

    private function recordValidateData()
    {
        $firstname = invokeGetValueFromRequest($this->arPostData, 'firstname');
        $lastname = invokeGetValueFromRequest($this->arPostData, 'lastname');
        $phoneNnumber = invokeGetValueFromRequest($this->arPostData, 'phone_number');
        $dob = invokeGetValueFromRequest($this->arPostData, 'dob');
        $occupation = invokeGetValueFromRequest($this->arPostData, 'occupation');
        $montlyIncome = invokeGetValueFromRequest($this->arPostData, 'montly_income'); 
        $bankName = invokeGetValueFromRequest($this->arPostData, 'bank_name'); 
        $bankAccountHolderName = invokeGetValueFromRequest($this->arPostData, 'bank_account_holder_name'); 
        $accountNumber = invokeGetValueFromRequest($this->arPostData, 'account_number'); 
        $nationalId = invokeGetValueFromRequest($this->arPostData, 'national_id'); 
        $identification = invokeGetValueFromRequest($this->arPostData, 'identification'); 
        $street = invokeGetValueFromRequest($this->arPostData, 'street'); 
        $city = invokeGetValueFromRequest($this->arPostData, 'city'); 
        $state = invokeGetValueFromRequest($this->arPostData, 'state'); 
        $postalCode = invokeGetValueFromRequest($this->arPostData, 'postal'); 
        $country = invokeGetValueFromRequest($this->arPostData, 'country'); 

        $this->data = [
              'firstname' => $firstname 
            , 'lastname' => $lastname 
            , 'phone_number' => $phoneNnumber
            , 'dob' => $dob
            , 'occupation' => $occupation
            , 'montly_income' => $montlyIncome
            , 'bank_name' => $bankName
            , 'bank_account_holder_name' => $bankAccountHolderName
            , 'account_number' => $accountNumber
            , 'national_id' => $nationalId
            , 'identification' => $identification
            , 'address' => $street
            , 'city' => $city
            , 'state' => $state
            , 'postal' => $postalCode
            , 'country' => $country
        ];

        ModuleCommonFunctions::doCommonModuleDataValidation([
             'data' => $this->data
           , 'moduleId' => $this->moduleId
           , 'record' => $this->record
           , 'table' => $this->table
           , 'field' => 'name'
           , 'checkDuplicate' => false
        ]);
    } 
    
    private function invokeRecordInsert()
    {
        $id = generateNewId();
        $reference = generateUseReference($this->data['username']); // generate user id
        $data = $this->data;
        $data['reference'] = $reference;
        $data['id'] = $id;
        $data['cuser'] = $id;
        $data['cdate'] = $this->cdate;
        $data['active'] = 1;
        $data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);

        // insert data
        Crud::insert(
            $this->table, $data
        );
         $this->dataJson = 'User Added';
    }
    
    private function invokeRecordUpdate()
    {
        $data = $this->data;
        $data['muser'] = $this->cuserId;
        $data['mdate'] = $this->cdate;

         // update data
        Crud::update(
            $this->table, $data, ['id' => $this->record]
        );

        $this->dataJson = 'Record Updated';
    }  
    private function invokeActivateUserAccount()
    {
        $rs = UserFunctions::getUserInfo($this->record, [
             'national_id'
            , 'address'
            , 'montly_income'
            , 'occupation'
            , 'bank_name'
            , 'bank_account_holder_name'
            , 'account_number'
            , 'identification'
            , 'city'
            , 'state'
            , 'postal'
            , 'dob'
            , 'active'
        ]);

        if (count($rs) > 0)
        {
            foreach ($rs as $field => $value)
            {
                if ($value == NULL || strlen($value) == 0)
                {
                    ModuleCommonFunctions::invokeThrowException('Unable to activate account, profile information incomplete');
                }
            }
        }

        $data = [
            'is_eligible' => 1
            , 'muser' => $this->cuserId
            , 'mdate' => $this->cdate
        ];

        if (!doTypeCastInt($rs['active']))
        {
            $data['active'] = 1;
        }

        // update data
        Crud::update(
            $this->table, $data, ['id' => $this->record]
        );

        $this->dataJson = 'Account Activated';
    }  
    private function invokeDeActivateUserAccount()
    {
    
        $data = [
            'is_eligible' => 0
            , 'muser' => $this->cuserId
            , 'mdate' => $this->cdate
        ];

        // update data
        Crud::update(
            $this->table, $data, ['id' => $this->record]
        );

        $this->dataJson = 'Account Deactivated';
    }  
    private function invokeUpgradeToAdmin()
    {
        $data = [
             'isadmin' => 0
            , 'muser' => $this->cuserId
            , 'mdate' => $this->cdate
        ];

        // update data
        Crud::update(
            $this->table, $data, ['id' => $this->record]
        );

        $this->dataJson = 'Account Updated';
    }  
    
    private function invokeRecordDelete()
    {
        
    }
}