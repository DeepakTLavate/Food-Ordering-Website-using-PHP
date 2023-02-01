<?php include('partials/menu.php')?>

<div class="main">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }
        ?>

        <form action="" method="POST">
            <table class='tbl-30'>
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Enter current password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="Enter new password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id ;?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
    //check whether button clicked or not
    if(isset($_POST['submit']))
    {
        //echo "clicked";
        //step 1:get data from form
        $id=$_POST['id'];
        $current_password=md5($_POST['current_password']);
        $new_password=md5($_POST['new_password']);
        $confirm_password=md5($_POST['confirm_password']);

        //step2: check whether current user exists or not
        $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
            //execute query
            $res=mysqli_query($con,$sql);
            if($res==TRUE)
            {
                //check data available or not
                $count=mysqli_num_rows($res);
                if($count==1)
                {
                    //user exists and password can be changed

                    //check if new and confirm pass match
                    if($new_password==$confirm_password)
                    {
                        //update password
                        $sql2="UPDATE tbl_admin SET
                        password='$new_password'
                        WHERE id=$id
                        ";

                        //execute query
                        $res2=mysqli_query($con,$sql2);

                        //check query executed or not
                        if($res2==TRUE)
                        {
                            //display success
                            $_SESSION['change-pwd']="<div class='success'>Password Changed Successfully!</div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');

                        }
                        else{
                            //display error
                            $_SESSION['change-pwd']="<div class='error'>Password Change Failed!</div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                    }
                    else{
                        //redirect to manage admin
                        $_SESSION['pwd-not-match']="<div class='error'>Password Not Matched!</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else{
                    //user doesnt exist and redirect
                    $_SESSION['user_not_found']="<div class='error'>User Not Found!</div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }

        //step3:new pass==confirm pass

        //step4: change pass if all above is true
    }
?>

<?php include('partials/footer.php')?>