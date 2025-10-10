<?php 
namespace Src\Module\Dashboard;

class DashboardFunctions
{
    public static $userId;
    protected static $tableTransactions = DEF_TBL_TRANSACTIONS;
    public static function getUserDashboardData()
    {
        return [
              'arTransactions' => self::getAllUserTransactions()
            , 'arProgress' => self::getAllUserTransactions()
            , 'arDashboardCount' => self::getUserDashboardCount()
        ];
    }

    public static function getAllUserTransactions()
    {

    }

    public static function getUserLoansProgress()
    {

    }

    public static function getUserDashboardCount()
    {
        
    }
}