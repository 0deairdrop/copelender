<?php 
require_once 'includes/utils.php';

use Src\Module\Auth\Login;
use Src\Module\Auth\Register;

$action = $_POST['action'];

if (!empty($action))
{
    global $db;

    $db->beginTransaction();
    try
    {
        $ar = [
            'action' => $action  
          , 'postData' => $_POST 
        ];
        
        switch ($action)
        {
            case 'register':
            case 'verify':
            case 'regenerateOtp':
                $objAction =  new Register($ar);
                break;
            case 'login':
                $objAction =  new Login($ar);
                break;
        }

        $objAction->doInvokeAction();
        $db->commit(); // Commit the transaction
        // Return success message
        echo json_encode([
            'status' => 'success',  'message' => $objAction->dataJson
        ]);
        
        exit;
    }
    catch(Exception $e) 
    {
        $db->rollBack(); 
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit;
    }
}
// Redirect to an error page if no action is specified
echo json_encode([
    'status' => 'error', 'message' => 'Unknown error: No action specified.'
]);
exit;