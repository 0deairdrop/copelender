<?php 
session_start();

$httpHost = $_SERVER['HTTP_HOST'];
$httpFolderPath = '';
$isProductionServer = true;
$isLocal = false;

if (in_array($httpHost, ['localhost', '127.0.0.1']))
{
    $httpFolderPath = '/copelender';
    $httpHost = 'http://'.$httpHost;
    $isProductionServer = false;
    $isLocal = true;
    $rootUrl = 'http://localhost/copelender/';
}
else
{
    $httpHost = 'https://'.$httpHost;
    $rootUrl = 'https://www.copelender.com/';
}

define('DEF_ROOT_PATH', $httpFolderPath);
define('DEF_FULL_ROOT_PATH', $httpHost.$httpFolderPath);
define('DEF_IS_PRODUCTION', $isProductionServer);
define('DEF_IS_LOCAL', $isLocal);
define('DEF_ROOT_PATH_ADMIN', DEF_FULL_ROOT_PATH.'/admin/');


if (DEF_IS_LOCAL)
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
   // error_reporting(E_ALL);
   define('DEF_UPLOAD_PATH',  'C:\xampp\htdocs\api-tog/uploads/'); // upload path
}
else
{
    define('DEF_UPLOAD_PATH', DEF_FULL_ROOT_PATH .'/uploads/'); // upload path
}

define('DEF_DOC_ROOT', $_SERVER['DOCUMENT_ROOT'] .'/'. $httpFolderPath . '/');
define('DEF_ROOT_URL', $rootUrl );

require_once DEF_DOC_ROOT.'vendor/autoload.php'; // auto load
require_once DEF_DOC_ROOT.'includes/config.php'; // db credentials
require_once DEF_DOC_ROOT.'includes/dbConnect.php';  // dbase connection 
require_once DEF_DOC_ROOT.'includes/defines.php'; // constants
require_once DEF_DOC_ROOT.'includes/functions.php'; // functions
require_once DEF_DOC_ROOT.'includes/defines.tables.php'; // table names

// set user session
$arGlobalUser = [];
if (isset($_SESSION['user']))
{
	$arGlobalUser = $_SESSION['user'];
}