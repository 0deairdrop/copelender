<?php 
namespace Src\Crud;

use DateTime;
use Exception;
use Src\Module\Param\Param;

class ModuleCommonFunctions
{
    public static $arParams = [];

    public static function getDaysDifferenceFromTwoDates($startDate, $endDate)
    {
        // Convert the dates to DateTime objects
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);

        // Calculate the difference between the two dates
        $interval = $start->diff($end);
    
        // Return the difference in days
        return $interval->days;
    }

    public static function doCommonModuleDataValidation($arParams=[])
    {
        $data = $arParams['data'];
        $moduleId = $arParams['moduleId'];
        $record = $arParams['record'];
        $table = $arParams['table'];
        $field = $arParams['field'] ?? 'name';
        $arWhere = $arParams['arWhere'] ?? [];
        $checkDuplicate = $arParams['checkDuplicate'] ?? false;

        $params = Param::getRequestParams($moduleId);
        $arError = [];

        foreach ($data as $key => $value) 
        {
            $valdation = doCheckParamIssetEmpty($data[$key], $params[$key]);
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
         
        /**
         * check duplicate
         */
        if ($checkDuplicate && count($arWhere) > 0)
        {
            $arWhere['deleted'] = 0; // do not select deleted records
            if (strlen($record) != 36)
            {
                if (Crud::checkDuplicateByArray($table, $arWhere))
                {
                    throw new Exception($data[$field].' already Exist');
                }
            }
        }
    }

    public static function invokeThrowException($msg='An Error Occured')
    {
        throw new Exception($msg);
    }

    public static function invokeGetNumberOfDaysInMonth($date='')
    {
        if (empty($date))
        {
            $date = getCurrentDate();  
        }
        $dateObj  = new DateTime($date);
        return doTypeCastInt($dateObj ->format('t')); 
    }

    public static function daysInCurrentMonth() 
    {
        $date = new DateTime();  
        return  doTypeCastInt($date->format('t')); 
    }
}