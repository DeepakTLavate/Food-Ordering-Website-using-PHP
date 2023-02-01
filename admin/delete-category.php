<?php include('../config/constants.php')?>

<?php 
    //echo "Delete Page"
    //check whether id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get value and delete
        //echo "Get value";
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //remove physical image file if available
        if($image_name!="")
        {
            //image is available,remove it
            $path="../images/category/".$image_name;
            //remove image
            $remove=unlink($path); //unlink is built in funcn which removes the image from category folder
                                   //it has boolean output
                if($remove==FALSE) //failed to remove image then add error message and stop process
                {
                    //set session message
                    $_SESSION['remove']="<div class='error'>Failed to remove category image!</div>";
                    //redirect to manage -category
                    header('location:'.SITEURL.'admin/manage-category.php');
                    //stop process
                    die();
                }
        }

        //then only delete data from db
        $sql="DELETE FROM tbl_category WHERE id=$id"; //sql query 
        $res=mysqli_query($con,$sql); //executing query
        if($res==TRUE) //checking if data is deleted from db
        {
            //set success message and redirect
            $_SESSION['delete']="<div class='success'>Deleted Category Successfully!</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else{
            //set failed message and redirct
            $_SESSION['delete']="<div class='error'>Deletion of Category Failed!</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        //redirect to manage-category page with message
    }
    else{
        //redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>