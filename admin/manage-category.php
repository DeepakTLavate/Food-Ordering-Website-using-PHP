<!-- following dry pattern-do not repeat yourself -->
<?php include('partials/menu.php');?>


        <!-- Main content Section starts -->
        <div class="main">
            <div class="wrapper">
                <h1>Manage Category</h1>
                <br>
                

                <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
                ?>
                
                <?php
                if(isset($_SESSION['remove']))
                {
                    echo $_SESSION['remove'];
                    unset($_SESSION['remove']);
                }
                ?>
                
                <?php
                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
                ?>
                
                <?php
                if(isset($_SESSION['no-category-found']))
                {
                    echo $_SESSION['no-category-found'];
                    unset($_SESSION['no-category-found']);
                }
                ?>
                
                <?php
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
                ?>
                
                <?php
                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
                ?>
                
                <?php
                if(isset($_SESSION['failed-remove']))
                {
                    echo $_SESSION['failed-remove'];
                    unset($_SESSION['failed-remove']);
                }
                ?><br><br>

                <!-- button to add admin -->
                <a href="<?php echo SITEURL ?>admin/add-category.php" class="btn-primary">Add Category</a>
                <br>
                <br>
                <br>
                <table class="tbl-full">
                    <tr>
                        <th>Sr.No.</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                    </tr>

                    <?php
                        //query to get category details from db
                        $sql="SELECT * FROM tbl_category";

                        //execute query
                        $res=mysqli_query($con,$sql);

                        //count rows
                        $count=mysqli_num_rows($res);

                        //create serial number variable
                        $sn=1;

                        //check if data is present in db or not
                        if($count>0)
                        {
                            //we have data in db
                            //get data from db and display

                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id=$row['id'];
                                $title=$row['title'];
                                $image_name=$row['image_name'];
                                $featured=$row['featured'];
                                $active=$row['active'];

                                ?>

                            <tr>
                                <td><?php echo $sn++;?></td>
                                <td><?php echo $title;?></td>
                                <td>
                                    <?php 
                                        //check whether image name is available or not
                                        if($image_name!="")
                                        {
                                            //display image
                                            ?>

                                            <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" width="100px" >

                                            <?php
                                        }
                                        else{
                                            //display message
                                            echo "<div class='error'>No Image Added!</div>";
                                        }
                                    ?>
                                </td>
                                <td><?php echo $featured;?></td>
                                <td><?php echo $active;?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-category.php ?id=<?php echo $id;?>" class="btn-secondary">Update Category</a>
                                    <a href="<?php echo SITEURL ;?>admin/delete-category.php ?id=<?php echo $id;?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete Category</a>
                                </td>
                            </tr>

                                <?php
                            }
                        }
                        else{
                            //we dont have data
                            //we will display message inside table
                            ?>
                            <tr>
                                <td colspan="6"><div class="error">No such category added!</div></td>
                            </tr>
                            <?php
                        }
                    ?>

                    

                    
                </table>
                <div class="clear-fix"></div>
            </div>
            
        </div>
        <!-- Main content Section ends -->
<?php include('partials/footer.php'); ?>