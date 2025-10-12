<?php 
/**
 * check if user is already logged in and redirect them to specific pages
 * @param mixed $redirectPage
 * @return void
 */
function checkActiveSessionAuthPage($sessionKey, $redirectPage) 
{
  if (isset($_SESSION[$sessionKey])) 
  {
    header("Location: $redirectPage");
    exit;
  }
}

/**
 * to prevent unauthorized access to pages
 * @param mixed $sessionKey
 * @param mixed $redirectPage
 * @return void
 */
function doCheckUserIsLoggedInAndRedirect($sessionKey, $redirectPage) 
{
  if (!isset($_SESSION[$sessionKey])) 
  {
    header("Location: $redirectPage");
    exit;
  }
}

function getCurrentDate($format='Y-m-d H:i:s')
{
    return date($format);
}

function invokeGetValueFromRequest($arParams=[], $key, $defaultValue = '')
{
    return $arParams[$key] ?? $defaultValue;
}

function cleanme($text) {
	$cleanit = strip_tags(trim($text));
	return $cleanit;
}

function doCheckParamIssetEmpty($param, $data)
{
  $datax = [
    'status' => true,
    'msg' => ''
  ];

  $method = $data['method'];
  $label = $data['label'];
  $length = isset($data['length']) ? $data['length'] : [0,0];
  $required = isset($data['required']) ? $data['required'] : false;
  $type = isset($data['type']) ? $data['type'] : "";
  $isEmail = isset($data['is_email']) ? $data['is_email'] : false;
  $greaterThanZero = isset($data['greaterThanZero']) ? $data['greaterThanZero'] : false;
  $isDate = isset($data['isDate']) ? $data['isDate'] : false;

  if(empty($label))
  {
    $label = $param;
  }
  if(strtolower($method) == 'post')
  {
    $isset = isset($param);
    $value = isset($param) ? $param : "";
  }
  elseif(strtolower($method) == 'get')
  {
    $isset = isset($_GET[$param]);
    $value = $isset ? $_GET[$param] : "";
  }
  else
  {
    $isset = isset($_REQUEST[$param]);
    $value = $isset ? $_REQUEST[$param] : "";
  }
  
  if($required)
  {
    $isset = $isset && !empty($value);
    if(!$isset)
    {
      $datax['status'] = false;
      $datax['msg'] = $label . ' is required.';
      return $datax;
    }
  }

  if(!empty($type) && !empty($value))
  {
    if($type == 'string')
    {
      if(!is_string($value))
      {
        $datax['status'] = false;
        $datax['msg'] = $label . ' must be a string.';
        return $datax;
      }
    }
    elseif($type == 'number')
    {
      if (!is_numeric($value))
      {
        $datax['status'] = false;
        $datax['msg'] = $label . ' must contain only digits.';
        return $datax;
      }
      else
      {
        if ($greaterThanZero)
        {
          if ($value <= 0)
          {
            $datax['status'] = false;
            $datax['msg'] = $label . ' must be greater than 0.';
            return $datax;
          }
        }
      }
    }

    if ($isDate)
    {
      if (strlen($value) < 10)
      {
        $datax['status'] = false;
        $datax['msg'] = 'Invalid Date for '  .$label ;
        return $datax;
      }
    }
  }

  if((!empty($value) && $isEmail) || (!empty($value) && trim($param) == 'email'))
  {
    if(!filter_var($value, FILTER_VALIDATE_EMAIL))
    {
      $datax['status'] = false;
      $datax['msg'] = $label . ' must contain a valid email.';
      return $datax;
    }
  }

  if($length[0] > 0 && $length[1] > 0 && $length[0] == $length[1] && !empty($value))
  {
    $isset = $isset && strlen($value) == $length[0];
    if(!$isset)
    {
      $datax['status'] = false;
      if(strpos($param, '_id') !== false || $param == 'id')
      {
        $datax['msg'] = $label . ' in invalid.';
      }
      else
      {
        $datax['msg'] = $label . ' must be equal to ' . $length[0] .' characters.';
      }
      return $datax;
    }
  }
  if($length[0] > 0 && !empty($value))
  {
      $isset = $isset && strlen($value) >= $length[0];
      if(!$isset)
      {
        $datax['status'] = false;
        if(strpos($param, '_id') !== false || $param == 'id')
        {
          $datax['msg'] = $label . ' in invalid.';
        }
        else
        {
          $datax['msg'] = $label . ' must be greater than or equal to ' . $length[0] .' characters.';
        }
        return $datax;
      }
  }
  if($length[1] > 0 && !empty($value))
  {
    $isset = $isset && strlen($value) <= $length[1];
    if(!$isset)
    {
      $datax['status'] = false;
      if(strpos($param, '_id') !== false || $param == 'id')
      {
        $datax['msg'] = $label . ' in invalid.';
      }
      else
      {
        $datax['msg'] = $label . ' must be less than or equal to ' . $length[1] .' characters.';
      }
      return $datax;
    }
  }
  return $datax;
}


function doTypeCastDouble($number) {
  return doubleval($number);
}

function doNumberFormat($number) {
  return number_format($number, 2);
}

function doTypeCastInt($number)
{
    return intval($number);
}


function generateNewId()
{
  mt_srand((int)microtime()*10000);
  $charId = strtoupper(md5(uniqid(rand(), true)));
  $hyphen = chr(45);
  $id = substr($charId, 0, 8).$hyphen
  .substr($charId, 8, 4).$hyphen
  .substr($charId, 12, 4).$hyphen
  .substr($charId, 16, 4).$hyphen
  .substr($charId, 20, 12);

  return $id;
}

function sanitizeUsername($name) 
{
    $sanitizedUsername = preg_replace('/[^a-zA-Z0-9]/', '', $name);
    return strtolower($sanitizedUsername);
}

function generateUseReference($name) 
{
  // Extract the first 3 letters of the provided name
  $initials = strtoupper(substr($name, 0, 3));
  // Create a unique numeric component using the current timestamp and a random number
  $uniqueId = substr(time(), -4) . mt_rand(1000, 9999); // 4 digits from timestamp + 4 random digitsidentifier

  $userId = "COPL-" . $initials . $uniqueId;
  
  return $userId;
}
function generatePaymentReference() 
{
  // Create a unique numeric component using the current timestamp and a random number
  $uniqueId = substr(time(), -4) . mt_rand(1000, 9999); // 4 digits from timestamp + 4 random digitsidentifier

  $ref = "COPL-PY-" . $uniqueId;
  
  return $ref;
}

function generateVerificationCode($length = 6) 
{
  $characters = '0123456789'; // Only numeric characters
  $charactersLength = strlen($characters);
  $code = '';

  // Generate random code with numbers only
  for ($i = 0; $i < $length; $i++) 
  {
      $randomIndex = random_int(0, $charactersLength - 1);
      $code .= $characters[$randomIndex];
  }

  return $code;
}

function getUserSessionFields()
{
  return ['id', 'firstname', 'lastname', 'email', 'password', 'isadmin', 'active', 'reference', 'username', 'profile_picture'];
}


function getLoggedInUserDetailsByKey($key='id')
{
  global $arGlobalUser;
  if (empty($arGlobalUser))
  {
    $arGlobalUser = $_SESSION['user'];
  }

  if (array_key_exists($key, $arGlobalUser))
  {
    return $arGlobalUser[$key];
  }
  return '';
  
}

function getFormattedDate($date, $format='')
{
  if ($date != '')
  {
    $format = !empty($format) ? $format : 'Y-m-d H:i';
    return date($format, $date);
  }
  else
  {
    return '';
  }
}

function formatDate($dateString, $format = 'Y-m-d H:i:s') 
{
  $date = new DateTime($dateString);
  return $date->format($format);
}

function doTextDateFormating($date)
{
  return date("F jS, Y \a\\t g:i A", strtotime($date));
}

function limitWords($text, $limit = 50) 
{
    $words = str_word_count($text, 1);
    return count($words) > $limit
        ? implode(' ', array_slice($words, 0, $limit)) . '...'
        : $text;
}
