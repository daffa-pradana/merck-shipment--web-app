<?php
    session_start();
    // Redirect functions
    require "redirect.php";
    //Logout
    if(isset($_GET['logout'])) {
        session_destroy();
        // Redirect
        red_custom("../index.php");
    }
?>