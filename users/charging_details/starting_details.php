<?php
	ob_start();
    session_start();
	$pageTitle = 'Charging Details';
	include 'init.php';
    include $tmp.'header.php';
    $vehicle_type = strtoupper($_SESSION['charging_details']['vehicle_type']); 
    $payment_type = strtoupper(str_replace('-',' ',$_SESSION['charging_details']['payment_type'])); 
?>

<section class="blog_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Charging Details
        </h2>
      </div>
      <div class="row">
        <div class="col-md-8 col-lg-8 mx-auto" >
          <div class="box" style="padding-bottom:20px">
            <div class="img-box">
              <img style="height: 500px;" src="<?php echo $imgs ?>recharge.jpg" alt="">
            </div>
            <div class="detail-box">
              <h5>Vehicle Type : <?php echo $vehicle_type ?></h5>
              <h5>Car Power  : <?php echo $_SESSION['charging_details']['power_init']." KW" ?></h5>
              <h5>Charging Bay : <?php echo $_SESSION['charging_details']['charging_bay'] ?></h5>
              <h5>Charging Duration : <?php echo $_SESSION['charging_details']['charge_duration']." Hours" ?></h5>
              <h5>Payment Type : <?php echo $payment_type ?></h5>
            </div>
            <div>
                <a class="custom_btn" href="<?php echo $cont."ChargingController.php?method=startCharging"?>">Start Charging</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php
	include $tmp . 'footer.php'; 
	ob_end_flush();

?>