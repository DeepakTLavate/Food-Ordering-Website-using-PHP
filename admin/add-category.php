<?php include('partials/menu.php');?>

<div class="main">
    <div class="wrapper">
        <h1>Add Category</h1><br><br>

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>
        
        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        <br><br>

        <!-- add category form starts here -->
        <form action="" method="POST" enctype="multipart/form-data"> <!--enctype allows us to upload images-->
            <table class="tbl-30">
                <tr>
                    <td>Category Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Enter category title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
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
                
                <tr><br></tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- add category form ends here -->

        <?php
            //1.check whether submit button is clicked
            if(isset($_POST['submit']))
            {
                // echo "clicked";

                //get value from form
                $title=$_POST['title'];

                //for radio input type,we need to check if button is selected or not
                if(isset($_POST['featured']))
                {
                    $featured=$_POST['featured'];
                }
                else{ //set default value as NO
                    $featured="No";
                }

                if(isset($_POST['active']))
                {
                    $active=$_POST['active'];
                }
                else{ //set default value as NO
                    $active="No";
                }

                //check if image is selected or not and set value of image name accordingly
                //print_r($_FILES['image']); //$_FILES is an array which cant be displayed by echo.So,we use print_r

                ///die();//break code

                if(isset($_FILES['image']['name']))
                {
                    //upload image
                    //to upload,we need image name,source path,destination path
                    $image_name=$_FILES['image']['name'];
                        //upload image if image is selected
                        if($image_name!="")
                        {

                        
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
                        header('location:'.SITEURL.'admin/add-category.php');
                        //stop process
                        die(); //so that data is not added to database
                    }
                    }
                }
                else{
                    //dont upload and set image name value as blank
                    $image_name="";
                }

                //2.create sql query to insert
                $sql="INSERT INTO tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
                ";

                //3.execute query
                $res=mysqli_query($con,$sql);
                    //whether query is executed successfully or not
                    if($res==TRUE)
                    {
                        //query executed and category added
                        $_SESSION['add']="<div class='success'>Category Added Successfully!</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                    else{
                        //failed to add category
                        $_SESSION['add']="<div class='error'>Failed to add Category!</div>";
                        header('location:'.SITEURL.admin/add-category.php);
                    }
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php');?>