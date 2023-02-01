<?php include('partials/menu.php')?>

<div class="main">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php
            //getting details of current admin to update
            //step1:get id of selected admin
            $id=$_GET['id'];

            //step2:create sql query to get details
            $sql="SELECT * FROM tbl_admin WHERE id=$id";

            //execute query
            $res=mysqli_query($con,$sql);

            //check if query is executed
            if($res==TRUE)
            {
                //check whether data is available
                $count=mysqli_num_rows($res);
                //check if we have admin data
                if($count==1)
                {
                    //get details
                    //echo "Admin available";
                    $row=mysqli_fetch_assoc($res);

                    $full_name=$row['full_name'];
                    $username=$row['username'];
                }
                else{
                    //redirect to manage admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        ?>
        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name ;?>">
                    </td>
                </tr>

                <tr>
                    <td>UserName</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username ;?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
    //check whether submit button clicked or not
    if(isset($_POST['submit']))
    {
        //echo "Button clicked";
        //get all values from form to update
        $id=$_POST['id'];
        $full_name=$_POST['full_name'];
        $username=$_POST['username'];

        //create sql query to update admin
        $sql="UPDATE tbl_admin SET
        full_name='$full_name',
        username='$username'
        WHERE id='$id'
        ";

        //execute query
        $res=mysqli_query($con,$sql);

        //check query executed sucesfully or not
        if($res==TRUE)
        {
            //query executed and admin updated
            $_SESSION['update']="<div class='success'>Admin Updated Succesfully!</div>";
            //redirect to manage admin
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else{
            //updation failed
            //query executed and admin updated
            $_SESSION['update']="<div class='error'>Admin Updation Failed!</div>";
            //redirect to manage admin
            header('location:'.SITEURL.'admin/manage-admin.php');
        }

    }
?>

<?php include('partials/footer.php')?>