<?php include('partials/menu.php')?>

        <!-- Main content Section starts -->
        <div class="main">
            <div class="wrapper">
                <h1>Manage Order</h1>
                <br>

                
                
                <br>

                <table class="tbl-full">
                    <tr>
                        <th>Sr.No.</th>
                        <th>Food</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Customer Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        //get all orders 
                        $sql="SELECT * FROM tbl_order order by id desc";
                        $res=mysqli_query($con,$sql);
                        $count=mysqli_num_rows($res);
                        $sn=1;
                        if($count>0)
                        {
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id=$row['id'];
                                $food=$row['food'];
                                $price=$row['price'];
                                $qty=$row['quantity'];

                                $total=$row['total'];
                                $order_date=$row['order_date'];
                                $status=$row['status']; //ordered,on delivery,delivered,cancelled

                                $customer_name=$row['customer_name'];
                                $customer_contact=$row['customer_contact'];
                                $customer_email=$row['customer_email'];
                                $customer_address=$row['customer_address'];
                            

                            ?>

                            <tr>
                                <td><?php echo $sn++;?></td>
                                <td><?php echo $food;?></td>
                                <td><?php echo $price;?></td>
                                <td><?php echo $qty;?></td>
                                <td><?php echo $total;?></td>
                                <td><?php echo $order_date;?></td>
                                <td><?php echo $status;?></td>
                                <td><?php echo $customer_name;?></td>
                                <td><?php echo $customer_contact;?></td>
                                <td><?php echo $customer_email;?></td>
                                <td><?php echo $customer_address;?></td>
                                <td>
                                    <a href="#" class="btn-secondary">Update Order</a>
                                    
                                </td>
                            </tr>
                            <?php

                            }
                        }
                        else{
                            echo "<tr><td colspan='12' class='error'>Orders not available</td></tr>";
                        }
                    ?>

                    

                    
                </table>
                <div class="clear-fix"></div>
            </div>
            
        </div>
        <!-- Main content Section ends -->
<?php include('partials/footer.php'); ?>