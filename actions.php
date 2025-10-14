<?php 
require_once 'includes/utils.php';

use Src\Module\Auth\Login;
use Src\Module\Auth\Register;
use Src\Module\User\UserCrudActions;
use Src\Module\LoanApplication\LoanApplicationCrudActions;

$action = $_POST['action'];
$moduleId =  $_POST['moduleId'];
$record =  $_POST['id'] ?? '';

if (!empty($action))
{
    global $db;

    $db->beginTransaction();
    try
    {
        $ar = [
            'action' => $action  
          , 'postData' => $_POST 
          , 'record' => $record
        ];
        
        switch ($moduleId)
        {
            case DEF_MODULE_ID_AUTH:
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
                break;
                
            case DEF_MODULE_ID_LOAN_APPLICATION:
                $objAction =  new LoanApplicationCrudActions($ar);
                break; 

            case DEF_MODULE_ID_USER:
                $objAction =  new UserCrudActions($ar);
                break;
            default:
                json_encode(['status' => 'false', 'message' => 'Unknown Module']);
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