<?php

require('./vendor/ktamas77/firebase-php/src/firebaseInterface.php');
require('./vendor/ktamas77/firebase-php/src/firebaseLib.php');

const DEFAULT_URL = 'https://roi-dna.firebaseio.com/';
const DEFAULT_TOKEN = '7A8qQxH9HubZ117XYYJMQyvBqKELbNlfW7VCm7gu';
const DEFAULT_PATH = '';//'/firebase/example';

$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);

// // --- storing an array ---
// $user = array(
//     "email" => $email,
//     "password" => $password,
//     "id" => 42
// );

// date_default_timezone_set('America/Los_Angeles');
// $dateTime = new DateTime();
// $firebase->set(DEFAULT_PATH . '/' . $dateTime->format('c'), $test);

// // --- storing a string ---
// $firebase->set(DEFAULT_PATH . '/name/contact001', "John Doe");

// // --- reading the stored string ---
// $name = $firebase->get(DEFAULT_PATH . '/name/contact001');

// var_dump($firebase);
// var_dump($name);