<!-- following dry pattern-do not repeat yourself -->
<?php include('partials/menu.php'); ?>



        <!-- Main content Section starts -->
        <div class="main">
            <div class="wrapper">
                <h1>Manage Food</h1>
                <br>
                

                

                <!-- button to add food -->
                <a href="<?php echo SITEURL ?>admin/add-food.php" class="btn-primary">Add Food</a>
                <br><br><br>
            

                <?php
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
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
                    if(isset($_SESSION['removed']))
                    {
                        echo $_SESSION['removed'];
                        unset($_SESSION['removed']);
                    }
                ?>

                <?php
                    if(isset($_SESSION['removal']))
                    {
                        echo $_SESSION['removal'];
                        unset($_SESSION['removal']);
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
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                ?>

                <table class="tbl-full">
                    <tr>
                        <th>Sr.No.</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        //create sql query to get food detials
                        $sql="SELECT * FROM tbl_food";
                        $res=mysqli_query($con,$sql);
                        $count=mysqli_num_rows($res);
                        $sn=1;
                        if($count>0)
                        {
                            //we have food details in db
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id=$row['id'];
                                $title=$row['title'];
                                $price=$row['price'];
                                $image_name=$row['image_name'];
                                $featured=$row['featured'];
                                $active=$row['active'];

                                ?>
                                <tr>
                                    <td><?php echo $sn++;?></td>
                                    <td><?php echo $title;?></td>
                                    <td>₹<?php echo $price;?></td>
                                    <td>
                                        <?php 
                                            //cheeck if we have image
                                            if($image_name=="") //we dont have image
                                            {
                                                echo "<div class='error'>Food Image Not Added !</div>";
                                            }
                                            else{ //we have image
                                                ?>

                                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name;?>" width="150px" alt="">

                                                <?php
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $featured;?></td>
                                    <td><?php echo $active;?></td>
                                    <td>
                                        <a href="<?php echo SITEURL;?>admin/update-food.php? id=<?php echo $id;?>" class="btn-secondary">Update Food</a>
                                        <a href="<?php echo SITEURL ;?>admin/delete-food.php? id=<?php echo $id;?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete Food</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }
                        else{
                            //food details not added in db
                            echo "<tr><td colspan='7' class='error'>Food Not Added Yet !</td></tr>";
                        }
                    ?>

                    

                    
                </table>
                <div class="clear-fix"></div>
            </div>
            
        </div>
        <!-- Main content Section ends -->
<?php include('partials/footer.php'); ?>