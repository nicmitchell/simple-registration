<?php

// Checks to see if a user already exists
function user_conflict($data) {

  $firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);  
  $results = json_decode($firebase->get('/'), true);

  if(count($results) > 0){
    foreach ($results as $key => $value) {
      // username conflict
      if ($value['username'] === $data['username']){
        return 'There is already a user registered with that username';
      }
      // email conflict
      if ($value['email'] === $data['email']){
        return 'There is already a user registered with that email';
      }
    }
  }

  // no user or email conflicts
  return false;
}

// Registers user and inserts into Firebase
function register_user($data) {

  // create register date
  date_default_timezone_set('America/Los_Angeles');
  $dateTime = new DateTime();

  // hash the password
  $password_hash = password_hash(htmlspecialchars(trim($data['password'])), PASSWORD_BCRYPT);

  // make a user array
  $user_data = array(
    'username' => htmlspecialchars(trim($data['username'])),
    'email' => htmlspecialchars(trim($data['email'])),
    'password' => $password_hash,
    'registered' => $dateTime->format('c')
  );

  // Store the user data in Firebase
  $firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
  $key = json_decode($firebase->push('/', $user_data), true);

  // make sure it was saved
  if(!empty($key['name'])){
    return true;
  }
  // something went wrong
  return false;
}

// Send email to user via Mandrill after registration
function send_email($data){
  try {
  $mandrill = new Mandrill(MANDRILL_API_KEY);
  $message = array(
    'subject' => 'Registration successful',
    'from_email' => 'registration@domain.com',
    'to' => array(array(
    'email' => $data['email'], 
    'name' => $data['username']
    )),
    'merge_vars' => array(array(
    'rcpt' => $data['email'],
    'vars' =>
    array(array(
      'name' => 'USERNAME',
      'content' => $data['username']
    ))
    ))
  );

  $template_name = 'Stationary';

  $template_content = array(array(
    'name' => 'main',
    'content' => 'Hi *|USERNAME|*, thanks for signing up.')
  );

  // Send the message
  $mandrill->messages->sendTemplate($template_name, $template_content, $message);
  // print_r($mandrill->messages->sendTemplate($template_name, $template_content, $message));

  } catch(Mandrill_Error $e) {

  // Mandrill errors are thrown as exceptions
  echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
  
  // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
  throw $e;
  }
}

// Reset a user's password
function reset_password($data) {

  $firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);  
  $results = json_decode($firebase->get('/'), true);

  if(count($results) > 0) {
    foreach ($results as $key => $value) {

      // found the user
      if ($value['username'] === $data['username']) {
        // Verify passwords match
        $password_hash = password_hash($data['current-password'], PASSWORD_BCRYPT);
        if (password_verify($data['current-password'], $value['password'])) {
          $password_hash = password_hash($data['new-password'], PASSWORD_BCRYPT);
          $firebase->set($key . '/password', $password_hash);
          return true;
        }
      }
    }
  }
  // passwords do not match or could not be found
  return false;
}