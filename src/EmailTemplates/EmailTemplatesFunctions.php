<?php
namespace Src\EmailTemplates;

class EmailTemplatesFunctions
{
    public static function getModuleEmailTemplate($arParams=[])
    {
        $name = ucwords(strtolower($arParams['name'])) ?? '';
        $otp = $arParams['otp'] ?? '';
        $type = $arParams['type'] ?? '';
        $planName = $arParams['planName'] ?? '';
        $existingPlanName = $arParams['existingPlanName'] ?? '';
        $amount = $arParams['amount'] ?? '';
        $subject = $arParams['subject'] ?? '';
        $date = $arParams['date'] ?? '';
        $otpSection = '';

        switch ($type)
        {
            case 'password':
                $mainText = 'So sad you forgot your password, <br> No need to worry, you can reset your password by copying the code below to your app';
                $subText = 'If you did not request a password reset, feel free to delete this email and carry on enjoying the app!'; 
                $teamGreeting = 'All the best'; 
                $title = 'Your rassword reset OTP';
            break;

            case 'passwordreset':
                $mainText = 'This is to inform you that your password has just been changed on the Tailor to go App';
                $subText = 'If  this was not you, please contact our customer Support on +234390902342!'; 
                $teamGreeting = 'All the best'; 
                $title = 'Your password was changed';
            break;

            case 'welcome':
                $mainText = 'Just some text to tell them abou the app';
                $subText = 'Keep Exploring'; 
                $teamGreeting = 'All the best'; 
                $title = 'Welcome to the Big Family!';
            break;

            case 'sucessfullsub':
                $mainText = 'Congrtulations your Subscription to <b>'. $planName .'</b> is sucessull';
                $subText = 'Keep Exploring'; 
                $teamGreeting = 'All the best'; 
                $title = $subject .' !';
                break;
            
            case 'subupgrade':
                //$mainText = 'Congratulations, your update from <b>'. $existingPlanName.'</b> to <b>' .$planName.'</b> is sucessfull';
                $mainText = 'Congratulations, your upgrage <b>' .$planName.'</b> is sucessfull';
                $subText = 'Keep Exploring'; 
                $teamGreeting = 'All the best'; 
                $title = $subject .' !';
                break;

            case 'subcancel':
                $mainText = 'Whoops, we are sorry to inform you that your subscription to <b>'. $planName .'</b> has been cancelled .... more text as they likey';
                $subText = 'Keep Exploring'; 
                $teamGreeting = 'All the best'; 
                $title = $subject .' !';
                break;

            case 'payment':
                $mainText = 'Your payment of <b>'. $amount .'</b> has been recieved sucesfully, please check your profile for payment receipt';
                $subText = 'Empowered to do more!'; 
                $teamGreeting = 'All the best'; 
                $title = $subject .' !';
                break;
                
            case 'paymentfailed':
                $mainText = 'Your payment of <b>'. $amount .'</b> could not be processed automatically, please check your profile for more information and re initate manually';
                $subText = 'Empowered to do more!'; 
                $teamGreeting = 'All the best'; 
                $title = $subject .' !';
                break;    

            case 'paymentreminder':
                $mainText = 'Your payment of <b>'. $amount .'</b> towards your subscription to  <b>'. $planName .'</b>  will be processed automatically on  <b>'. $date .'</b> 
                please visit your profile to manage your subscription if you do not wish to renew';
                $subText = 'Empowered to do more!'; 
                $teamGreeting = 'All the best'; 
                $title = $subject .' !';
                break;
            
            default:
                $mainText = 'Thanks for signing up with Tailor on the go! Before you get started with a life of seamless experience with us
                , please copy the 6 digits OTP code below to complete your signup.';
                $subText = 'If you did not create an account, no further action is required.';
                $teamGreeting = 'Kind regards';
                $title = 'Verify your email Address';
        }


        if ($otp !== '')
        {
            $otpSection = <<<EOQ
<div class="otp-code">{$otp}</div>
<div class="otp-text"><p>Your Verification Code</p></div>
EOQ;
        }

        $year = date("Y");
        $emailCss = self::getEmailTemplateCss();
        return <<<EOQ
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
  {$emailCss}
  </head>
<body>
  <div class="email-container">
    <div class="header">
     <!--  <img src="../../../uploads/tog/logo.png" alt="Tailor on the Go Logo">Replace with your logo  -->
      <img src="https://tog.tkaykoncepts.com/uploads/tog/logo.png" alt="Tailor on the Go Logo"> <!-- Replace with your logo -->
      <h4>{$title}</h4>
    </div>
    <div class="body">
      <span class="name"> Hello,  {$name}</span>
      <p>{$mainText}</p>
        {$otpSection}
      <p>{$subText}</p>
      <p>For customer service inquiries, please contact <a href="malto:admin@tailoronthego.com">Customer Support</a>.</p>
      <p>{$teamGreeting},<br>Tailor on the go Team</p>
    </div>
    <div class="footer">
      <p>&copy; {$year} Tailor on the go App</p>
    </div>
  </div>
</body>
</html>
EOQ;
    }

    protected static function getEmailTemplateCss()
    {
        return <<<EOQ
<style>
    body {
        font-family: 'DM Sans', sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
    }
    .email-container {
        max-width: 600px;
        margin: 20px auto;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .header {
        background-color: #740001;
        text-align: center;
        padding: 30px 0;
    }
    .header img {
        max-width: 100px;
    }
    .header h1 {
        color: white;
        font-size: 24px;
        margin: 0;
    }
    .header h4 {
        color: white;
        font-size: 18px;
        margin: 0;
    }
    .body {
        padding: 40px;
        text-align: left;
    }
    .body h2 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #333;
    }
    .body p {
        font-size: 16px;
        color: #555;
        line-height: 1.5;
        margin: 10px 0;
    }
    .body a
    {
        color:#D00004;
        font-weight: bold;
    }
    .otp-code {
        font-size: 36px;
        font-weight: bold;
        color: #333;
        margin: 20px 0 0px 0; /* Adjust margin-bottom to 5px */
        text-align: center;
        letter-spacing: 8px; /* Adjust the spacing as needed */
    }
    .otp-text {
        font-size: 16px;
        color: #555;
        line-height: 1.5;
        margin-top: 0; /* Set margin-top to 0 */
        margin-bottom: 20px; /* Add margin-bottom for space below */
        text-align: center;
    }

    .footer {
        padding: 20px;
        text-align: center;
        background-color: #f2f2f2;
        font-size: 14px;
        color: #888;
    }
    .name{
        color:#D00004;
        font-size: 18px;
        margin: 0;
        font-weight: bold;
    }
    .footer a {
        color: #b52a2a;
        text-decoration: none;
    }
</style>
EOQ;
    }
}

