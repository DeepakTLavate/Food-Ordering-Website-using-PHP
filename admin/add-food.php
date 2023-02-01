<?php include('partials/menu.php');?>

<div class="main">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <!-- form to add food starts here  -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Enter Food Title">
                    </td>
                </tr>

                <tr>
                    <td>Food Description: </td>
                    <td>
                        <textarea name="description" id="" cols="30" rows="5" placeholder="Enter Description of Food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" > <!--number type doesnot allow text -->
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category" > <!-- creates dropdown menu-->

                            <?php
                                //php code to display categories present in database
                                //1.create sql query to get active categories
                                $sql="SELECT * FROM tbl_category WHERE active='Yes'";
                                //2.display on drop down menu
                                $res=mysqli_query($con,$sql);
                                
                                    $count=mysqli_num_rows($res); //checks if we have categories or not
                                    if($count>0) //we have categories
                                    {
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                            //get details of categories
                                            $id=$row['id'];
                                            $title=$row['title'];
                                            //we only need id,title as they are only displayed in dropdown
                                            ?>

                                            <option value="<?php echo $id;?>"><?php echo $title;?></option>

                                            <?php
                                        }
                                    }
                                    else{ //we do not have categories
                                        ?>
                                        <option value="0">No categories Found !</option>
                                        <?php
                                    }
                        
                            ?>
                            
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                
                
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- form to add food ends here  -->

        
        <?php //code to add data in db
            //check if button is clicked
            if(isset($_POST['submit']))
            {
                // echo "Button clicked";
                //1.get data from form
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $category=$_POST['category'];
                
                if(isset($_POST['featured'])) //checking if featured radio button selected or not
                {
                    $featured=$_POST['featured'];
                }
                else{
                    $featured="No";
                }

                if(isset($_POST['active']))  //checking if active radio button selected or not
                {
                    $active=$_POST['active'];
                }
                else{
                    $active="No";
                }

                //2.upload image if selected 
                    //check if select image clicked or not
                    //upload image only if it is selected
                    if(isset($_FILES['image']['name']))
                    {
                        //it means 'upload' button is selected
                        $image_name=$_FILES['image']['name'];

                        //check if image is selected to upload or not
                        if($image_name!="")
                        {
                            //image is selected to upload
                            //A.RENAME IMAGE IN 'IMAGES/FOOD' FOLDER
                            $ext=end(explode('.',$image_name));  //getting extension of image
                            $image_name="Food-Name-".rand(0000,9999).".".$ext; //create new image name
                            //B.UPLOAD IMAGE
                            $source_path=$_FILES['image']['tmp_name']; //current location of image
                            $destination_path="../images/Food/".$image_name;
                        }

                        //finally upload image
                        $upload=move_uploaded_file($source_path,$destination_path);

                        //check if image uploaded or not
                        if($upload==false) //failed to upload image
                        {
                            $_SESSION['upload']="<div class='error'>Image Upload Failed !</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                        }

                    }
                    else{
                        //set default name for image name, select button is not clicked
                        $image_name=""; 
                    }
                //3.execute query to insert data in db
                //create query
                $sql2="INSERT INTO tbl_food SET      
                title='$title',
                description='$description',
                price=$price,
                image_name='$image_name',
                category_id=$category,
                featured='$featured',
                active='$active'
                ";

                //execute query
                $res=mysqli_query($con,$sql2);

                if($res==true) //query execn successfull
                {
                    $_SESSION['add']="<div class='success'>Food Added Successfully !</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else{ //execn failed
                    $_SESSION['add']="<div class='error'>Failed to Add Food !</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }
        ?>
    </div>
</div>

<?php include('partials/footer.php');?>