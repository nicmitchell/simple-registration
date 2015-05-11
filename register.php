<?php
require(dirname(__FILE__). '/functions.php');

// Get the user data
$data = $_POST;

// Attempt to register the user
// Is there a user conflict?
$conflict = user_conflict($data);
if ($conflict){
  // found a conflict
  echo $conflict;
} else {
  // no user conflict, so register
  $user = register_user($data);
}

// if user was created
if($user){
  // send Mandrill email
  // send_email($user);
  // update the view
  echo 'user created';
} else {
  // user was not successfully created
  // update the view
  echo 'user not created';
}