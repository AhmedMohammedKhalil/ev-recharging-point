<?php
	ob_start();
    session_start();
	$pageTitle = 'User Profile';
	include 'init.php';
  include $tmp.'header.php';
?>

<section class="blog_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          User Profile
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="<?php echo $imgs ?>user.jpg" alt="">
            </div>
            <div class="detail-box">
              <h5>Name : <?php echo $_SESSION['user']['name'] ?></h5>
              <h5>Account Number : <?php echo $_SESSION['user']['account_number'] ?></h5>
              <h5>Pin : <?php echo $_SESSION['user']['pin'] ?></h5>
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