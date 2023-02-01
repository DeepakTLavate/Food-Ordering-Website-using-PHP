<?php
    //autorization or access control
    //check whether user is logged or not
    if(!isset($_SESSION['user'])) //if user session is not set
    {
        //user is not logged in
        //redirect to login page
        $_SESSION['no-login-message']="<div class='error'>Please Login to access Admin panel!</div>";
        header('location:'.SITEURL.'admin/login.php');
    }
?>