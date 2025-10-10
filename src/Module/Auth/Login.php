<?php 
namespace Src\Module\Auth;

use Src\Crud\Crud;
use Src\Module\Param\Param;
use Src\Module\User\UserFunctions;
use Src\Crud\ModuleCommonFunctions;

class Login
{
    protected $table = DEF_TBL_USR_USERS;
    protected $cdate;
    protected $action;
    protected $email;
    protected $arPostData = [];
    protected $data = [];
    public $dataJson = [];

    public function __construct($arParams=[])
    {
        $this->action = $arParams['action'];
        $this->arPostData = $arParams['postData'];
        $this->cdate = getCurrentDate();
    }

    public function doInvokeAction()
    {
       if ($this->action == 'login')
       {
            $this->invokeProcessUserLogin();
       }
    }
    
    protected function invokeProcessUserLogin()
    {
        // validate the parameter
        $password =  trim($this->arPostData['password']);
        $rememberMe = doTypeCastInt($this->arPostData['rememberMe'] ?? 0);
        
        $this->data['password'] = $password;

        if (array_key_exists('usernameOrEmail', $this->arPostData )) 
        {
            $value = trim($this->arPostData['usernameOrEmail']);
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) 
            {
                $field = 'email';
            } 
            else 
            {
                $field = 'username';
                $value = strtolower($value);
            }
            $this->data['usernameOrEmail'] = $value;
        } 

        // validate the fields
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
            ModuleCommonFunctions::invokeThrowException($msg);
        }

        //check if a user exists with the email or username
        $rs = Crud::select(
            $this->table,
            [
                'columns' => getUserSessionFields(),
                'where' => [
                    $field =>  strtolower($value),
                    'deleted' => 0
                ]
                ,'returnType' => 'row'
            ]
        );

        if ($rs)
        {
            if (!password_verify($password,  $rs['password']))
            {
                ModuleCommonFunctions::invokeThrowException('Email or Password is incorrect');
            }
            else
            {
                unset($rs['password']);
                $this->data = $rs;
                 /**
                 * Generate User Session
                 */
                UserFunctions::doGenerateUserSession($this->data);
            }
        }
        else
        {
           ModuleCommonFunctions::invokeThrowException('User not Found');
        }
    }
}