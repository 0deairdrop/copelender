<?php
// database connection 
if (DEF_IS_PRODUCTION)
{
    $serverName = DB_SERVER_LIVE;
    $dbName = DB_NAME_LIVE;
    $userName = DB_USERNAME_LIVE;
    $password = DB_PASSWORD_LIVE;
}
else
{
    $serverName = DB_SERVER_LOCAL;
    $dbName = DB_NAME_LOCAL;
    $userName = DB_USERNAME_LOCAL;
    $password = DB_PASSWORD_LOCAL;
}

/**
 * php db
 */
try
{
    $db = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
    exit;
}
