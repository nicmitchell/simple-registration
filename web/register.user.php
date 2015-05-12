<?php
require(dirname(__FILE__) .'/vendor/ircmaxell/password-compat/lib/password.php');
require(dirname(__FILE__). '/mandrill.conf.php');
require(dirname(__FILE__). '/firebase.conf.php');
require(dirname(__FILE__). '/functions.php');

if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])){

  // sanitize
  $data = array(
    'username' => htmlspecialchars(trim($_POST['username'])),
    'email' => htmlspecialchars(trim($_POST['email'])),
    'password' => htmlspecialchars(trim($_POST['password']))
  );
  
  // Check for a user conflict
  $conflict = user_conflict($data);

  // found a conflict
  if (!empty($conflict)){
    echo json_encode(array(
      'status' => 'error',
      'message' => $conflict
    ));
    return;
  }

  // no conflict, register user
  $user = register_user($data);

  // if user was created, send Mandrill email
  if(!empty($user)){
    send_email($data);
    echo json_encode(array( 
      'status' => 'success',
      'message' => 'Your account has been created'
    ));
    return;
  } 

  // user was not successfully created
  echo json_encode(array( 
    'status' => 'error',
    'message' => 'Something went wrong'
  ));
} else {
  
  // user was not successfully created
  echo json_encode(array( 
    'status' => 'error',
    'message' => 'Something went wrong'
  ));
}
