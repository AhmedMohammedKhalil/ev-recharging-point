<?php
	ob_start();
	session_start();
	$pageTitle = 'User Login';
	include 'init.php';
	include $tmp.'header.php';
  if(isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    $oldData = $_SESSION['oldData'];
    extract($oldData);
  }
?>



<section class="contact_section long_section">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <div class="heading_container">
              <h2>
                User LogIn
              </h2>
            </div>
            <form action="<?php echo $cont."UserController.php?method=login"?>" method="POST" class="form">
              <?php
                if(isset($_SESSION['errors'])) {
                  echo '<ol style="width:fit-content;margin: 0 auto">';
                  foreach($errors as $e) {
                    echo '<li style="color: red">'.$e.'</li>';
                  }
                  echo '</ol>';
                }
              ?>
              <div>
                <label for="account_number">Account Number</label>
                <input type="account_number" name="account_number" id="account_number" title="Enter Account Number with 10 digits" placeholder="Enter Account Number with 10 digits" required
                  value="<?php if(isset($_SESSION['errors'])) echo $account_number?>">
              </div>
              <div>
                  <label for="pin">Pin</label>
                  <input type="pin" name="pin" id="pin" title="Enter pin with 6 digits" placeholder="Enter pin with 6 digits" required>
              </div>
              <div>
                  <span>if don't have account <a href="<?php echo $cont.'UserController.php?method=showRegister'?>">Make Register</a></span>
              </div>
              <div class="btn_box">
                <button type="submit" name="user_login">
                  Login
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>

	
<?php
	include $tmp . 'footer.php';
	ob_end_flush();
  unset($_SESSION['oldData']);
  unset($_SESSION['errors']);
?>