<?php include('partials-front/menu.php');?>


    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                //create sql query to display categories from db
                $sql="SELECT * FROM tbl_category where active='Yes' AND featured='Yes' LIMIT 3 ";
                $res=mysqli_query($con,$sql); //executing query
                $count=mysqli_num_rows($res); //count rows to check if cattegories available in db
                if($count>0) //categories are available in db
                {
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get values like title,image_name,id
                        $id=$row['id'];
                        $title=$row['title'];
                        $image_name=$row['image_name'];
                        ?>

                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id;?>">
                            <div class="box-3 float-container">
                                <?php
                                //first check if image is available or not
                                    if($image_name=="")
                                    {   //image is not available
                                        echo "<div class='error'>Image not available !</div>";
                                    }
                                    else{  //image is available
                                        ?>
                                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name;?>" class="img-responsive img-curve">
                                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                        <?php
                                        
                                    }
                                ?>
                                

                                
                            </div>
                        </a>

                        <?php
                    }
                }
                else{ //categories not available
                    echo "<div class='error'>No category available !</div>";
                }
            ?>

            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                //getting foods from db that are active and featured
                $sql2="SELECT * FROM tbl_food WHERE active='Yes' and featured='Yes' LIMIT 6";
                $res2=mysqli_query($con,$sql2);
                $count2=mysqli_num_rows($res2);
                if($count2>0) //food available
                {
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        //get all values like title,price,description
                        $title=$row2['title'];
                        $id=$row2['id'];
                        $price=$row2['price'];
                        $description=$row2['description'];
                        $image_name=$row2['image_name'];
                    

                    ?>
                    
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                                if($image_name=="")
                                {
                                    echo "<div class='error'>No food image available !</div>";
                                    
                                }
                                else{
                                    ?>

                                    <img src="<?php echo SITEURL; ?>/images/Food/<?php echo $image_name; ?>"  class="img-responsive img-curve">
                                    <?php
                                }
                            ?>

                            
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">₹<?php echo $price; ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
                }
                else{ //no food available
                    echo "<div class='error'>No Food available !</div>";
                }
            ?>

            

            


            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php');?>   