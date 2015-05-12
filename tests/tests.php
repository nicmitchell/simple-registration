<?php

require_once(dirname(dirname(__FILE__)) .'/vendor/ircmaxell/password-compat/lib/password.php');
require_once(dirname(dirname(__FILE__)). '/mandrill.conf.php');
require_once(dirname(dirname(__FILE__)). '/firebase.conf.php');
require_once(dirname(dirname(__FILE__)). '/functions.php');

class RegisterUserTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){}
  public function tearDown(){}

  public $test_user = array(
      'username' => 'jackdoe12345',
      'password' => 'password',
      'email' => 'test@test.com'
  );
  
  /**
  * @test Sanity tests
  */
  public function testEmpty()
      {
          $stack = array();
          $this->assertEmpty($stack);
          return $stack;
      }

  /**
  * @test Can add users to database
  */
  public function test_user_success(){
    $this->assertTrue(register_user($this->test_user));
  }

  /**
  * @test Can determine a user conflict
  */
  public function test_username_conflict(){
    $user = array(
      'username' => 'jackdoe',
      'password' => 'password',
      'email' => 'qpeqproeiwurpq@qwpeoiruqweporiuqw.com'
    );
    $this->assertEquals('There is already a user registered with that username', user_conflict($user));
  }

  /**
  * @test Can determine an email conflict
  */
  public function test_email_conflict(){
    $user = array(
      'username' => 'qpoiueqroiupoupoqewurqwer',
      'password' => 'password',
      'email' => 'test@test.com'
    );
    $this->assertEquals('There is already a user registered with that email', user_conflict($user));

    // clean up the user we created
    $firebase = new \Firebase\FirebaseLib(FIREBASE_DEFAULT_URL, FIREBASE_DEFAULT_TOKEN);  
    $results = json_decode($firebase->get('/'), true);

    if(count($results) > 0){
      foreach ($results as $key => $value) {
        // username conflict
        if ($value['email'] === $user['email']){
          $firebase->delete($key);
        }
      }
    }
  }

  /**
  * @test Cannot reset an password with wrong password
  */
  public function test_password_reset_false(){  

    register_user($this->test_user);

    $user_reset_false = array(
      'username' => 'jackdoe12345',
      'current-password' => 'password12345',
      'new-password' => 'password1'
    );

    $this->assertFalse(reset_password($user_reset_false));
  }

  /**
  * @test Can reset a password with right password
  */
  public function test_password_reset_true(){
    $user_reset_true = array(
      'username' => 'jackdoe12345',
      'current-password' => 'password',
      'new-password' => 'password1'
    );

    $this->assertTrue(reset_password($user_reset_true));

    // clean up the user we created
    $firebase = new \Firebase\FirebaseLib(FIREBASE_DEFAULT_URL, FIREBASE_DEFAULT_TOKEN);  
    $results = json_decode($firebase->get('/'), true);

    if(count($results) > 0){
      foreach ($results as $key => $value) {
        // username conflict
        if ($value['email'] === $user['email']){
          $firebase->delete($key);
        }
      }
    }
  }

  /**
  * @test Password value was actually changed
  */
  public function test_password_reset_value(){

    $new_hashed_password = 'new';
    $current_hashed_password = 'new';

    // Create the user
    register_user($this->test_user);

    $firebase = new \Firebase\FirebaseLib(FIREBASE_DEFAULT_URL, FIREBASE_DEFAULT_TOKEN);  
    $results = json_decode($firebase->get('/'), true);

    // grab the current password hash
    if(count($results) > 0){
      foreach ($results as $key => $value) {
        if ($value['username'] === $this->test_user['username']){
          $current_hashed_password = $value['password'];
        }
      }
    }

    // reset the password
    $user_reset_true = array(
      'username' => 'jackdoe12345',
      'current-password' => 'password',
      'new-password' => 'password1'
    );    

    reset_password($user_reset_true);

    // grab the new password hash
    $results = json_decode($firebase->get('/'), true);

    if(count($results) > 0){
      foreach ($results as $key => $value) {
        if ($value['username'] === $this->test_user['username']){
          $new_hashed_password = $value['password'];
        }
      }
    }

    $this->assertNotEquals($new_hashed_password, $current_hashed_password);

    // clean up the user we created
    $firebase = new \Firebase\FirebaseLib(FIREBASE_DEFAULT_URL, FIREBASE_DEFAULT_TOKEN);  
    $results = json_decode($firebase->get('/'), true);

    if(count($results) > 0){
      foreach ($results as $key => $value) {
        // username conflict
        if ($value['email'] === $user['email']){
          $firebase->delete($key);
        }
      }
    }
  }

}

