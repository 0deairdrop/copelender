<?php 
namespace Src\Crud;

use Exception;
use Src\Crud\Crud;


class ModuleCrudActions
{
    protected static $table;
    protected static $action;
    public static $record;
    protected static $moduleId;
    protected static $userId;
    protected static $arModuleValidate = [];

    public static function invokeProcessValidateModuleTransaction($arParams=[])
    {
        self::$table = $arParams['table'] ?? '';
        self::$record = $arParams['record'] ?? '';
        self::$action = $arParams['action'] ?? '';
        self::$moduleId = $arParams['moduleId'] ?? '';
        self::$userId = $arParams['userId'] ?? '';
         

        // for existing records check validity
        if (strlen(self::$record) == 36)
        {
            self::invokeValidateModuleTransaction();
        }
    }
    protected static function invokeValidateModuleTransaction()
    {
        if (strlen(self::$record) == 36 && self::$table != ' ')
        {
            $rs = Crud::select(
                self::$table,
                 [
                    'columns' => ['id'],
                    'where' => [
                        'id' => self::$record,
                        'deleted' => 0,
                    ]
                    ,'returnType' => 'row'
                 ]
            );
            if (!$rs)
            {
                throw new Exception('Record does not exist, it could be that this record has been deleted');
            }
        }
        else
        {
            throw new Exception('Invalid Credentials!');
        }   
    }
}
?>