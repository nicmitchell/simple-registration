<?php require(dirname(__FILE__). '/header.php'); ?>

<?php 
  if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['email'])){
    
    // Check for a user conflict
    $conflict = user_conflict($_POST);

    if (!empty($conflict)){
      // found a conflict
      echo '<small class="error">'.$conflict.'</small>';
    } else {
      // no conflict, register user
      $user = register_user($data);
    }

    // if user was created
    if(!empty($user)){
      // send Mandrill email
      // send_email($user);

      // update the view
      echo '<small class="alert-box success">Your account has been created</small>';

    } else {
      // user was not successfully created
      // update the view
    }
  }
?>

        <!-- Start Registration Form-->
        <form data-abide class="animated bounceInUp" action="" method="post" id="register">
          <fieldset>
            <legend>Registration</legend>
            <div class="name-field animated flipInX">
                <label>Username
                  <input type="text" placeholder="Jane Doe" name="username" required pattern="^[a-zA-Z_\-]+$">
                </label>
                <small class="error">Username cannot contain spaces, numbers, or special characters</small>
              </div>
            <div class="email-field animated flipInX">
              <label>Email
                <input type="email" placeholder="name@domain.com" name="email" required>
              </label>
              <small class="error animated rubberBand">An email address is required.</small>
            </div>
            <div class="password-field animated flipInX">
              <label>Password
                <input type="password" pattern="alpha_numeric" placeholder="LittleWomen" name="password" required>
              </label>
              <small class="error animated rubberBand">Your password must be alphanumeric with no special characters.</small>
            </div>
            <div class="confirm-password-field animated flipInX">
              <label>Confirm Password
                <input type="password" placeholder="LittleWomen" name="confirm-password" required data-equalto="password">
              </label>
              <small class="error animated rubberBand">Passwords must match.</small>
            </div>
            <button type="submit" class="register animated bounceIn">Register</button>
            <a href="reset.php" id="reset-link"><button type="button" class="reset animated bounceIn">Reset Password</button></a>
          </fieldset>
        </form>
        <!-- End Registration Form-->
<?php require(dirname(__FILE__). '/footer.php'); ?>