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
    public static function invokeExtractMediaLinksFromFirebaseJson($arParams = [])
    {
        $arMedia = [];
        if (count($arParams)  > 0)
        {
            foreach ($arParams as $fieldId => $jsonValue)
            {
                if (!empty($jsonValue))
                {
                    $ar = json_decode($jsonValue, true);
                    if (count($ar) > 0)
                    {
                        $link = $ar['url'] ?? '';
                    }
                    $arMedia[$fieldId] = $link;
                }
            }
        }
        return $arMedia;
    }

    public static function invokeCalculateRecurringAmountByArParams($arParams=[])
    {
        $baseAmount = self::invokeGetValuesFromAraParams('base_amount', 0, $arParams);
        $duration = self::invokeGetValuesFromAraParams('duration', 0, $arParams);
 
        return $baseAmount/$duration;
    }  
     
    public static function invokeCalculateDurationAr($arParams=[])
    {
        $duration = self::invokeGetValuesFromAraParams('duration', 0, $arParams);
        $durationCovered = self::invokeGetValuesFromAraParams('duration_covered', 0, $arParams);
        $durationLeft = self::invokeGetValuesFromAraParams('duration_left', 0, $arParams);

        if ($duration > 0)
        {
            if ($durationCovered > 0)
            {
                $durationLeft = $duration - $durationCovered;
            }
            else
            {
                $durationLeft = $duration;
            }
        }
        else
        {
            $duration = $durationCovered + $durationLeft;
        }

        return [
              'duration' => doTypeCastDouble($duration)
           ,  'duration_covered' => doTypeCastDouble($durationCovered)
           ,  'duration_left' => doTypeCastDouble($durationLeft)
        ];
    }

    protected static function invokeGetValuesFromAraParams($key, $defaultValue, $arParams=[])
    {
        if (empty($arParams))
        {
            $arParams = self::$arParams;
        }

        return array_key_exists($key, $arParams) ? $arParams[$key] : $defaultValue; 
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