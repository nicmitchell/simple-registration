<?php require(dirname(__FILE__). '/header.php'); ?>

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

<?php require(dirname(__FILE__). '/footer.php'); ?>