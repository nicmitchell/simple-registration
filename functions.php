<?php

// Checks to see if a user already exists
function user_conflict($data) {
  // data should be $_POST vars
  $firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
  
  $username = trim($firebase->get($data['username'].'/username', '"'));
  $email = trim($firebase->get($data['username'].'/email', '"'));

  // username conflict
  if ($username !== 'null') {
    $result = 'There is already a user registered with that username';

  // email conflict
  } elseif ($email !== 'null') {
    // Doesn't currenlty work. Have to iterate through all users to check each email
    $result = 'There is already a user registered with that email';
    
  // no user or email conflicts
  } else {
    $result = false;
  }

  return $result;
}

// Registers user and inserts into Firebase
function register_user($data) {

  // data should be $_POST vars
  $username = htmlspecialchars(trim($data['username']));
  $email = htmlspecialchars(trim($data['email']));
  $password_raw = htmlspecialchars(trim($data['password']));

  // hash the password
  $password_hash = password_hash($password_raw, PASSWORD_BCRYPT);

  // create register date
  
  $dateTime = new DateTime();

  // make a user array
  $user_data = array(
      "username" => $username,
      "email" => $email,
      "password" => $password_hash,
      "registered" => $dateTime->format('c')
  );

  // Store the user data in Firebase
  $firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
  $firebase->set($username, $user_data);

  // Make sure the user was created
  $user = $firebase->get($username);

  if($user->email){
    return $user_data;
  } else {
    return false;
  }
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

  // data should be $_POST vars
  $username = htmlspecialchars(trim($data['username'])); // janedoe
  $password_raw = htmlspecialchars(trim($data['password'])); // password

  // get current hashed password for user
  $firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
  $current_password = trim($firebase->get($username .'/password'), '"');

  // Verify passwords match
  if (password_verify($password_raw, $current_password)) {

    // passwords match
    $password_hash = password_hash($password_raw, PASSWORD_BCRYPT);
    $firebase->set($username .'/password', $password_hash);
    return true;
    // echo 'Your password has been reset';
  } else {

    // passwords do not match
    // echo 'Invalid password.';
    return false;
  }
}