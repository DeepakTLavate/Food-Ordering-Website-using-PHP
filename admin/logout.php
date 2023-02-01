<?php include('../config/constants.php');?>

<?php
    //1.destroy session 
    session_destroy(); //unsets $_SESSION['user']

    //2.redirect to login page
    header('location:'.SITEURL.'admin/login.php');
?>