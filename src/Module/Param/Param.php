<?php
namespace Src\Module\Param;

class Param
{
    public static function getRequestParams($module)
    {
        $data = [];
        switch($module)
        {
            case 'register':
                $data = [
                    'firstname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'First Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'lastname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Last Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'email' => [
                        'method' => 'post',
                        'length' => [13,200],
                        'label' => 'Email',
                        'required' => true,
                        'type' => 'string',
                        'is_email' => true
                    ],
                    'password' => [
                        'method' => 'post',
                        'length' => [8,0],
                        'label' => 'Password',
                        'required' => true
                    ],
                    'confirmpassword' => [
                        'method' => 'post',
                        'length' => [8,0],
                        'label' => 'Confirm Password',
                        'required' => true
                    ],
                    'username' => [
                        'method' => 'post',
                        'length' => [5,0],
                        'label' => 'Username',
                        'required' => true
                    ],
                    'isadmin' => [
                        'method' => 'post',
                        'length' => [1,1],
                        'label' => 'Role',
                        'required' => false
                    ],
                    'code' => [
                        'method' => 'post',
                        'length' => [6,6],
                        'label' => 'Code',
                        'required' => false
                    ],
                    'phone_number' => [
                        'method' => 'post',
                        'length' => [7,20],
                        'label' => 'Phone Number',
                        'required' => false
                    ]
                ];
            break;

            case 'login':
                $data = [
                    'usernameOrEmail' => [
                        'method' => 'post',
                        'length' => [8,200],
                        'label' => 'Username or Email',
                        'required' => true,
                        'type' => 'string',

                    ],
                    'password' => [
                        'method' => 'post',
                        'length' => [8,0],
                        'label' => 'Password',
                        'required' => true
                    ],
                ];
            break;

            case 'resetpassword':
                $data = [
                    'password' => [
                        'method' => 'post',
                        'length' => [8,0],
                        'label' => 'Password',
                        'required' => true
                    ],
                    'code' => [
                        'method' => 'post',
                        'length' => [6,6],
                        'label' => 'Code',
                        'required' => true
                    ],
                    'email' => [
                        'method' => 'post',
                        'length' => [13,200],
                        'label' => 'Email',
                        'required' => true,
                        'type' => 'string',
                        'is_email' => true
                    ],
                ];
            break;

            case 'updatepassword':
                $data = [
                    'currentpassword' => [
                        'method' => 'post',
                        'length' => [8,0],
                        'label' => 'Current Password',
                        'required' => true
                    ],
                    'password' => [
                        'method' => 'post',
                        'length' => [8,0],
                        'label' => 'New Password',
                        'required' => true
                    ],
                    'confirmpassword' => [
                        'method' => 'post',
                        'length' => [8,0],
                        'label' => 'Confirm Password',
                        'required' => true
                    ]
                ];
            break;
                
            case 'forgotpassword':
            case 'regeneratePasswordResetOtp':
                $data = [
                    'email' => [
                        'method' => 'post',
                        'length' => [13,100],
                        'label' => 'Email',
                        'required' => true
                    ]
                ];
            break;

            case 'verifycode':
                $data = [
                    'code' => [
                        'method' => 'post',
                        'length' => [6,6],
                        'label' => 'Code',
                        'required' => true
                    ]
                ];
            break;
            
            case 'verifyRegistrationCode':
                $data = [
                    'email' => [
                        'method' => 'post',
                        'length' => [13,200],
                        'label' => 'Email',
                        'required' => true,
                        'type' => 'string',
                        'is_email' => true
                    ],
                    'code' => [
                        'method' => 'post',
                        'length' => [6,6],
                        'label' => 'Code',
                        'required' => true
                    ]
                ];
            break;

            case 'updateprofile':
                $data = [
                    'firstname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'First Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'lastname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Last Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'email' => [
                        'method' => 'post',
                        'length' => [13,200],
                        'label' => 'Email',
                        'required' => true,
                        'type' => 'string',
                        'is_email' => true
                    ]
                ];
            break;

            case DEF_MODULE_ID_PAID_AHEAD:
                $data = [
                    'name' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Plan Name',
                        'required' => true,
                        'type' => 'string'
                    ],  
                    
                    'payment_frequency' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Plan Name',
                        'required' => false,
                        'type' => 'string'
                    ],
                    'base_amount' => [
                        'method' => 'post',
                        'length' => [1,50000],
                        'label' => 'Amount',
                        'required' => true,
                        'greaterThanZero' => true,
                        'type' => 'number'
                    ], 

                    'start_date' => [
                        'method' => 'post',
                        'length' => [1,50],
                        'label' => 'Start Date',
                        'required' => true,
                        'isDate' => true,
                        'type' => 'string'
                    ]
                    , 'duration' => [
                        'method' => 'post',
                        'length' => [1,50],
                        'label' => 'Duration',
                        'required' => true,
                        'greaterThanZero' => true,
                        'type' => 'number'
                       
                    ]  
                    , 'duration_covered' => [
                        'method' => 'post',
                        'length' => [1,50],
                        'label' => 'Duration',
                        'required' => false,
                        'type' => 'number'
                    ]  
                    , 'duration_left' => [
                        'method' => 'post',
                        'length' => [1,50],
                        'label' => 'Duration',
                        'required' => false,
                        'type' => 'number'
                    ], 

                    'payment_due_date' => [
                        'method' => 'post',
                        'length' => [1,50],
                        'label' => 'Duration',
                        'required' => true,
                        'greaterThanZero' => true,
                        'type' => 'number'
                       
                    ],
                    'description' => [
                        'method' => 'post',
                        'length' => [1,600],
                        'label' => 'Description',
                        'required' => false,
                        'type' => 'string',
                    ]
                ];
            break;  
            
            case DEF_MODULE_ID_EXPENDITURE:
                $data = [
                    'name' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Name',
                        'required' => true,
                        'type' => 'string'
                    ],  
                    'amount' => [
                        'method' => 'post',
                        'length' => [1,50000],
                        'label' => 'Amount',
                        'required' => true,
                        'greaterThanZero' => true,
                        'type' => 'number'
                    ], 
                    'is_bill' => [
                        'method' => 'post',
                        'length' => [0,1],
                        'label' => 'Is Bill',
                        'required' => false,
                        'type' => 'number'
                       
                    ],
                    'description' => [
                        'method' => 'post',
                        'length' => [1,600],
                        'label' => 'Description',
                        'required' => false,
                        'type' => 'string',
                    ]
                ];
            break;    
            
     
            case DEF_MODULE_ID_BILLS:
            case DEF_MODULE_ID_BILLS_CONFIG:
                $data = [
                    'name' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Name',
                        'required' => true,
                        'type' => 'string'
                    ],  
                    'payment_frequency' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Plan Name',
                        'required' => false,
                        'type' => 'string'
                    ],
                    'payment_due_date' => [
                        'method' => 'post',
                        'length' => [1,50],
                        'label' => 'Duration',
                        'required' => true,
                        'greaterThanZero' => true,
                        'type' => 'number'
                       
                    ],
                    'description' => [
                        'method' => 'post',
                        'length' => [1,600],
                        'label' => 'Description',
                        'required' => false,
                        'type' => 'string',
                    ]
                ];
            break;   

            case DEF_MODULE_ID_INCOME:
                $data = [
                    'name' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Name',
                        'required' => true,
                        'type' => 'string'
                    ],  
                    'total_amount' => [
                        'method' => 'post',
                        'length' => [1,50000],
                        'label' => 'Amount',
                        'required' => true,
                        'greaterThanZero' => true,
                        'type' => 'number'
                    ],
                    'total_hours' => [
                        'method' => 'post',
                        'length' => [1,100],
                        'label' => 'Total Hours Worked',
                        'required' => true,
                        'greaterThanZero' => true,
                        'type' => 'number'
                    ],
                    'description' => [
                        'method' => 'post',
                        'length' => [1,600],
                        'label' => 'Description',
                        'required' => false,
                        'type' => 'string',
                    ]
                ];
            break;     

            case DEF_MODULE_ID_EXTRA_INCOME:
                $data = [
                    'name' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Name',
                        'required' => true,
                        'type' => 'string'
                    ],  
                    'amount' => [
                        'method' => 'post',
                        'length' => [1,50000],
                        'label' => 'Amount',
                        'required' => true,
                        'greaterThanZero' => true,
                        'type' => 'number'
                    ],
                    'description' => [
                        'method' => 'post',
                        'length' => [1,600],
                        'label' => 'Description',
                        'required' => false,
                        'type' => 'string',
                    ]
                ];
            break;   
            
            case DEF_MODULE_ID_ALLOCATION:
                $data = [
                    'income' => [
                        'method' => 'post',
                        'length' => [1,50000],
                        'label' => 'Income Budget',
                        'required' => True,
                        'type' => 'number'
                    ],    
                    'bills' => [
                        'method' => 'post',
                        'length' => [1,50000],
                        'label' => 'Bills Budget',
                        'required' => true,
                        'type' => 'number'
                    ], 
                    'rent' => [
                        'method' => 'post',
                        'length' => [1,50000],
                        'label' => 'Rent Budget',
                        'required' => true,
                        'type' => 'number'
                    ],      
                    'savings' => [
                        'method' => 'post',
                        'length' => [1,50000],
                        'label' => 'Savings Budget',
                        'required' => true,
                        'type' => 'number'
                    ],       
                    'investment' => [
                        'method' => 'post',
                        'length' => [1,50000],
                        'label' => 'Investment Budget',
                        'required' => true,
                        'type' => 'number'
                    ],   
                    'expenditure' => [
                        'method' => 'post',
                        'length' => [1,50000],
                        'label' => 'Expenditure Budget',
                        'required' => true,
                        'type' => 'number'
                    ], 
                    'giving' => [
                        'method' => 'post',
                        'length' => [1,50000],
                        'label' => 'Giving Budget',
                        'required' => true,
                        'type' => 'number'
                    ],
                ];
            break;          
            
            case DEF_MODULE_ID_SUBSCRIPTION:
                $data = [
                    'name' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Plan Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'amount' => [
                        'method' => 'post',
                        'length' => [1,50],
                        'label' => 'Plan Annual Price',
                        'required' => true,
                        'type' => 'number'
                    ], 
                    'amount_montly' => [
                        'method' => 'post',
                        'length' => [1,50],
                        'label' => 'Plan Monthly Price',
                        'required' => true,
                        'type' => 'number'
                    ],
                    'description' => [
                        'method' => 'post',
                        'length' => [5,600],
                        'label' => 'Description',
                        'required' => false,
                        'type' => 'string',
                    ],
                    'duration' => [
                        'method' => 'post',
                        'length' => [3,50],
                        'label' => 'Plan Duration',
                        'required' => false
                    ],
                    'benefit' => [
                        'method' => 'post',
                        'length' => [3,1000],
                        'label' => 'Benefit',
                        'required' => false
                    ],
                ];
            break;

            case DEF_MODULE_ID_USER:
                $data = [
                    'firstname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'First Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'lastname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Last Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'isadmin' => [
                        'method' => 'post',
                        'length' => [1,1],
                        'label' => 'Role',
                        'required' => false
                    ],
                    'isactive' => [
                        'method' => 'post',
                        'length' => [1,1],
                        'label' => 'Role',
                        'required' => false
                    ],  
                    'profile_picture' => [
                        'method' => 'post',
                        'length' => [0,1000],
                        'label' => 'Profile Picture',
                        'required' => false
                    ],
                ];
            break;

            case DEF_MODULE_ID_PAYMENT:
                $data = [
                    'plan_id' => [
                        'method' => 'post',
                        'length' => [36,36],
                        'label' => 'Plan Type',
                        'required' => true,
                        'type' => 'string'
                    ], 
                    'email' => [
                        'method' => 'post',
                        'length' => [0,900],
                        'label' => 'Email',
                        'required' => true,
                        'is_email' => true,
                        'type' => 'string'
                    ],
                    'payment_method' => [
                        'method' => 'post',
                        //'length' => [36,36],
                        'length' => [0,36],
                        'label' => 'Payment Method',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'name' => [
                        'method' => 'post',
                        'length' => [1,100],
                        'label' => 'Name',
                        'required' => false
                    ],
                ];
            break;
        }
        return $data;
    }
}