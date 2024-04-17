<?php
	ob_start();
    session_start();
	$pageTitle = 'User Profile';
	include 'init.php';
  include $tmp.'header.php';
?>
    <?php if(isset($_SESSION['msg'])) { ?>
        <p style="color:black;background:#8bfa8b;padding:20px;margin:0">
            <?php 
                echo $_SESSION['msg'] ;
                unset($_SESSION['msg']);
            ?>
        </p>
    <?php } ?>
    <div class="section" id="User-profile">
      <div class="container">
        <h2 class="special-heading">User Profile</h2>
        <div class="kids-info flex">
          <h3>Name : <?php echo $_SESSION['user']['name'] ?></h3>
          <h3>Email : <?php echo $_SESSION['user']['email'] ?></h3>
          <h3>Email : <?php echo $_SESSION['user']['phone'] ?></h3>
          <h3>Email : <?php echo $_SESSION['user']['phone'] ?></h3>
          
          <div class="flex" style="flex-direction: row;">
            <a class="button" href="<?php echo $cont.'UserController.php?method=showSettings' ?>" 
            style="margin: 10px;">Settings</a>

          </div>
        </div>
      </div>
  </div>
<?php
	include $tmp . 'footer.php'; 
	ob_end_flush();

?>