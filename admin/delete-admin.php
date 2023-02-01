<?php include('../config/constants.php')?>
<?php include('../partials/menu.php') ?>


<?php 
    //1.get id of admin to be deleted
    $id=$_GET['id'];

    //2.create sql query to delete admin
    $sql="DELETE FROM tbl_admin WHERE id=$id";

        //execte query
        $res=mysqli_query($con,$sql);

        //check whethr query executed successfully
        if($res==TRUE)
        {
            //query exexcuted successfully, admin deleted
            //echo "Admin deleted!";
            //create session variable to display message
            $_SESSION['delete']="<div class='success'>Admin deleted succesfully!</div>";
            //redirect to manage-admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else{
            //failed to delete admin
            //echo "Failed to delete admin..";
            $_SESSION['delete']="<div class='error'>Failed to delete admin..</div>";
            //redirect to manage-admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }

    //3. redirect to manage-admin page with message (success/failure)
?>

