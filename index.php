<!DOCTYPE html>
  <head>  
    <title>Please Register for ROI-DNA</title>
    <link rel="stylesheet" href="/bower_components/foundation/css/foundation.min.css">
    <link rel="stylesheet" href="/bower_components/foundation/css/normalize.min.css">
    <link rel="stylesheet" href="/bower_components/animate.css/animate.min.css">
    <link rel="stylesheet" href="/css/custom.css">
  </head>
  <body>
    <header>
      <nav class="top-bar" data-topbar role="navigation">
        <ul class="title-area">
          <li class="name">
            <h1><a href="#">Register for ROI-DNA</a></h1>
          </li>
        </ul>
      </nav>
    </header>
    <div class="row">
      <section class="main small-6 small-centered columns">
        <img class="animated fadeInDown logo" src="http://www.roidna.com/wordpress/wp-content/themes/roidna/imgs/logo-white.svg">
        <form data-abide class="animated bounceInUp" action="register.php" method="post">
          <fieldset>
            <legend>Registration</legend>
            <div class="name-field animated flipInX">
                <label>Your name <small>required</small>
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
                <input type="password" placeholder="LittleWomen." name="confirm-password" required data-equalto="password">
              </label>
              <small class="error animated rubberBand">Passwords must match.</small>
            </div>
            <button type="submit" class="register animated bounceIn">Register</button>
            <button type="submit" class="reset animated bounceIn">Reset Password</button>
          </fieldset>
        </form>
      </section>
  </div>

    <footer class="column bottom-bar">Footer Stuff</footer>
  <script src="/bower_components/foundation/js/vendor/jquery.js"></script>
  <script src="/bower_components/foundation/js/vendor/fastclick.js"></script>
  <script src="/bower_components/foundation/js/foundation.js"></script>
  <script src="/bower_components/foundation/js/vendor/modernizr.js"></script>
  <script src="http://localhost:35729/livereload.js"></script>
  <script>$(document).foundation();</script>
  </body>
</html>