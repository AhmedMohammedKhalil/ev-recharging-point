<?php
    ob_start();
    session_start();
    $slider = true;
    include('init.php');
    $pageTitle = "Home";
    include($tmp.'header.php');
    include_once('layout/functions/functions.php');
?>

<section class="about_section layout_padding long_section">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="img-box">
            <img src="<?php echo $imgs ?>aboutus.jpg" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                About Us
              </h2>
            </div>
            <p style="text-align:justify">
            At our company, we are dedicated to promoting sustainable mobility solutions through our innovative EV charging infrastructure. With a commitment to reliability, accessibility, and environmental stewardship, we strive to empower communities to embrace electric vehicles and reduce carbon emissions. Our team is passionate about creating a cleaner and greener future for generations to come            </p>
          </div>
        </div>
      </div>
    </div>
  </section>




    <?php
    include($tmp.'footer.php');
    ob_end_flush();
