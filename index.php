<?php
    ob_start();
    session_start();
    include('init.php');
    $pageTitle = "Home";
    include($tmp.'header.php');
    include_once('layout/functions/functions.php');
?>





    <?php
    include($tmp.'footer.php');
    ob_end_flush();
