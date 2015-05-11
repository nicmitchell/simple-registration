<?php

require(dirname(__FILE__) .'/vendor/ircmaxell/password-compat/lib/password.php');
require(dirname(__FILE__). '/firebase.php');

// get $_POST vars
$username = htmlspecialchars($_POST['username']);
echo $username;
$email = htmlspecialchars($_POST['email']);
$password_raw = htmlspecialchars($_POST['password']);

// hash the password
$password_hash = password_hash($password, PASSWORD_BCRYPT).'</pre>';

// create register date
date_default_timezone_set('America/Los_Angeles');
$dateTime = new DateTime();

// make a user array
$user_data = array(
    "email" => $email,
    "password" => $password_hash,
    "registered" => $dateTime->format('c')
);

$firebase->set(DEFAULT_PATH . '/' . $username, $user_data);

// $firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
// $firebase->set(DEFAULT_PATH . 

// Open DB connection
  // Create user in database
  // insert email for user
  // insert hashed password into database