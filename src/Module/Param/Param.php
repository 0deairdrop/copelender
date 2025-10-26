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
                        'length' => [5,200],
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

            case DEF_MODULE_ID_LOAN_APPLICATION:
                $data = [
                    'name' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Loan Title',
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
                    'duration' => [
                        'method' => 'post',
                        'length' => [1,50000],
                        'label' => 'Loan Duration',
                        'required' => true,
                        'greaterThanZero' => true,
                        'type' => 'number'
                    ],       
                   'repayment_type' => [
                        'method' => 'post',
                        'length' => [1,600],
                        'label' => 'Repayment Type',
                        'required' => true,
                        'type' => 'string',
                   ],
                   
                   'purpose' => [
                        'method' => 'post',
                        'length' => [1,600],
                        'label' => 'Loan Purpose',
                        'required' => true,
                        'type' => 'string',
                   ]
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
                    
                    'phone_number' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Phone Name',
                        'required' => true,
                        'type' => 'string'
                    ],  
                    
                    'dob' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Date of Birth',
                        'required' => true,
                        'type' => 'string'
                    ],    
                    
                    'occupation' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Occupation',
                        'required' => true,
                        'type' => 'string'
                    ], 
                    
                    'montly_income' => [
                        'method' => 'post',
                        'length' => [1,100],
                        'label' => 'Monthly Income',
                        'required' => true,
                        'type' => 'number'
                    ],
                     
                    'bank_name' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Bank Names',
                        'required' => true,
                        'type' => 'string'
                    ],    
                    
                    'bank_account_holder_name' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Bank Account Holder Name',
                        'required' => true,
                        'type' => 'string'
                    ],    
                    
                    'account_number' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Account Number',
                        'required' => true,
                        'type' => 'string'
                    ],  
                    
                    'national_id' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Naitonal Id',
                        'required' => true,
                        'type' => 'string'
                    ],   
                    
                    'identification' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Identification',
                        'required' => true,
                        'type' => 'string'
                    ],  
                    
                    'address' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Street',
                        'required' => true,
                        'type' => 'string'
                    ],  
                    
                    'city' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'City',
                        'required' => true,
                        'type' => 'string'
                    ],   
                    
                    'state' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'State',
                        'required' => true,
                        'type' => 'string'
                    ],     
                    
                    'country' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Country',
                        'required' => true,
                        'type' => 'string'
                    ],    
                    
                    'postal' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Postal',
                        'required' => true,
                        'type' => 'string'
                    ],
                    
                ];
            break;
        }
        return $data;
    }
}