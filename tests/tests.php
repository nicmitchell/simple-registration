<?php

require_once(dirname(dirname(__FILE__)) .'/vendor/ircmaxell/password-compat/lib/password.php');
require_once(dirname(dirname(__FILE__)). '/mandrill.conf.php');
require_once(dirname(dirname(__FILE__)). '/firebase.conf.php');
require_once(dirname(dirname(__FILE__)). '/functions.php');

class RegisterUserTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){}
  public function tearDown(){}

  // Sanity test
  public function testEmpty()
      {
          $stack = array();
          $this->assertEmpty($stack);

          return $stack;
      }

  // Can add users to database
  public function test_user_success(){
    $user = array(
      'username' => 'jackdoe12345',
      'password' => 'password',
      'email' => 'test@test.com'
    );

    $this->assertTrue(register_user($user));
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

}
