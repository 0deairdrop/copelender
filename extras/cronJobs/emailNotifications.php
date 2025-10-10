<?php 
require_once '../../includes/utils.php';

$execute = $_REQUEST['execute'] ?? 1;
if ($execute == 1)
{
    print_R('test'); exit;
}