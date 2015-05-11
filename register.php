<?php

require(dirname(__FILE__) .'/vendor/ircmaxell/password-compat/lib/password.php');
require(dirname(__FILE__). '/vendor/mandrill/mandrill/src/Mandrill.php');
require(dirname(__FILE__). '/mandrill.php');
require(dirname(__FILE__). '/firebase.conf.php');

// get $_POST vars
$username = htmlspecialchars($_POST['username']);
$email = htmlspecialchars($_POST['email']);
$password_raw = htmlspecialchars($_POST['password']);

// hash the password
$password_hash = password_hash($password, PASSWORD_BCRYPT).'</pre>';

// create register date
date_default_timezone_set('America/Los_Angeles');
$dateTime = new DateTime();

// make a user array
$user_data = array(
    "username" => $username,
    "email" => $email,
    "password" => $password_hash,
    "registered" => $dateTime->format('c')
);

// Store the user data in Firebase
$firebase->set(DEFAULT_PATH . '/' . $username, $user_data);

// Send the email through Mandrill
send_email($user_data);

// $firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
// $firebase->set(DEFAULT_PATH . 
