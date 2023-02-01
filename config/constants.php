

<?php

    //start session
    session_start();


    //create constants
    define('SITEURL','http://localhost/food-order/');
    define('LOCALHOST','localhost:3308');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','food_order');

    $con=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error()); //database connection
    $db_select=mysqli_select_db($con,DB_NAME) or die(mysqli_error());
?>