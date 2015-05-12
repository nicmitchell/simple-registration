<?php require(dirname(__FILE__). '/header.php'); ?>

        <div class="alert">
          <small class="alert-box success"></small>
          <small class="alert-box error animated rubberBand"></small>
        </div>
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
                <input type="password" pattern="alpha_numeric" placeholder="LittleWomen" name="confirm-password" data-equalto="password" required>
              </label>
              <small class="error animated rubberBand">Passwords must match.</small>
            </div>
            <button type="button" class="register animated bounceIn">Register</button>
            <a href="reset.php" id="reset-link"><button type="button" class="reset animated bounceIn">Reset Password</button></a>
          </fieldset>
        </form>
        <!-- End Registration Form-->
<?php require(dirname(__FILE__). '/footer.php'); ?>