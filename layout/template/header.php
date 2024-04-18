<!DOCTYPE html>
<html>
	<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />

		<title><?php echo $pageTitle?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />

    
		<link rel="stylesheet" href="<?php echo $css?>bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $css?>font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo $css?>style.css" />
    <link rel="stylesheet" href="<?php echo $css?>responsive.css" />

    </head>
	
	<body>


    <div class="hero_area" <?php if(!isset($slider)) { echo "style='min-height:unset'"; } ?>>
      <!-- header section strats -->
      <header class="header_section long_section px-0">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="<?php echo $app?>index.php">
            <span>
              EV RECharging Point
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <div class="d-flex flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav  ">
                
                <li class="nav-item active">
                  <a class="nav-link" href="<?php echo $app?>index.php">Home</a>
                </li>

                <?php if(!isset($_SESSION['username'])) { ?>
                  <li class="nav-item">
                    <a class="nav-link" href="<?php echo $cont.'UserController.php?method=showLogin'?>">LogIn</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="<?php echo $cont.'UserController.php?method=showRegister'?>">SignUp</a>
                  </li>
                <?php } else {?>
                  <li class="nav-item">
                    <a class="nav-link" href="<?php echo $cont.'UserController.php?method=showProfile'?>">Profile</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="<?php echo $cont.'ChargingController.php?method=showChargingDetails'?>">Charging Details</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="<?php echo $cont.'UserController.php?method=logout'?>">Logout</a>
                  </li>

                <?php }?>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <!-- end header section -->
      <!-- slider section -->
      <?php if(isset($slider) && $slider == true): ?>
      <section class="slider_section long_section">
        <div id="customCarousel" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container ">
                <div class="row">
                  <div class="col-md-5">
                    <div class="detail-box">
                      <h1>
                        Efficient and Eco-Friendly Charging Solutions for Electric Cars
                      </h1>
                      <p style="text-align:justify">
                      Our recharging point for electric cars offers high-speed charging capabilities, allowing electric vehicle (EV) owners to quickly recharge their cars while on the go. With convenient access and reliable service, drivers can enjoy extended journeys with minimal downtime, contributing to a sustainable future.
                      </p>
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="img-box">
                      <img style="height: 500px;" src="<?php echo $imgs ?>cover1.jpg" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="container ">
                <div class="row">
                  <div class="col-md-5">
                    <div class="detail-box">
                      <h1>
                      Convenient Charging Stations for Electric Bicycles
                      </h1>
                      <p style="text-align:justify">
                      Our recharging point for e-bikes provides a convenient solution for urban commuters and recreational riders. Offering rapid charging options and strategically located in key areas, cyclists can easily top up their e-bike batteries, ensuring a seamless riding experience throughout the city.
                      </p>
                      
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="img-box">
                    <img style="height: 500px;" src="<?php echo $imgs ?>cover2.jpg" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="container ">
                <div class="row">
                  <div class="col-md-5">
                    <div class="detail-box">
                      <h1>
                          Fast and Flexible Charging Hubs for Electric Scooters
                      </h1>
                      <p style="text-align:justify">
                      Our recharging point for e-scooters offers fast and flexible charging solutions for urban mobility. With compact design and multiple charging ports, riders can quickly recharge their e-scooters while running errands or exploring the city, promoting sustainable transportation options.                      
                      </p>
                      
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="img-box">
                    <img style="height: 500px;" src="<?php echo $imgs ?>cover3.jpg" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <ol class="carousel-indicators">
            <li data-target="#customCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#customCarousel" data-slide-to="1"></li>
            <li data-target="#customCarousel" data-slide-to="2"></li>
          </ol>
        </div>
      </section>
      <?php else: ?>
        <section class="slider_section header-image">
          <div class="slider_section" style="background-color: rgb(153 153 153 / 67%);height: 500px;">
          <div class="container ">
                <div class="row">
                  <div class="col-12">
                    <div class="detail-box">
                      <h1 class="text-center">
                          <?php echo $pageTitle?>
                      </h1>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </section>
      <?php endif ?>
      <!-- end slider section -->
    </div>
