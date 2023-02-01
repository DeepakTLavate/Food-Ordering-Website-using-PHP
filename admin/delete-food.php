<?php include('../config/constants.php')?>

<?php 
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //process to delete
        // echo "Process to delete";

        //1.get id and image name
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //2.remove image if available
            //check if image is available
            if($image_name!="") //we have image
            {
                $path="../images/Food/".$image_name; //path of image to be deleted

                $remove=unlink($path); //remove image file from our folder

                if($remove==false) //image removal failed
                {
                    $_SESSION['removed']="<div class='error'>Failed to remove Food Image !</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                    die(); //stop process of deleting food
                }
            }

        //3.delete food frim db and redirect
        $sql="DELETE FROM tbl_food WHERE id=$id";
        $res=mysqli_query($con,$sql);
        if($res==true)
        {
            $_SESSION['removal']="<div class='success'>Food Deleted Successfully !</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else{
            $_SESSION['removal']="<div class='error'>Food Deletion Failed !</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
    else{
        //unauthorized deletion attempt
        // echo "redirect";
        $_SESSION['delete']="<div class='error'>Unauthorized Deletion Attempt !</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>