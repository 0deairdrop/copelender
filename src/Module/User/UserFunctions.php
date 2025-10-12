<?php 
namespace Src\Module\User;

use Src\Crud\Crud;
use Src\Crud\ModuleCommonFunctions;
use Src\EmailTemplates\EmailTemplatesFunctions;



class UserFunctions
{
    
    protected static $table = DEF_TBL_USR_USERS;
    protected static $tablePasswordReset = DEF_TBL_USR_PASSWORD_RESET;
    protected static $tableAccountVerification = DEF_TBL_USR_ACTIVATION; 
    
    public static function doValidateUserPassword($password)
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars= preg_match('@[^\w]@', $password);
        $lowerCase= preg_match('@[a-z]@', $password);

        if (!$uppercase)
        {
            ModuleCommonFunctions::invokeThrowException('Password must contain at least one upper case');
        }
        elseif(!$number)
        {
            ModuleCommonFunctions::invokeThrowException('Password must contain at least one number');
        }
        elseif(!$specialChars)
        {
            ModuleCommonFunctions::invokeThrowException('Password must contain at least one special character');
        } 
        elseif(!$lowerCase)
        {
            ModuleCommonFunctions::invokeThrowException('Password must contain at least one lower case');
        }
    }

    public static function checkIfUserExists($field, $value)
    {
        $rs = Crud::select(
            self::$table,
            [
                'columns' => ['id'],
                'where' => [
                    $field => $value
                ]
                ,'returnType' => 'row'
            ]
        );

        if ($rs)
        {
            return true;
        }

        return false;
    }

    public static function doGenerateUserSession($ar=[], $action='login')
    {
        if ($action == 'register')
        {
            $arExcludeFields = ['password', 'cdate', 'cuser'];
            foreach ($arExcludeFields as $field)
            {
                if (array_key_exists($field, $ar))
                {
                    unset($ar[$field]);
                }
            }
        }

        $_SESSION['user'] = $ar;
    }

    public static function invokeProcessSendEmailVerificationCode($email)
    {
        // check for existing token for the user
        if (!self::getAccountVerificationRecord($email))
        {
           return  self::generateAndSendEmailVerificationCode($email);
        }
        else
        {
            ModuleCommonFunctions::invokeThrowException('Registration Token already Generated Please Check your email');
        }
    }
    
    protected static function generateAndSendEmailVerificationCode($email)
    {
        if (strlen($email) > 0)
        {
            $verificationCode = generateVerificationCode();

             $body = EmailTemplatesFunctions::getModuleEmailTemplate([
                'name' => $email, 'otp'=> $verificationCode
            ]);

            $arEmail = [
                  'recipientEmail' => trim($email)
                , 'recipientName' => $email
                , 'subject' => 'Please Verify your '. APP_NAME . 'Account'
                , 'body' => $body
            ]; 
        }  
        return [
            'verificationCode' =>  $verificationCode 
           , 'arEmail' =>  $arEmail 
        ];
    }

    protected static function getAccountVerificationRecord($email)
    {
        $rs = Crud::select(
            self::$tableAccountVerification,
            [
                'columns' => ['id'],
                'where' => [
                    'email' => $email
                ]
                ,'returnType' => 'row'
            ]
        );

        if($rs)
        {
            return $rs['id'];
        }

        return '';
    }

    public static function regenerateEmailVerificationCode($email)
    {
        // firstly check if token has not been generated earlier before proceeding
        $verificationId = self::getAccountVerificationRecord($email);

        if (strlen($verificationId) == 36)
        {
            // delete the record found
            $delete = Crud::delete(
                self::$tableAccountVerification
                , ['id' => $verificationId]
            );

            if($delete)
            {
                return self::generateAndSendEmailVerificationCode($email);
            }
        }
        else
        {
            // generate a new one
           return self::generateAndSendEmailVerificationCode($email);
        }
    }

    public static function doValidateRegistrationCode($code, $email)
    {
        $rs = Crud::select(
            self::$tableAccountVerification,
            [
                'columns' => ['id'],
                'where' => [
                      'code' => $code
                    , 'email' => $email
                ]
                ,'returnType' => 'row'
            ]
        );
        if ($rs)
        {
            return true;
        }
        return false;
    }

    public static function getUserInfo($id, $arField=['*'])
    {
        $rs = Crud::select(
            self::$table,
            [
                'columns' => $arField,
                'where' => [
                      'id' => $id
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

    public static function getUserFullName($record)
    {   
        if (strlen($record) == 36)
        {
            $rs = self::getUserInfo($record, ['firstname', 'lastname']);

            if ($rs)
            {
                return ucwords($rs['firstname']) . ' '. ucwords($rs['lastname']);
            }
        }  
        return '';
    }

    public static function getAllUserInfoByStatus($arField=['*'], $dbField='is_eligible', $value=0)
    {
        if (strlen($value) > 0)
        {
            $rs = Crud::select(
                self::$table,
                [
                    'columns' => $arField,
                    'where' => [
                         $dbField => $value
                        , 'deleted' => 0
                    ]
                ]
            );

            if ($rs)
            {
                return $rs;
            }
        }

        return [];
    }

    public static function getAllUsersInfo($arField=['*'])
    {
        $rs = Crud::select(
            self::$table,
            [
                'columns' => $arField,
                'where' => [
                     'deleted' => 0
                ]

            ]
        );

        if ($rs)
        {
            return $rs;
        }

        return [];
    }
}