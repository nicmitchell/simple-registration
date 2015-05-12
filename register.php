<?php require(dirname(__FILE__). '/header.php');

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
  // echo 'user not created';
}
?>


        <!-- Start Registration Form-->
        <form data-abide class="animated bounceInUp" action="register.php" method="post" id="register">
          <fieldset>
            <legend>Registration</legend>

            <?php if ($conflict): ?>
              <small class="error">Uh oh! A user with <?php echo $conflict; ?> has already been created.</small>
            <?php endif; ?>
            
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
            <a href="#" id="reset-link"><button type="button" class="reset animated bounceIn">Reset Password</button></a>
          </fieldset>
        </form>
        <!-- End Registration Form-->
        <!-- Start Reset Password Form-->
        <form data-abide class="animated bounceInUp" action="reset.php" method="post" id="reset">
          <fieldset>
            <legend>Reset Password</legend>
            <div class="name-field animated flipInX">
              <label>Username
                <input type="text" placeholder="Jane Doe" name="username" required pattern="^[a-zA-Z_\-]+$">
              </label>
              <small class="error">Username cannot contain spaces, numbers, or special characters</small>
            </div>
            <div class="password-field animated flipInX">
              <label>Current Password
                <input type="password" pattern="alpha_numeric" placeholder="LittleWomen" name="current-password" required>
              </label>
              <small class="error animated rubberBand">Your password must be alphanumeric with no special characters.</small>
            </div>
            <div class="confirm-password-field animated flipInX">
              <label>New Password
                <input type="password" placeholder="BigWomen" name="confirm-password" name="new-password" required>
              </label>
              <small class="error animated rubberBand">Your password must be alphanumeric with no special characters.</small>
            </div>
            <button class="reset animated bounceIn">Reset</button>
          </fieldset>
        </form>
        <!-- End Reset Password Form-->
      </section>
    </div>

  <footer class="column bottom-bar">Footer Stuff</footer>
  <script src="/bower_components/foundation/js/vendor/jquery.js"></script>
  <script src="/bower_components/foundation/js/vendor/fastclick.js"></script>
  <script src="/bower_components/foundation/js/foundation.js"></script>
  <script src="/bower_components/foundation/js/vendor/modernizr.js"></script>
  <script src="http://localhost:35729/livereload.js"></script>
  <script>
    $(document).foundation();
    $('#reset-link').on('click', function(){
      $('form#register').hide();
      $('form#reset').show();
    });
  </script>
  </body>
</html>