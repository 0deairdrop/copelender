<?php 
namespace Src\Module\Auth;

use Src\Crud\Crud;
use Src\Module\SendMail\Mailer;
use Src\Module\User\UserFunctions;
use Src\Crud\ModuleCommonFunctions;

class Register
{
    protected $table = DEF_TBL_USR_USERS;
    protected  $tableUserVerification = DEF_TBL_USR_ACTIVATION;
    protected $cdate;
    protected $action;
    protected $email;
    protected $arPostData = [];
    protected $data = [];
    public $dataJson = [];

    /**
     * constructore
     * @param mixed $arParams
     */
    public function __construct($arParams=[])
    {
        $this->action = $arParams['action'];
        $this->arPostData = $arParams['postData'];
        $this->cdate = getCurrentDate();
    }
    public function doInvokeAction()
    {
        switch ($this->action)
        {
            case 'register':
                $this->invokeRecordValidateData();
                $this->invokeRegisterUser();
                break;

            case 'regenerateOtp':
                $this->invokeProcessRegenerateRegistrationOtp();
                break; 

            case 'verify':
                $this->doValidateRegistrationToken();
                break;
        }
    }

    /**
     * validate lenght of all inputs
     * validat password strenth
     * Validate passoword and confirm password
     * check if email is not yet taken
     * check if username is not yet taken
     * @return void
     */
    private function invokeRecordValidateData()
    {
        $this->email = invokeGetValueFromRequest($this->arPostData, 'email');
        $username = invokeGetValueFromRequest($this->arPostData, 'username');
        $password = invokeGetValueFromRequest($this->arPostData, 'password');
        $confirmPassword = invokeGetValueFromRequest($this->arPostData, 'confirm_password');
        $firstname = invokeGetValueFromRequest($this->arPostData, 'firstname');
        $lastname = invokeGetValueFromRequest($this->arPostData, 'lastname');
        $terrmAndConditions = invokeGetValueFromRequest($this->arPostData, 'accept_terms', 0);

        $this->data = [
              'firstname' => cleanme($firstname)
            , 'lastname'  => cleanme($lastname)
            , 'username'  => sanitizeUsername($username)
            , 'email'  =>  $this->email
            , 'password'  => $password
            , 'confirmpassword'  => $confirmPassword
        ];
 
        ModuleCommonFunctions::doCommonModuleDataValidation([
              'data' => $this->data
            , 'moduleId' => $this->action
            , 'table' => $this->table
            , 'checkDuplicate' => false
            , 'record' => ''
        ]);

        // password strenght
        UserFunctions::doValidateUserPassword($password);

        if ($password != $confirmPassword)
        {
            ModuleCommonFunctions::invokeThrowException('Passwords does not match');
        }

        /* 
        if ($terrmAndConditions != 1)
        {
            ModuleCommonFunctions::invokeThrowException('Please Accept out terms and conditions');
        } 
        */

        // check if email is available
        if (UserFunctions::checkIfUserExists('email', $this->email))
        {
            ModuleCommonFunctions::invokeThrowException('A user already exists with this email');
        }
        
        if (UserFunctions::checkIfUserExists('username', $username))
        {
            ModuleCommonFunctions::invokeThrowException('A user already exists with this username');
        }
    }

    /**
     * Insert into db
     * send otp for verifcation
     * @return void
     */
    private function invokeRegisterUser()
    {
        $id = generateNewId();
        $reference = generateUseReference($this->data['username']); // generate user id

        $this->data = [
              'id' => $id
            , 'reference' => $reference
            , 'firstname' => $this->data['firstname']
            , 'lastname'  => $this->data['lastname']
            , 'username'  => $this->data['username']
            , 'email'  => $this->data['email']
            , 'password'  => password_hash($this->data['password'], PASSWORD_DEFAULT)
            , 'isadmin'  => 0
            , 'cdate'  => $this->cdate
            , 'cuser' => $id
        ];

        // insert data
        Crud::insert(
            $this->table, $this->data
        );
        
        /**
         * Generate User Session
         */
        UserFunctions::doGenerateUserSession($this->data, $this->action);

        /**
         * send verification email
         */
        $this->invokeSendUserVerificationEmail();

        $this->dataJson = 'Registration Sucessful, please verify your account';
    }

    private function invokeSendUserVerificationEmail()
    {
        $arEmail = UserFunctions::invokeProcessSendEmailVerificationCode($this->email);
        $this->doProcessInsertAndSendVerifcationCode($arEmail);
    }

    protected function doProcessInsertAndSendVerifcationCode($ar=[])
    {
        // send email
        $mailer = new Mailer();
        $response = $mailer->invokeProcessSendMail($ar['arEmail']);

        if ($response['status'] == true)
        {
            // insert data
            $data = [
                 'id' => generateNewId()
                ,'email' => $this->email
                , 'cdate'  => $this->cdate
                ,'code' => $ar['verificationCode']
            ];

            if ($this->action == 'register')
            {
                $data['cuser'] =  $this->data['id'];
            }

            Crud::insert(
                $this->tableUserVerification
                , $data
            );

            $data['email'] = $this->email;
        }
    }

    protected function invokeProcessRegenerateRegistrationOtp()
    {
       
        $this->email = trim($this->arPostData['email']);
    
        // Validate that email is not empty
        if (empty($this->email)) 
        {
           ModuleCommonFunctions::invokeThrowException('Email cannot be empty');
        }
    
        // Validate email format
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            ModuleCommonFunctions::invokeThrowException('Please Enter a valid email');
        }

        // Regenerate the verification code and process
        $ar = UserFunctions::regenerateEmailVerificationCode($this->email); 
        $this->doProcessInsertAndSendVerifcationCode($ar);

        $this->dataJson = 'Verification Code Resent';
    }
    
    private function doValidateRegistrationToken()
    {
        $code = '';
        $email = invokeGetValueFromRequest($this->arPostData, 'email');
        $userId = invokeGetValueFromRequest($this->arPostData, 'id');;
        for ($i=1; $i<=6; $i++)
        {
     
            $code .= $this->arPostData['verificationCode'.$i];
            
        }
  
        if (strlen($code) != 6)
        {
            ModuleCommonFunctions::invokeThrowException('Invalid Code: Code must be  to 6 digits');
        }
        elseif (empty($email) || strlen($userId) != 36)
        {
            ModuleCommonFunctions::invokeThrowException('Unrecognized User');
        }
        
        // validate code 
        if (UserFunctions::doValidateRegistrationCode($code, $email))
        {
            Crud::update(
                $this->table,
                ['active' => 1],
                ['id' => $userId]
            );

            // delete token
            Crud::delete(
                $this->tableUserVerification
                , ['email' => $email]
            );

            $this->dataJson = 'Activation Sucessfull';
        }
        else
        {
            ModuleCommonFunctions::invokeThrowException('Invalid Registration Code');
        }
    }
}