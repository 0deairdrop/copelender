<?php
namespace Src\Module\Auth;

use Exception;
use Src\Crud\Crud;
use Src\Module\Param\Param;
use Src\Module\SendMail\Mailer;
use Src\Module\Users\UserFunctions;

class ForgotPassword
{
    protected $table = DEF_TBL_USR_PASSWORD_RESET;
    protected $cdate;
    protected $action;
    protected $moduleId;
    protected $email;
    protected $arPostData = [];
    protected $data = [];
    public $dataJson = [];
    protected $arUserData = [];

    public function __construct($arParams=[])
    {
        $this->action = $arParams['action'];
        $this->arPostData = $arParams['postData'];
        $this->cdate = getCurrentDate();
        $this->moduleId = $arParams['moduleId']; //  module id
    }
    public function doInvokeAction()
    {
        switch($this->action)
        {
            case 'forgotpassword':
            case 'regeneratePasswordResetOtp':
                $this->invokeProcessForgotPassword();
                break;
        }
    }

    protected function invokeProcessForgotPassword()
    {
        // validate the parameter
        $this->email =  trim($this->arPostData['email']) ?? '';

        $this->data['email'] = $this->email;
 
        $params = Param::getRequestParams($this->action);
        $arError = [];

        foreach ($this->data as $key => $value) 
        {
            $valdation = doCheckParamIssetEmpty($this->data[$key], $params[$key]);
            if (strlen($valdation['msg']) > 0)
            {
                $arError[] = $valdation['msg'];
            }
        }

        if (count($arError) > 0)
        {
            $msg = implode(',', $arError);
            throw new Exception($msg);
        }

        // verify if user exists with that email
        $this->arUserData =  UserFunctions::getUserInfoByEmail($this->email, ['id', 'username', 'email']);
        $this->invokeProcessSendPasswordResetEmail();
    }

    protected function invokeProcessSendPasswordResetEmail()
    {
       if (count($this->arUserData) > 0)
       { 
            // delete existing otp request
            $id = UserFunctions::getPasswordResetRecord($this->email);
            if (strlen($id) == 36)
            {
                if ($this->action == 'regeneratePasswordResetOtp')
                {
                    Crud::delete($this->table, ['id' => $id]);
                }
                else
                {
                    throw new Exception("Reset Token already generated, Please check your email!");
                }
            }
           
           $this->arUserData['newId'] =  generateNewId(); 
           $this->arUserData['passResetCode'] = generateVerificationCode();

           $arEmail = UserFunctions::getUserPasswordResetEmail($this->arUserData);
           // send email
           $mailer = new Mailer();
           $response = $mailer->invokeProcessSendMail($arEmail);

           if ($response['status'] == true)
           {
                $data = [
                      'id' => $this->arUserData['newId'] 
                    , 'code' =>  $this->arUserData['passResetCode'] 
                    , 'parent_id' =>  $this->arUserData['id'] 
                    , 'email' => $this->arUserData['email'] 
                    , 'cdate' => $this->cdate
                ];

                Crud::insert($this->table, $data);
           }
        }
        $this->dataJson = sendPlainResponseMessage('', 'if ' . $this->email .' matches any record in our system, a password rest link will be sent');
    }
}

?>