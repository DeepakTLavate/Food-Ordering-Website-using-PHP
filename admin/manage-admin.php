<?php include('../config/constants.php') ?>

<!-- following dry pattern-do not repeat yourself -->
<html>
    <head>
        <title>Food-order website - Home Page</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <!-- Menu Section starts -->
        <div class="menu text-center">
            <div class="wrapper">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="manage-admin.php">Admin</a></li>
                    <li><a href="manage-category.php">Category</a></li>
                    <li><a href="manage-food.php">Food</a></li>
                    <li><a href="manage-order.php">Order</a></li>
                </ul>
            </div>
        </div>
        <!-- Menu Section ends -->

        <!-- Main content Section starts -->
        <div class="main">
            <div class="wrapper">
                <h1>Manage Admin</h1>
                <br>
                <br>

                <?php
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];//display session message
                        unset($_SESSION['add']); //removing session message
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['user_not_found']))
                    {
                        echo $_SESSION['user_not_found'];
                        unset($_SESSION['user_not_found']);
                    }

                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo $_SESSION['pwd-not-match'];
                        unset($_SESSION['pwd-not-match']);
                    }

                    if(isset($_SESSION['change-pwd']))
                    {
                        echo $_SESSION['change-pwd'];
                        unset($_SESSION['change-pwd']);
                    }

                    
                ?>
                <br><br>
                <!-- button to add admin -->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>
                <br>
                <br>

                <table class="tbl-full">
                    <tr>
                        <th>Sr.No.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        //query to get admin info from database
                        $sql="SELECT * FROM tbl_admin";
                        $res=mysqli_query($con,$sql);

                        //check whether query is executed or not
                        if($res==TRUE)
                        {
                            //count rows to check if we have data in db
                            $count=mysqli_num_rows($res); //function to get number of rows in db

                            $sn=1; //variable to maintain flow of sr no because if a row is 
                            //deleted from db, then its sr no is also deleted like 1 2 4 5...,3 is deleted
                            
                            //check number of rows
                            if($count>0)
                            {
                                //we have data in db
                                while($rows=mysqli_fetch_assoc($res)) //this funcn will get data from rows using while loop
                                {
                                    //get individual data
                                    $id=$rows['id'];
                                    $full_name=$rows['full_name'];
                                    $username=$rows['username'];

                                    //display values in table
                                    ?>

                                    <tr>
                                        <td><?php echo $sn++ ?></td>
                                        <td><?php echo $full_name ?></td>
                                        <td><?php echo $username ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL ?>admin/update-password.php? id=<?php echo $id ?>" class="btn-primary">Change Password</a>
                                            <a href="<?php echo SITEURL ?>admin/update-admin.php? id=<?php echo $id ?>" class="btn-secondary">Update Admin</a>
                                            <a href="<?php echo SITEURL ?>admin/delete-admin.php? id=<?php echo $id ?>" class="btn-danger">Delete Admin</a>
                                        </td>
                                    </tr>   

                                    <?php
                                }
                            }
                            else{
                                //we dont have data in db
                            }
                        }
                    ?>

                    

                    
                </table>
                <div class="clear-fix"></div>
            </div>
            
        </div>
        <!-- Main content Section ends -->

<?php include('partials/footer.php'); ?>