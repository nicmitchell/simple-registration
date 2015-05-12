<?php
require(dirname(__FILE__) .'/vendor/ircmaxell/password-compat/lib/password.php');
require(dirname(__FILE__). '/mandrill.conf.php');
require(dirname(__FILE__). '/firebase.conf.php');
require(dirname(__FILE__). '/functions.php');

if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['current-password']) && !empty($_POST['new-password'])){

  // sanitize
  $data = array(
    'username' => htmlspecialchars(trim($_POST['username'])),
    'current-password' => htmlspecialchars(trim($_POST['current-password'])),
    'new-password' => htmlspecialchars(trim($_POST['new-password']))
  );

  // Attempt a reset
  $result = reset_password($data);
  
  // see if it was successful
  if (empty($result)){
    echo json_encode(array(
      'status' => 'error',
      'message' => 'Your current password is incorrect. Please try again.'
    ));
    return;
  }

  // password successfully reset
  if(!empty($result)){
    echo json_encode(array( 
      'status' => 'success',
      'message' => 'Your password has been reset.'
    ));
    return;
  } 
} else {
  // something went wrong
  echo json_encode(array( 
    'status' => 'error',
    'message' => 'Something went wrong.'
  ));
}
