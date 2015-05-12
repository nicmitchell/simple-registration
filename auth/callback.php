<?php
/**
 * Callback for Opauth
 * 
 * This file (callback.php) provides an example on how to properly receive auth response of Opauth.
 * 
 * Basic steps:
 * 1. Fetch auth response based on callback transport parameter in config.
 * 2. Validate auth response
 * 3. Once auth response is validated, your PHP app should then work on the auth response 
 *    (eg. registers or logs user in to your site, save auth data onto database, etc.)
 * 
 */

date_default_timezone_set('America/Los_Angeles');

/**
 * Define paths
 */

define('CONF_FILE', dirname(dirname(__FILE__)).'/'.'opauth.conf.php');
define('OPAUTH_LIB_DIR', dirname(dirname(__FILE__)).'/auth/lib/Opauth/');

/**
* Load config
*/
if (!file_exists(CONF_FILE)) {
  trigger_error('Config file missing at '.CONF_FILE, E_USER_ERROR);
  exit();
}
require CONF_FILE;

/**
 * Instantiate Opauth with the loaded config but not run automatically
 */
require OPAUTH_LIB_DIR.'Opauth.php';
$Opauth = new Opauth( $config, false );

  
/**
* Fetch auth response, based on transport configuration for callback
*/
$response = null;

switch($Opauth->env['callback_transport']) {
  case 'session':
    session_start();
    $response = $_SESSION['opauth'];
    unset($_SESSION['opauth']);
    break;
  case 'post':
    $response = unserialize(base64_decode( $_POST['opauth'] ));
    break;
  case 'get':
    $response = unserialize(base64_decode( $_GET['opauth'] ));
    break;
  default:
    $message = '<strong style="color: red;">Error: </strong>Unsupported callback_transport.'."<br>\n";
    break;
}

/**
 * Check if it's an error callback
 */
if (array_key_exists('error', $response)) {
  $message = '<strong style="color: red;">Authentication error: </strong> Opauth returns error auth response.'."<br>\n";
}

/**
 * Auth response validation
 * 
 * To validate that the auth response received is unaltered, especially auth response that 
 * is sent through GET or POST.
 */
else{
  if (empty($response['auth']) || empty($response['timestamp']) || empty($response['signature']) || empty($response['auth']['provider']) || empty($response['auth']['uid'])) {
    $message = '<strong style="color: red;">Invalid auth response: </strong>Missing key auth response components.'."<br>\n";
  } elseif (!$Opauth->validate(sha1(print_r($response['auth'], true)), $response['timestamp'], $response['signature'], $reason)) {
    $message = '<strong style="color: red;">Invalid auth response: </strong>'.$reason.".<br>\n";
  } else {
    // $message = '<strong style="color: green;">OK: </strong>Auth response is validated.'."<br>\n";

    /**
     * It's all good. Go ahead with your application-specific authentication logic
     */
    $data = array(
      'username' => $response['auth']['uid'],
      'email' => $response['auth']['info']['email'],
      'password' => $response['auth']['info']['email'] // omg this is totally not a good idea
    );

    // Check for a user conflict
    $conflict = user_conflict($data);

    // found a conflict
    if (!empty($conflict)){
      echo '<small class="alert-box error animated rubberBand">' . $conflict . '</small>';
    }

    // no conflict, register user
    $user = register_user($data);

    // if user was created, send Mandrill email
    if(!empty($user)){
      send_email($data);
      echo '<small class="alert-box success">Your account has been created</small>';
    } 

    // user was not successfully created
    echo '<small class="alert-box error animated rubberBand">Something went wrong</small>';

  }
}


/**
* Auth response dump
*/
echo "<pre>";
print_r($response);
echo "</pre>";
echo $message;