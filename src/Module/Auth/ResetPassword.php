<?php
namespace Src\Module\Auth;

use Exception;
use Src\Crud\Crud;
use Src\Module\Param\Param;
use Src\Module\SendMail\Mailer;
use Src\Module\Users\UserFunctions;

class ResetPassword
{
    protected $record; // will be called outside the class
    protected $table = DEF_TBL_USR_PASSWORD_RESET;
    protected $tableUser = DEF_TBL_USR_USERS;
    protected $cdate;
    protected $action;
    protected $moduleId;
    protected $email;
    protected $arPostData = [];
    protected $data = [];
    public $dataJson = [];
    protected $arUserData = [];

    public function __construct($arParams = [])
    {
        $this->action = $arParams['action'];
        $this->arPostData = $arParams['postData'];
        $this->cdate = getCurrentDate();
        $this->moduleId = $arParams['moduleId'];
        $this->record = $arParams['record'];
    }

    public function doInvokeAction()
    {
        switch ($this->action) 
        {
            case 'verifycode':
                $this->processVerifyResetCode();
                break;

            case 'resetpassword':
            case 'updatepassword':
                $this->processResetPassword();
                break;
        }
    }

    protected function processVerifyResetCode()
    {
        $code = trim($this->arPostData['code']) ?? '';
        $email = trim($this->arPostData['email']) ?? '';
        $this->data['code'] = $code;

        $params = Param::getRequestParams('verifycode');
        $this->validateFields($this->data, $params);

        $this->arUserData = UserFunctions::doValidatePasswordResetCode(strtoupper($code), $email);

        if (!empty($this->arUserData))
        {
            $this->dataJson = $this->prepareResponse('Token Validation');
        } 
        else 
        {
            $this->handleError("invalid OTP!");
        }
    }

    protected function processResetPassword()
    {
        $password = $this->arPostData['password'] ?? '';
        $password2 = $this->arPostData['confirmpassword'] ?? '';
    
        if ($this->action == 'resetpassword') 
        {
            $this->data['email'] = trim($this->arPostData['email']) ?? '';
            $this->data['password'] = $password;

            $code  = $this->arPostData['code'] ?? '';
            $this->data['code'] = $code;
            $params = Param::getRequestParams($this->action);
            $this->validateFields($this->data, $params);

            $this->validateResetToken(trim($code), $this->data['email'] );

            $this->arUserData = UserFunctions::doValidateCredentialsForPasswordReset(['record' => $this->record]);
        }
        else
        {

            // update password
            $currentPassword = trim($this->arPostData['currentpassword']) ?? '';
            $this->data['currentpassword'] = $currentPassword;
            $this->data['confirmpassword'] = $password2;

            $params = Param::getRequestParams($this->action);
            $this->validateFields($this->data, $params);

            $this->arUserData = UserFunctions::doValidateCredentialsForPasswordReset([
                'record' => $this->record,
                'type' => 'update',
                'currentpassword' => $currentPassword
            ]);
        }

        $this->validatePasswordMatch($password, $password2);
        $this->updateUserPassword($password);

        if ($this->action == 'resetpassword') 
        {
            $this->deletePasswordResetToken($this->record);
        }

        $this->sendUpdateEmail();
        $this->dataJson = $this->prepareResponse('Password Updated Successfully');
    }

    protected function validateFields($fields, $params)
    {
        $errors = [];
        foreach ($fields as $key => $value) 
        {
            $validation = doCheckParamIssetEmpty($value, $params[$key]);
            if (!empty($validation['msg'])) 
            {
                $errors[] = $validation['msg'];
            }
        }

        if (!empty($errors)) 
        {
            $this->handleError(implode(',', $errors));
        }
    }

    protected function validateResetToken($code, $email)
    {
        $rs = UserFunctions::doValidatePasswordResetCode(strtoupper($code), $email);
        if (empty($rs)) 
        {
            $this->handleError('invalid OTP!');
        }
        $this->record = $rs['parent_id'];
    }

    protected function validatePasswordMatch($password, $password2)
    {
        if ($password !== $password2) 
        {
            $this->handleError("Passwords do not match");
        }

        UserFunctions::invokeValidatePassword($password);
    }

    protected function updateUserPassword($password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        Crud::update(
            $this->tableUser,
            $this->buildPasswordUpdateData($hashedPassword),
            ['id' => $this->record]
        );
    }

    protected function buildPasswordUpdateData($password)
    {
        return [
            'password' => $password,
            'mdate' => $this->cdate,
            'muser' => $this->record
        ];
    }

    protected function deletePasswordResetToken($record)
    {
        Crud::delete($this->table, ['parent_id' => $record]);
    }

    protected function sendUpdateEmail()
    {
        $arEmail = UserFunctions::getUserPasswordUpdateEmail($this->arUserData);
        $mailer = new Mailer();
        $mailer->invokeProcessSendMail($arEmail);
    }

    protected function prepareResponse($message)
    {
        return invokePrepareResponseMessage('', $message);
    }

    protected function handleError($message)
    {
        throw new Exception($message);
    }
}
