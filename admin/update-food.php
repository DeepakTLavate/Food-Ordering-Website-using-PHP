<?php include('partials/menu.php');?>

<?php
    //check whether id is set
    if(isset($_GET['id']))
    {
        //get all details
        $id=$_GET['id'];

        $sql2="SELECT * FROM tbl_food WHERE id=$id";
        $res2=mysqli_query($con,$sql2);
        
        //get values from query in an array
        $row2=mysqli_fetch_assoc($res2);

        $title=$row2['title'];
        $description=$row2['description'];
        $price=$row2['price'];
        $current_image=$row2['image_name'];
        $current_category=$row2['category_id'];
        $featured=$row2['featured'];
        $active=$row2['active'];

    }
    else{ //redirect
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>

<div class="main">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title?>" placeholder="Enter food title">
                    </td>
                </tr>

                <tr>
                    <td>Food Description: </td>
                    <td>
                        <textarea name="description"  cols="30" rows="5"><?php echo $description;?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" value="<?php echo $price;?>" name="price" >
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image=="") //image not uploaded earlier
                            {
                                echo "<div class='error'>No image added earlier !</div>";
                            }
                            else{  //image available
                                ?>

                                <img src="<?php echo SITEURL;?>images/Food/<?php echo $current_image; ?>" width="150px" >

                                <?php
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category" >
                            <?php
                                //query to get active categories
                                $sql="SELECT * FROM tbl_category WHERE active='Yes'";
                                $res=mysqli_query($con,$sql);
                                $count=mysqli_num_rows($res);
                                if($count>0)  //categories available
                                {
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $category_title=$row['title'];
                                        $category_id=$row['id'];

                                        //echo "<option value='$category_id'>$category_title</option>";
                                        ?>

                                        <option <?php if($current_category==$category_id){ echo "selected";}?>value="<?php echo $category_id?>"><?php echo $category_title?></option>

                                        <?php
                                    }
                                }
                                else{ //categories not available
                                    echo "<option value='0'>Category Not Available</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";}?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            //check if button is clicked
            if(isset($_POST['submit']))
            {
                // echo "button clicked";
                //a.get all details from form
                $id=$_POST['id'];
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $current_image=$_POST['current_image'];
                $current_category=$_POST['category'];
                
                $featured=$_POST['featured'];
                $active=$_POST['active'];
                
                //b.upload image if selected
                    //check if button clicked
                    if(isset($_FILES['image']['name']))  //upload button clicked
                    {
                        $image_name=$_FILES['image']['name']; //new image name

                        //check if image is available
                        if($image_name!="")
                        {
                            //part 1:image available and uploading image
                            $ext=end(explode('.',$image_name));
                            $image_name="Food-Name-".rand(0000,9999).'.'.$ext;

                            //get src path,dest path
                            $src=$_FILES['image']['tmp_name'];
                            $dest="../images/food/".$image_name;
                            $upload=move_uploaded_file($src,$dest);
                            if($upload==false) //uploading image failed
                            {
                                $_SESSION['upload']="<div class='error'>Failed to upload food image !</div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
                                die();
                            }

                            //part2:remove current image if present
                            if($current_image!="")
                            {
                                //remove image
                                $remove_path="../images/Food/".$current_image;
                                $remove=unlink($remove_path);

                                if($remove==false)
                                {
                                    $_SESSION[]="<div class='error'>Failed to remove current food image !</div>";
                                    header('location:'.SITEURL.'admin/manage-food.php');
                                    die();
                                }
                            }
                        }
                        else{ //image not selected
                            $image_name=$current_image;
                        }
                    }
                    else{ //upload button not clicked
                        $image_name=$current_image;
                    }

                

                //.update food in db and redirect
                $sql3="UPDATE tbl_food SET 
                    title='$title',
                    description='$description',
                    price=$price,
                    image_name='$image_name',
                    category_id='$current_category',
                    featured='$featured',
                    active='$active'
                    WHERE id=$id
                ";

                $res3=mysqli_query($con,$sql3);
                if($res3==true)
                {
                    $_SESSION['update']="<div class='success'>Food details updated successfully !</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else{
                    $_SESSION['update']="<div class='error'>Food details updation failed !</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php');?>