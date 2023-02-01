<?php include('partials/menu.php');?>

<div class="main">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
            //check whether id is set or not
            if(isset($_GET['id']))
            {
                //get id and all other details
                // echo "getting the data";

                $id=$_GET['id'];

                //create sql query to get all details
                $sql="SELECT * FROM tbl_category WHERE id=$id";
                $res=mysqli_query($con,$sql); //execution
                //count rows to check whether id is valid or not
                $count=mysqli_num_rows($res);
                //check if query successfull or not
                if($count==1)
                {
                    //get data
                    $row=mysqli_fetch_assoc($res);
                    $title=$row['title'];
                    $current_image=$row['image_name'];
                    $featured=$row['featured'];
                    $active=$row['active'];
                }
                else{
                    //redirect to manage category with session mesage
                    $_SESSION['no-category-found']="<div class='error'>No Such Category Found!</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
            else{
                //redirct
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title;?>">
                </td>
            </tr>

            <tr>
                <td>Current Image: </td>
                <td>
                    <?php
                        if($current_image!="")
                        {
                            //display image
                            ?>

                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image;?>" width="250px"alt="">

                            <?php
                        }
                        else{
                            //display message
                            echo "<div class='error'>No Image added for this category!</div>";
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td>New Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Featured: </td>
                <td>
                    <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                    <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                    <input  <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                    <input  <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                </td>    
            </tr>
        </table>
        </form>

        <?php
            //check if button is clicked
            if(isset($_POST['submit']))
            {
                // echo "Clicked";
                //1.get all values from form
                $id=$_POST['id'];
                $title=$_POST['title'];
                $current_image=$_POST['current_image'];
                $featured=$_POST['featured'];
                $active=$_POST['active'];

                //2.updating image with new image 
                    //check if image is selected or not
                    if(isset($_FILES['image']['name']))
                    {
                        //get image details
                        $image_name=$_FILES['image']['name'];

                        //check if image available or not
                        if($image_name!="")//img available
                        {
                            //we clicked on upload image and selected new image
                            //A.Upload NEW IMAGE
                            //auto rename image
                            //get extension of our image(jpg,png,...)eg.food1.png
                            $ext=end(explode('.',$image_name));
                            //rename image 
                            $image_name="Food_Category_".rand(000,999).'.'.$ext;
                        

                            $source_path=$_FILES['image']['tmp_name'];
                            $destination_path="../images/category/".$image_name;

                            //finally upload image
                            $upload=move_uploaded_file($source_path,$destination_path);

                            //check whether image is uploaded or not
                            //if not uploaded,stop the process and redirect with error message
                            if($upload==FALSE)
                            {
                                //set message
                                $_SESSION['upload']="<div class='error'>Failed to upload Image!</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                //stop process
                                die(); //so that data is not added to database
                            }

                            //B.REMOVE CURRENT IMAGE if available
                            if($current_image!="")
                            {
                                $remove_path="../images/category/".$current_image;
                                $remove=unlink($remove_path);  //returns boolean result
    
                                    //check whether image removed or not
                                    //if failed,stop process
                                    if($remove==false)
                                    {
                                        //failed to remove image
                                        $_SESSION['failed-remove']="<div class='error'>Failed to remove Current Image !</div>";
                                        header('location:'.SITEURL.'admin/manage-category.php');
                                        die();
                                    }
                            }
                           
                            
                        }
                        else{
                            //we clicked on upload image but didnt select image
                            //so,$FILES is set but we dont want to change image
                            $image_name=$current_image;
                        }
                    }
                    else{
                        //if no image earlier, then current image will be new image
                        $image_name=$current_image;
                    }

                //3.Update db
                $sql2="UPDATE tbl_category SET 
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
                WHERE id=$id
                ";
                    //execute query
                    $res2=mysqli_query($con,$sql2);

                //4.redirect to manage-category with message
                    //check if query executed or not
                    if($res2==TRUE)
                    {
                        $_SESSION['update']="<div class='success'>Category updated successfully !</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                    else{ //updation failed
                        $_SESSION['update']="<div class='error'>Category updation failed !</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php');?>