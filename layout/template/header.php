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


    <div class="hero_area">
      <!-- header section strats -->
      <header class="header_section long_section px-0">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="<?php echo $app?>index.php">
            <span>
              EV Charging Point
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
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
                    <a class="nav-link" href="<?php echo $cont.'UserController.php?method=showLogin'?>">profile</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="<?php echo $cont.'UserController.php?method=showLogin'?>">Charging Details</a>
                  </li>

                <?php }?>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <!-- end header section -->
      <!-- slider section -->
      <section class="slider_section long_section">
        <div id="customCarousel" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="container ">
                <div class="row">
                  <div class="col-md-5">
                    <div class="detail-box">
                      <h1>
                        For All Your <br>
                        Furniture Needs
                      </h1>
                      <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minus quidem maiores perspiciatis, illo maxime voluptatem a itaque suscipit.
                      </p>
                      <div class="btn-box">
                        <a href="" class="btn1">
                          Contact Us
                        </a>
                        <a href="" class="btn2">
                          About Us
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="img-box">
                      <img src="images/slider-img.png" alt="">
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
                        For All Your <br>
                        Furniture Needs
                      </h1>
                      <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minus quidem maiores perspiciatis, illo maxime voluptatem a itaque suscipit.
                      </p>
                      <div class="btn-box">
                        <a href="" class="btn1">
                          Contact Us
                        </a>
                        <a href="" class="btn2">
                          About Us
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="img-box">
                      <img src="images/slider-img.png" alt="">
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
                        For All Your <br>
                        Furniture Needs
                      </h1>
                      <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minus quidem maiores perspiciatis, illo maxime voluptatem a itaque suscipit.
                      </p>
                      <div class="btn-box">
                        <a href="" class="btn1">
                          Contact Us
                        </a>
                        <a href="" class="btn2">
                          About Us
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="img-box">
                      <img src="images/slider-img.png" alt="">
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
      <!-- end slider section -->
    </div>
