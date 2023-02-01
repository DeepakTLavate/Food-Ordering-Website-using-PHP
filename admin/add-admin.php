<?php include('partials/menu.php'); ?>

<div class="main">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br>

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];//display session message
                unset($_SESSION['add']); //removing session message
            }
        ?>
        <!-- post method is used to submit data from form without being shown to the browser -->
        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td><input type="text" name="full_name" placeholder="Enter your good name"></td>
                </tr>
                
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" placeholder="Enter your username"></td>
                </tr>
                
                <tr>
                    <td>Password</td>
                    <!-- for input type password, the entered value is hidden -->
                    <td><input type="password" name="password" placeholder="Enter your password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php 
    //process value from form and save it in database
    //check whether submit button is clicked
    if(isset($_POST['submit']))
    {
        // button is clicked
        
        //get data from form
        $full_name=$_POST['full_name'];
        $username=$_POST['username'];
        $password=md5($_POST['password']); //encryption using md5

        //sql query to set data into database
        $sql="INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

        //execute query and set data into database
        
        //executing query and saving data into database
        $res=mysqli_query($con,$sql) or die(mysqli_error());

        //check whether query is executed or not ,data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            //create a session variable to display success message
            $_SESSION['add']="<div class='success'>Admin added successfully!</div>";

            //redirect page to manage-admin page
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else{
            //create a session variable to display success message
            $_SESSION['add']="<div class='error'>Failed to add admin..</div>";

            //redirect page to add-admin page
            header('location:'.SITEURL.'admin/add-admin.php');
        }

    }
    
?>