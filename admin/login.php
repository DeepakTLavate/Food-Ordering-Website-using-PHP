<?php include('../config/constants.php');?>

<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <div class="login ">
            <h1 class="text-center">Login</h1><br>

            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?><br>

            <!-- Login form starts here -->
                <form action="" method="POST" >
                    Username:
                    <input type="text" name="username" placeholder="Enter username"><br><br>

                    Password:
                    <input type="password" name="password" placeholder="Enter password"><br>

                    <br>
                    <input type="submit" name="submit" value="Login" class="btn-primary"><br>
                </form>
            <!-- Login form ends here -->
            <br>
            <p class="text-center">Created by Deepak</p>
        </div>    
    </body>
</html>

<?php
    //check if button is clicked
    if(isset($_POST['submit']))
    {
        //process for login
        //1.get data from login form
        $username=$_POST['username'];
        $password=md5($_POST['password']);

        //2.sql query to match given data to data in db
        $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3.execute query
        $res=mysqli_query($con,$sql);

        //count rows to check if user exists
        $count=mysqli_num_rows($res);
        
        if($count==1){
            //at least one user
            $_SESSION['login']="<div class='success'>Login Successfull!</div>";
            $_SESSION['user']=$username; //check if user is logged in or not and logout will unset
            //redirect to home page
            header('location:'.SITEURL.'admin/index.php');
        }
        else{
            //user not available
            $_SESSION['login']="<div class='error'>Login Failed! Please Retry..</div>";
            //redirect to home page
            header('location:'.SITEURL.'admin/login.php');
        }
        

    }
?>