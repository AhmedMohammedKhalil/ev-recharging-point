<?php
	ob_start();
	session_start();
	$pageTitle = 'Create Charging';
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
                Create Charging
              </h2>
            </div>
            <form action="<?php echo $cont."UserController.php?method=createCharging"?>" method="POST" class="form">
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
                <label for="power_init">Your Car Power</label>
                <input type="number" min="0.01" step="0.01" name="power_init" id="power_init" title="Enter Your Car Power" placeholder="Enter Your Car Power" required
                  value="<?php if(isset($_SESSION['errors'])) echo $power_init?>">
              </div>
              <div>
                <label for="vehicle_type">Choose Vehicle Type:</label>
                <div class="flex" style="display:flex">

                <label for="car"><input type="radio" name="vehicle_type" value="car" id="car">Car</label>
                  <label for="e-bike"><input type="radio" name="vehicle_type" value="e-bike" id="e-bike">E-Bike</label>
                  <label for="e-scooter"><input type="radio" name="vehicle_type" value="e-scooter" id="e-scooter">E-Scooter</label>
                </div>
              </div>
              <div>
                <label for="charging_bay">Choose Charging Bay:</label>
                <div class="flex" style="display:flex">
                    <?php
                        // Generate options for charging bays
                        for ($i = 1; $i <= 10; $i++) {
                              echo "<label for='bay$i'><input type='radio' name='charging_bay' value='$i' id='bay$i'>$i</label>";
                        }
                    ?>
                </div>
              </div>
              <div>
                <label for="charge_duration">Charge Duration</label>
                <input type="text" name="charge_duration" id="charge_duration" title="Enter Charge Duration by Hours ex: 15m = 0.25" placeholder="Enter Charge Duration by Hours ex: 15m = 0.25" required
                  value="<?php if(isset($_SESSION['errors'])) echo $charge_duration?>">
              </div>

              <div>
                <label for="payment_type">Choose Payment Type:</label>
                <div class="flex" style="display:flex">
                  <label for="on-account"><input type="radio" name="payment_type" value="on-account" id="on-account">On Account</label>
                  <label for="contactless-card-interaction"><input type="radio" name="payment_type" value="contactless-card-interaction" id="contactless-card-interaction">Contactless Card Interaction</label>
                </div>
              </div>
              <div class="btn_box">
                <button type="submit" name="create_charging">
                  Create
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