<?php include('partials-front/menu.php');?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                //display categories that are active
                $sql="SELECT * FROM tbl_category WHERE active='Yes'";
                $res=mysqli_query($con,$sql);
                $count=mysqli_num_rows($res);
                if($count>0)
                {
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get details like id,title,image_name
                        $title=$row['title'];
                        $image_name=$row['image_name'];
                        $id=$row['id'];

                        ?>

                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id;?>">
                            <div class="box-3 float-container">
                                <?php
                                    if($image_name=="")
                                    {
                                        echo "<div class='error'>No image available !</div>";
                                        
                                    }
                                    else{
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name;?>" alt="Pizza" class="img-responsive img-curve">
                                        <h3 class="float-text text-white"><?php echo $title;?></h3>
                                        <?php
                                        
                                    }
                                    
                                ?>
                                

                                
                            </div>
                        </a>

                        <?php
                    }
                }
                else{
                    echo "<div class='error'>No category available !</div>";
                }
            ?>

            

            
            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    <?php include('partials-front/footer.php');?>  